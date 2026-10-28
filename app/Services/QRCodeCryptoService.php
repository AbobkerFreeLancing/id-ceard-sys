<?php

namespace App\Services;

use App\Models\Card;

class QRCodeCryptoService
{
    /**
     * Generate a tamper-proof cryptographically signed QR payload for a card.
     */
    public function generatePayload(Card $card): string
    {
        $payloadData = [
            'uid' => $card->card_uid,
            'cid' => $card->cardholder_id,
            'exp' => $card->expires_at ? $card->expires_at->timestamp : null,
            'iss' => $card->issued_at ? $card->issued_at->timestamp : now()->timestamp,
            'v' => 1,
        ];

        $rawString = $this->buildSignatureString($payloadData);
        $signature = hash_hmac('sha256', $rawString, config('app.key'));

        $payloadData['sig'] = substr($signature, 0, 32); // Shortened 32-char HMAC signature for QR density

        return json_encode($payloadData, JSON_UNESCAPED_SLASHES);
    }

    /**
     * Verify the integrity of a scanned QR payload.
     *
     * @return array{is_valid: bool, reason: string|null, uid: string|null, payload: array|null}
     */
    public function verifyPayload(string $rawPayload): array
    {
        $data = json_decode($rawPayload, true);

        if (! is_array($data) || empty($data['uid']) || empty($data['sig'])) {
            return [
                'is_valid' => false,
                'reason' => 'Invalid QR payload format or missing signature.',
                'uid' => null,
                'payload' => null,
            ];
        }

        $providedSignature = $data['sig'];
        unset($data['sig']);

        $expectedRawString = $this->buildSignatureString($data);
        $expectedSignature = substr(hash_hmac('sha256', $expectedRawString, config('app.key')), 0, 32);

        if (! hash_equals($expectedSignature, $providedSignature)) {
            return [
                'is_valid' => false,
                'reason' => 'Signature mismatch - potential forgery detected.',
                'uid' => $data['uid'] ?? null,
                'payload' => $data,
            ];
        }

        return [
            'is_valid' => true,
            'reason' => null,
            'uid' => $data['uid'],
            'payload' => $data,
        ];
    }

    protected function buildSignatureString(array $data): string
    {
        return implode('|', [
            $data['uid'] ?? '',
            $data['cid'] ?? '',
            $data['exp'] ?? '',
            $data['iss'] ?? '',
        ]);
    }
}

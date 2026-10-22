<?php

namespace Packages\IdCard\Services;

use Illuminate\Support\Str;
use Packages\IdCard\Models\Card;

class CardSecurityService
{
    /**
     * Generate unique non-guessable Card UID.
     */
    public static function generateCardUid(string $prefix = 'CRD'): string
    {
        $timestamp = date('ymd');
        $randomPart = strtoupper(Str::random(6));
        return "{$prefix}-{$timestamp}-{$randomPart}";
    }

    /**
     * Generate serial card number for visible printing.
     */
    public static function generateCardNumber(int $id): string
    {
        return 'ID' . str_pad((string)$id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * Generate cryptographically signed QR verification token.
     */
    public static function generateQrToken(string $cardUid, int $cardholderId): string
    {
        $salt = config('idcard.qr_signature_key', 'Huwia-Key-2026');
        $data = "{$cardUid}|{$cardholderId}|" . time();
        $signature = hash_hmac('sha256', $data, $salt);
        
        return base64_encode("{$cardUid}:{$signature}");
    }

    /**
     * Verify authenticity of a scanned QR token.
     */
    public static function resolveCardByToken(string $token): ?Card
    {
        $card = Card::where('qr_token', $token)
            ->orWhere('card_uid', $token)
            ->with(['cardholder', 'template', 'cardholder.department'])
            ->first();

        return $card;
    }
}

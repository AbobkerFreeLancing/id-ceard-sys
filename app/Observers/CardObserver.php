<?php

namespace App\Observers;

use App\Models\Card;
use App\Services\QRCodeCryptoService;
use Illuminate\Support\Str;

class CardObserver
{
    public function creating(Card $card): void
    {
        if (empty($card->card_uid)) {
            $card->card_uid = 'CARD-'.now()->format('Y').'-'.strtoupper(Str::random(6));
        }

        if (empty($card->issued_at)) {
            $card->issued_at = now();
        }

        if (empty($card->qr_payload)) {
            $crypto = app(QRCodeCryptoService::class);
            $card->qr_payload = $crypto->generatePayload($card);
        }
    }
}

<?php

namespace Packages\IdCard\Livewire;

use Livewire\Component;
use Packages\IdCard\Enums\VerificationStatusEnum;
use Packages\IdCard\Models\Card;
use Packages\IdCard\Models\VerificationLog;
use Packages\IdCard\Services\CardSecurityService;

class CardVerificationScanner extends Component
{
    public string $scannedCode = '';
    public ?Card $resolvedCard = null;
    public ?VerificationStatusEnum $status = null;
    public bool $hasChecked = false;
    public ?string $errorMessage = null;

    public function verify(): void
    {
        $this->reset(['resolvedCard', 'status', 'errorMessage']);
        $this->hasChecked = true;

        $token = trim($this->scannedCode);

        if (empty($token)) {
            $this->status = VerificationStatusEnum::InvalidToken;
            $this->errorMessage = __('idcard::idcard.err_empty_code');
            return;
        }

        $card = CardSecurityService::resolveCardByToken($token);

        if (!$card) {
            $this->status = VerificationStatusEnum::InvalidToken;
            $this->errorMessage = __('idcard::idcard.err_card_not_found');
            $this->logVerification(null, $token, VerificationStatusEnum::InvalidToken);
            return;
        }

        $this->resolvedCard = $card;

        // Check validity
        if ($card->status->value === 'revoked' || $card->status->value === 'lost') {
            $this->status = VerificationStatusEnum::Revoked;
        } elseif ($card->status->value === 'suspended') {
            $this->status = VerificationStatusEnum::Suspended;
        } elseif ($card->isExpired()) {
            $this->status = VerificationStatusEnum::Expired;
        } elseif ($card->status->value === 'active' || $card->status->value === 'printed') {
            $this->status = VerificationStatusEnum::Valid;
        } else {
            $this->status = VerificationStatusEnum::InvalidToken;
        }

        $this->logVerification($card->id, $token, $this->status);
    }

    protected function logVerification(?int $cardId, string $token, VerificationStatusEnum $status): void
    {
        if (!config('idcard.verification.log_ip', true)) {
            return;
        }

        VerificationLog::create([
            'card_id' => $cardId,
            'scanned_token' => substr($token, 0, 100),
            'verifier_user_id' => auth()->id(),
            'verification_status' => $status,
            'scanner_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => request()->header('sec-ch-ua-mobile') === '?1' ? 'Mobile' : 'Desktop',
            'scanned_at' => now(),
        ]);
    }

    public function resetScanner(): void
    {
        $this->reset(['scannedCode', 'resolvedCard', 'status', 'hasChecked', 'errorMessage']);
    }

    public function render()
    {
        return view('idcard::livewire.card-verification-scanner')
            ->layout('layouts.frontend');
    }
}

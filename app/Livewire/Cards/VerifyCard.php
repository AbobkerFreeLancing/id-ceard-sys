<?php

namespace App\Livewire\Cards;

use App\Enums\CardStatus;
use App\Enums\VerificationResult;
use App\Models\Card;
use App\Models\VerificationLog;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('التحقق الذكي من البطاقة | Huwia ID')]
class VerifyCard extends Component
{
    public string $scannedUid = '';

    public ?Card $card = null;

    public ?string $result = null;

    public ?string $resultMessage = null;

    public bool $hasChecked = false;

    public function mount(?string $uid = null): void
    {
        if ($uid) {
            $this->scannedUid = $uid;
            $this->verify();
        }
    }

    public function verify(): void
    {
        $cleanUid = trim($this->scannedUid);

        if (empty($cleanUid)) {
            $this->addError('scannedUid', 'الرجاء إدخال أو مسح رمز البطاقة UID أولاً.');

            return;
        }

        $this->resetErrorBag();
        $this->hasChecked = true;

        $this->card = Card::with(['cardholder.organization', 'cardholder.department', 'template'])
            ->where('card_uid', $cleanUid)
            ->first();

        if (! $this->card) {
            $this->result = 'unknown';
            $this->resultMessage = 'رمز البطاقة غير مسجل في النظام أو محاولة تزوير محتملة.';

            VerificationLog::create([
                'card_id' => null,
                'scanned_uid' => $cleanUid,
                'result' => VerificationResult::Unknown,
                'ip_address' => request()->ip(),
                'device_id' => request()->userAgent() ? substr(request()->userAgent(), 0, 100) : null,
                'scanned_at' => now(),
            ]);

            return;
        }

        // Check Card Status
        if ($this->card->status === CardStatus::Revoked || $this->card->status === CardStatus::Lost) {
            $this->result = 'revoked';
            $this->resultMessage = 'هذه البطاقة ملغاة أو مسحوبة أمنياً، وغير صالحة للاستخدام.';
            $logResult = VerificationResult::Revoked;
        } elseif ($this->card->expires_at && $this->card->expires_at->isPast()) {
            $this->result = 'expired';
            $this->resultMessage = 'صلاحية هذه البطاقة منتهية منذ '.$this->card->expires_at->format('Y-m-d').'.';
            $logResult = VerificationResult::Expired;
        } elseif ($this->card->status === CardStatus::Active) {
            $this->result = 'valid';
            $this->resultMessage = 'البطاقة صالحة ومطابقة ومصرح بها رسمياً.';
            $logResult = VerificationResult::Valid;
        } else {
            $this->result = 'suspended';
            $this->resultMessage = 'البطاقة في حالة مؤقتة غير نشطة: '.$this->card->status->getLabel();
            $logResult = VerificationResult::Unknown;
        }

        // Record verification audit log
        VerificationLog::create([
            'card_id' => $this->card->id,
            'scanned_uid' => $cleanUid,
            'result' => $logResult,
            'ip_address' => request()->ip(),
            'device_id' => request()->userAgent() ? substr(request()->userAgent(), 0, 100) : null,
            'scanned_at' => now(),
        ]);
    }

    public function resetVerification(): void
    {
        $this->scannedUid = '';
        $this->card = null;
        $this->result = null;
        $this->resultMessage = null;
        $this->hasChecked = false;
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.cards.verify-card')
            ->layout('layouts.app');
    }
}

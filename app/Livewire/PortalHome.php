<?php

namespace App\Livewire;

use App\Enums\CardStatus;
use App\Enums\VerificationResult;
use App\Models\Card;
use App\Models\Cardholder;
use App\Models\Organization;
use App\Models\VerificationLog;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('منظومة هوية ID | المنصة المتكاملة لإدارة وفحص البطاقات الذكية')]
class PortalHome extends Component
{
    public string $quickUid = '';

    public function quickVerify(): void
    {
        $clean = trim($this->quickUid);
        if (! empty($clean)) {
            $this->redirectRoute('cards.verify', ['uid' => $clean]);
        }
    }

    public function render(): View
    {
        $stats = [
            'organizations' => Organization::count(),
            'cardholders' => Cardholder::count(),
            'active_cards' => Card::where('status', CardStatus::Active)->count(),
            'valid_scans' => VerificationLog::where('result', VerificationResult::Valid)->count(),
        ];

        $latestCards = Card::with(['cardholder.organization', 'template'])
            ->where('status', CardStatus::Active)
            ->latest('id')
            ->take(3)
            ->get();

        return view('livewire.portal-home', [
            'stats' => $stats,
            'latestCards' => $latestCards,
        ])->layout('layouts.app');
    }
}

<?php

namespace App\Livewire\Reissues;

use App\Models\CardReissue;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('تتبع طلب إعادة الإصدار | Huwia ID')]
class TrackReissue extends Component
{
    public string $queryInput = '';

    public ?CardReissue $reissue = null;

    public bool $searched = false;

    public function search(): void
    {
        $input = trim($this->queryInput);

        if (empty($input)) {
            $this->addError('queryInput', 'الرجاء إدخال الرقم القومي أو رمز البطاقة السابقة UID.');

            return;
        }

        $this->resetErrorBag();
        $this->searched = true;

        $this->reissue = CardReissue::with([
            'oldCard.cardholder.organization',
            'oldCard.cardholder.department',
            'oldCard.template',
            'newCard',
            'requester',
            'approver',
        ])
            ->whereHas('oldCard', function ($q) use ($input) {
                $q->where('card_uid', $input)
                    ->orWhereHas('cardholder', fn ($c) => $c->where('national_id', $input));
            })
            ->latest('id')
            ->first();
    }

    public function resetSearch(): void
    {
        $this->queryInput = '';
        $this->reissue = null;
        $this->searched = false;
        $this->resetErrorBag();
    }

    public function render(): View
    {
        return view('livewire.reissues.track-reissue')
            ->layout('layouts.app');
    }
}

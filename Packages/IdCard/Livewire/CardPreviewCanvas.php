<?php

namespace Packages\IdCard\Livewire;

use Livewire\Component;
use Packages\IdCard\Models\Card;
use Packages\IdCard\Models\CardTemplate;

class CardPreviewCanvas extends Component
{
    public ?Card $card = null;
    public ?CardTemplate $template = null;
    public string $currentSide = 'front'; // 'front' or 'back'

    public function mount(?Card $card = null, ?CardTemplate $template = null): void
    {
        $this->card = $card;
        $this->template = $template ?? $card?->template;
    }

    public function toggleSide(): void
    {
        $this->currentSide = $this->currentSide === 'front' ? 'back' : 'front';
    }

    public function render()
    {
        $elements = $this->template
            ? ($this->currentSide === 'front' ? $this->template->frontElements : $this->template->backElements)
            : collect();

        return view('idcard::livewire.card-preview-canvas', [
            'elements' => $elements,
        ]);
    }
}

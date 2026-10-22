<?php

namespace App\Livewire\Pages;

use App\Models\PrivacyPage;
use Livewire\Component;

class PrivacyPolicyPage extends Component
{
    public $page;

    public function render()
    {
        $this->page = PrivacyPage::first();
        
        return view('livewire.pages.privacy-policy-page')
        ->layout('layouts.frontend');
    }
}

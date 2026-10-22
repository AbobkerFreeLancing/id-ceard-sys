<?php

namespace App\Livewire\Pages;

use Packages\Common\Models\Dev;
use Livewire\Component;

class WelcomePage extends Component
{
    public function toggleAction() {}

    public function render()
    {
        $record = Dev::first();
        return view('livewire.pages.welcome-page', compact('record'))->layout('layouts.frontend');
    }
}

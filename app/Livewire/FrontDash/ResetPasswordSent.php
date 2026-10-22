<?php

namespace App\Livewire\FrontDash;

use Livewire\Component;

class ResetPasswordSent extends Component
{
    public function render()
    {
        return view('livewire.front-dash.reset-password-sent')
        ->layout('layouts.frontend');
    }
}

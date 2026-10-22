<?php

namespace App\Livewire\FrontDash;

use Livewire\Component;

class FrontDashboard extends Component
{
    public $stats = [];

    public function render()
    {
        $this->stats = [];
        return view('livewire.front-dash.front-dashboard')
        ->layout('layouts.frontend');
    }
}

<?php

namespace App\Livewire\FrontDash;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FrontLogout extends Component
{
    public function mount()
    {
        Auth::guard('customers')->logout();
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.front-dash.front-logout');
    }
}

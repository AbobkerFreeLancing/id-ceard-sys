<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class HeaderComponent extends Component
{
    
    public function render()
    {
        $ds = [
            'admin' => filament()?->getPanel('admin')?->getLoginUrl(),
            'verify' => route('idcard.scanner'),
        ];

        return view('livewire.header-component', compact(['ds']));
    }
}

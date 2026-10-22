<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class HeaderComponent extends Component
{
    
    public function logout(Request $request)
    {
        Auth::guard('seekers')->logout();
        return redirect(filament()->getPanel('seeker')->getLoginUrl());
    }

    public function render()
    {
        $ds = [
            'user' => filament()?->getPanel('admin')?->getLoginUrl(),
            'student' => filament()?->getPanel('student')?->getLoginUrl(),
            'guardian' => filament()?->getPanel('guardian')?->getLoginUrl(),
        ];

        return view('livewire.header-component',compact(['ds']));
    }
}

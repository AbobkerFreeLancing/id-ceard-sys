<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class HomePage extends Component
{
    public function mount() {}

    public function render()
    {
        $dash_list = [
            [
                'type' => 'guardian',
                'title' => 'حساب ولي الأمر',
                'url' => filament()?->getPanel('guardian')?->getLoginUrl(),
                'info' => 'استخدم البريد الإلكتروني لدخول حسابك',
            ],
            [
                'type' => 'student',
                'title' => 'حساب الطالب',
                'url' => filament()?->getPanel('student')?->getLoginUrl(),
                'info' => 'استخدم الرقم الأكاديمي لدخول حسابك',
            ],
        ];
        return view('livewire.pages.home-page', compact(['dash_list']))->layout('layouts.frontend');
    }
}

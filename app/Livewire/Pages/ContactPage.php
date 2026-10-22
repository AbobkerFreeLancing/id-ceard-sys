<?php

namespace App\Livewire\Pages;

use App\Models\ContactPage as ContactPageModel;
use Livewire\Component;

class ContactPage extends Component
{
    public $page;

    public function render()
    {
        $this->page = ContactPageModel::first();
        
        return view('livewire.pages.contact-page')
        ->layout('layouts.frontend');
    }
}

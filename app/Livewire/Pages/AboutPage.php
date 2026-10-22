<?php

namespace App\Livewire\Pages;

use App\Models\AboutPage as AboutPageModel;
use Livewire\Component;

class AboutPage extends Component
{
    public $page;

    public function render()
    {
        $this->page = AboutPageModel::first();

        return view('livewire.pages.about-page')->layout('layouts.frontend');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LinkWidget extends Component
{
    public function __construct(public $title, public $url)
    {
    }

    public function render()
    {
        return view('components.link-widget');
    }
}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StatWidget extends Component
{
    public function __construct(public $title, public $subtitle, public $color, public $icon = 'library')
    {
    }

    public function render()
    {
        return view('components.stat-widget');
    }
}

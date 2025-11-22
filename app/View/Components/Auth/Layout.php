<?php

namespace App\View\Components\Auth;

use Illuminate\View\Component;

class Layout extends Component
{
    public $title;

    public function __construct($title = null)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('auth.layout');
    }
}

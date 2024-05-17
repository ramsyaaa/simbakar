<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarLink extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $url, $text;

    public function __construct($url, $text)
    {
        $this->url = $url;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public function render()
    {
        return view('components.sidebar-link');
    }
}

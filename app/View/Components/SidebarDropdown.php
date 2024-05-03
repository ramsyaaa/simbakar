<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarDropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $icon, $title, $links;
    public function __construct($icon=null, $title, $links)
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sidebar-dropdown');
    }
}

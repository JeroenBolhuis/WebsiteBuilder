<?php

namespace App\View\Components\Header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\NavItem;

class NavigationBar extends Component
{
    public $nav_items;
    
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->nav_items = NavItem::all()->sortBy('order');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header.navigation-bar');
    }
}

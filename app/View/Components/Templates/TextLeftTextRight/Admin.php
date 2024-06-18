<?php

namespace App\View\Components\Templates\TextLeftTextRight;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Admin extends Component
{
    public $input_names = [
        'tekst_links',
        'tekst_rechts',
        'achtergrondkleur',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.text-left-text-right.admin');
    }
}

<?php

namespace App\View\Components\Templates\TextLeftMediaRight;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Admin extends Component
{
    public $input_names = [
        'tekst',
        'media',
        'media_url',
        'media_title',
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
        return view('components.templates.text-left-media-right.admin');
    }
}

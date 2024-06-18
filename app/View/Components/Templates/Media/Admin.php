<?php

namespace App\View\Components\Templates\Media;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Admin extends Component
{
    public $input_names = [
        'afbeelding',
        'media_url',
        'media_title',
        'width'
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
        return view('components.templates.media.admin');
    }
}

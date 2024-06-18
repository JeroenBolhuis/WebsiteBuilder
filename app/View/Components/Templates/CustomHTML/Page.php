<?php

namespace App\View\Components\Templates\CustomHtml;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Page extends Component
{
    public $html;
    /**
     * Create a new component instance.
     */
    public function __construct($template)
    {
        $this->html = $template->pivot->data->html;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.custom-html.page');
    }
}

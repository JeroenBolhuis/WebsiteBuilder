<?php

namespace App\View\Components\Head;

use Closure;
use App\Models\Page;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class TextEditorConfig extends Component
{
    public $pages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->pages = Page::active()->orderBy('isRegularPage', 'desc')->get()->groupBy('isRegularPage');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.head.text-editor-config');
    }
}

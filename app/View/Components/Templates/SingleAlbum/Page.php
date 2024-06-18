<?php

namespace App\View\Components\Templates\SingleAlbum;

use Closure;
use App\Models\Album;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Page extends Component
{
    public ?Album $album;

    /**
     * Create a new component instance.
     */

    public function __construct($template)
    {
        $this->album = Album::active()->find($template->pivot->data->album_id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.single-album.page');
    }
}

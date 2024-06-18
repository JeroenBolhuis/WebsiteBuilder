<?php

namespace App\View\Components\Templates\SingleAlbum;

use Closure;
use App\Models\Album;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Admin extends Component
{
    public $input_names = [
        'album_id',
    ];

    public $albums = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->albums = Album::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.single-album.admin');
    }
}

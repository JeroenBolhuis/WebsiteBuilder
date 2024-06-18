<?php

namespace App\View\Components\Templates\Albums;

use Closure;
use Carbon\Carbon;
use App\Models\Album;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Page extends Component
{
    public $albums, $years;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->albums = Album::active()
            ->orderByDesc('album_date')
            ->get();

        $this->years = $this->albums
            ->pluck('album_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y');
            })
            ->unique()
            ->sortByDesc(function ($year) {
                return (int) $year;
            });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.albums.page');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Page;

class PageFilter extends Component
{
    public $activeFilter = [true, false];

    public function render()
    {
        $pages = Page::whereIn('isActive', $this->activeFilter)
            ->where('isRegularPage', true)
            ->orderBy('isHomepage', 'desc')
            ->get();

        return view('livewire.page-filter', compact('pages'));
    }
}

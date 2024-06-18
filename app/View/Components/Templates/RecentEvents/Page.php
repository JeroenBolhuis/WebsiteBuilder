<?php

namespace App\View\Components\Templates\RecentEvents;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Page extends Component
{

    public $events;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->events = Event::active()->orderBy('date', 'desc')->limit(4)->get();
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.recent-events.page');
    }
}

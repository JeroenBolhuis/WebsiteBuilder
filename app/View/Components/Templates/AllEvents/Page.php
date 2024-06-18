<?php

namespace App\View\Components\Templates\AllEvents;

use Closure;
use App\Models\Event;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Page extends Component
{
    public $events;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->events = Event::active()->paginate(10);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.all-events.page');
    }
}

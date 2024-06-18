<?php

namespace App\View\Components\Templates\SingleEvent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Event;

class Admin extends Component
{
    public $input_names = [
        'event_id',
    ];

    public $events = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->events = Event::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.single-event.admin');
    }
}

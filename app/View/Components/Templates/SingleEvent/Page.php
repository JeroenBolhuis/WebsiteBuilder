<?php

namespace App\View\Components\Templates\SingleEvent;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Event;

class Page extends Component
{
    public ?Event $event;

    /**
     * Create a new component instance.
     */

    public function __construct($template, $event = null)
    {
        if ($event) {
            $this->event = $event;
            return;
        }

        $this->event = Event::active()->find($template->pivot->data->event_id);
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.single-event.page');
    }
}

<?php

namespace App\View\Components\Templates\SponsorSlider;

use Closure;
use App\Models\Sponsor;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Page extends Component
{
    public $sponsors;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->sponsors = Sponsor::active()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.sponsor-slider.page');
    }
}

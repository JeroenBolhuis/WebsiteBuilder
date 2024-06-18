<?php

namespace App\View\Components;

use App\Helpers\MediaHelper;
use Closure;
use App\Models\Footer;
use App\Models\SocialAccount;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class FooterComponent extends Component
{
    public $footer;
    public $socials;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->footer = Footer::firstOrNew();
        $this->socials = SocialAccount::all();

        if (is_null($this->footer->image)) {
            $this->footer->image = MediaHelper::getNoImage();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.footer-component');
    }
}

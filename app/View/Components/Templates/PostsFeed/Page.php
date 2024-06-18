<?php

namespace App\View\Components\Templates\PostsFeed;

use Closure;
use App\Models\Post;
use App\Models\Sponsor;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Page extends Component
{
    public $posts, $sponsors, $availableSponsors;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->posts = Post::active()->orderBy('created_at', 'desc')->paginate(12);
        $this->sponsors = Sponsor::active()->get();
        $this->availableSponsors = $this->sponsors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.posts-feed.page');
    }

    /**
     * Calculate and return slide sponsors.
     */
    public function getSlideSponsors(): \Illuminate\Support\Collection
    {
        $slideSponsors = collect();

        while ($slideSponsors->count() < min(2, $this->sponsors->count())) {
            if ($this->availableSponsors->isEmpty()) {
                $this->availableSponsors = $this->sponsors;
            }

            if (!$this->availableSponsors->isEmpty()) {
                $randomSponsor = $this->availableSponsors->diff($slideSponsors)->random(1);
                $slideSponsors = $slideSponsors->merge($randomSponsor);
                $this->availableSponsors = $this->availableSponsors->diff($randomSponsor);
            }
        }

        if ($this->availableSponsors->isEmpty()) {
            $this->availableSponsors = $this->sponsors;
        }

        return $slideSponsors;
    }

    /**
     * Get the count of available sponsors.
     */
    public function getAvailableSponsorsCount(): int
    {
        return $this->availableSponsors->count();
    }
}

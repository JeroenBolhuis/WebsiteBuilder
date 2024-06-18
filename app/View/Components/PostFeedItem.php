<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PostFeedItem extends Component
{
    private $maxDescCharacters = 100;
    public $post;

    /**
     * Create a new component instance.
     */
    public function __construct($post)
    {
        $this->post = $post;

        if ($this->post->description) {
            $truncatedDescription = $this->getTruncatedDescription();
            $this->post->description = $truncatedDescription->text;
            $this->post->isLongDescription = $truncatedDescription->isLong;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.post-feed-item');
    }

    /**
     * Get the post description. If the description is longer than the maxDescCharacters, it will be truncated.
     */
    public function getTruncatedDescription(): object
    {
        $description = strip_tags($this->post->description);
        $isLong = strlen($description) > $this->maxDescCharacters;

        if ($isLong) {
            $truncatedDescription = Str::limit(nl2br($description), $this->maxDescCharacters, '...');
        } else {
            $truncatedDescription = nl2br($this->post->description);
        }

        return (object) [
            'isLong' => $isLong,
            'text' => $truncatedDescription,
        ];
    }
}

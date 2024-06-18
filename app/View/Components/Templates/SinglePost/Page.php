<?php

namespace App\View\Components\Templates\SinglePost;

use Closure;
use App\Models\Post;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Page extends Component
{
    public ?Post $post;

    /**
     * Create a new component instance.
     */
    public function __construct($template)
    {
        $this->post = Post::active()->find($template->pivot->data->post_id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.single-post.page');
    }
}

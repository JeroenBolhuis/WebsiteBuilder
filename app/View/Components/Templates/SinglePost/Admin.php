<?php

namespace App\View\Components\Templates\SinglePost;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Admin extends Component
{
    public $input_names = [
        'post_id',
    ];

    public $posts = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->posts = Post::active()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.templates.single-post.admin');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\PostCategory;
use Livewire\WithPagination;

class PostFilter extends Component
{
    use WithPagination;

    public $isSent;
    public $isActive;
    public $isAccepted;
    public $sortBy = 'created_at_desc';
    public $category = '';


    public function render()
    {
        $postCategories = PostCategory::all();
        $query = Post::query();

        if ($this->isSent) {
            $query->where('isSent', true);
        }

        if ($this->isActive) {
            $query->where('isActive', true);
        }

        if ($this->isAccepted) {
            $query->where('isAccepted', true);
        }
        
        if ($this->sortBy === 'created_at_desc') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        if ($this->category) {
            if($this->category === 'null')
            {
                $this->category = null;
            }
            $query->where('post_category_id', $this->category);
        }
 
        $posts = $query->paginate(10);

        return view('livewire.post-filter', compact('posts', 'postCategories'));
    }
}


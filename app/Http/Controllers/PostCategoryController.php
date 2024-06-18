<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;


class PostCategoryController extends Controller
{

    public function index()
    {
        return view('postCategory.index');
    }

    public function store()
    {
        $postCategory = $this->validatePostCategory();

        PostCategory::create($postCategory);

        return back();
    }

    public function update(int $id)
    {
        $postCategory = PostCategory::findOrFail($id);
        $postCategory->update($this->validatePostCategory());

        return back();
    }

    private function validatePostCategory()
    {
        return request()->validate([
            'name' => ['required', 'string', 'max:55', 'unique:post_categories,name'],
        ]);
    }
}

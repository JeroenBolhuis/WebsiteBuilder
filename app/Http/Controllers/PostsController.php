<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Helpers\SentMediaHelper;
use App\Models\PreventSpamPost;
use Illuminate\Support\Facades\Storage;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Hash;

class PostsController extends SoftDeletesController
{
    public function __construct()
    {
        parent::__construct(Post::class);
    }
    
    public function show(string $slug = null)
    {
        if (auth()->user()) {
            $post = Post::slug($slug)->first();
        } else {
            $post = Post::slug($slug)->active()->first();
        }

        if (!$post) {
            return view('errors.404', ['message' => 'De post die je zoekt bestaat niet.']);
        }

        return view('post.show', compact('post'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('post.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create', [
            'categories' => PostCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $postData = $this->validatePost();
        $postData['isSent'] = false;
        $postData['isAccepted'] = true;

        $post = Post::create($postData);

        if (request()->has('images')) {
            foreach (request()->images as $index => $image) {
                $post->media()->attach($image, ['order' => $index]);
            }
        }

        return redirect()->route('post.index')->with('success', 'De post is succesvol aangemaakt.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'), [
            'categories' => PostCategory::all(),
        ]);
    }


    public function send()
    {
        return view('post.send', [
            'categories' => PostCategory::all(),
        ]); 
    }

    public function storeSend()
    {
        if (PreventSpamPost::isSpam(request()->ip())) {
            return redirect()->route('post.send')->with('error', 'Je hebt te snel achter elkaar geprobeerd een post te versturen.');
        }

        PreventSpamPost::create([
            'ip_address' =>  Hash::make(request()->ip()),
        ]);

        $slug = Str::slug(request()->title, '-');

        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        request()->merge(['slug' => $slug]);

        $postData = $this->validatePost();

        request()->validate([
            'images.*' => ['mimes:jpeg,jpg,png,gif,svg,mp4', 'max:10240'],
        ]);

        $postData['isSent'] = true;
        $postData['isAccepted'] = false;

        $post = Post::create($postData);

        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $index => $image) {
                $filename = Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();

                $image->storeAs('public/posts/' . $post->slug, $filename);
            }
        }

        return redirect()->route('post.send')->with('success', 'De post is succesvol ingestuurd.');
    }

    public function showSent(Post $post)
    {
        $media = SentMediaHelper::getSentMedia($post->slug);

        return view('post.show-sent', [
            'post' => $post,
            'media' => $media,
        ]);
    }

    public function acceptPost(Post $post)
    {
        $data = request()->validate([
            'isActive' => ['nullable', 'in:on'],
        ]);

        $media = SentMediaHelper::getSentMedia($post->slug);
        if ($media != null) {
            $currentPath = "public/posts/$post->slug/";

            foreach ($media as $index => $image) {
                $filename = basename($image);
                $newPath = 'public/media/' . $filename;

                if (Storage::exists($currentPath . $filename)) {
                    Storage::move($currentPath . $filename, $newPath);
                }

                $mediaLibrary = Media::create([
                    'filename' => $filename,
                    'alt_text' => ''
                ]);

                $post->media()->attach($mediaLibrary, ['order' => $index]);
            }

            Storage::deleteDirectory($currentPath);
        }

        $post->isActive = isset($data['isActive']) && $data['isActive'] ? true : false;
        $post->isAccepted = true;
        $post->save();

        return redirect()->route('post.edit', $post)->with('success', 'De post is succesvol geaccepteerd.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post)
    {
        $post->media()->detach();

        $post->update($this->validatePost($post->id));

        if (request()->has('images')) {
            foreach (request()->images as $index => $image) {
                $post->media()->attach($image, ['order' => $index]);
            }
        }

        return redirect()->route('post.index')->with('success', 'De post is succesvol aangepast.');
    }

    private function validatePost($postId = null)
    {
        $data = request()->validate([
            'email' => ['required'],
            'title' => ['required', 'string', 'max:55'],
            'slug' => ['required', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i', Rule::unique('posts')->ignore($postId ?? 0)],
            'isActive' => ['nullable', 'in:on'],
            'images' => ['nullable', 'array'],
            'description' => ['nullable', 'string'],
            'post_category_id' => ['nullable', 'exists:post_categories,id'],
        ]);

        $data['isActive'] = isset($data['isActive']) && $data['isActive'] ? true : false;
        unset($data['images']);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index')->with('success', 'De post is succesvol verwijderd.');
    }

    public function destroyPermanently($id)
    {
        $model = $this->model::withTrashed()->find($id);
        if ($model) {
            $model->forceDelete();
        }

        if ($model->isSent && !$model->isAccepted) {
            Storage::deleteDirectory("public/posts/$model->slug/");
        }

        return redirect()->route('trash.index');
    }
}

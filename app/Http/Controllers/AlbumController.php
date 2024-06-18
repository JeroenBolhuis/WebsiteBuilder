<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Validation\Rule;

class AlbumController extends SoftDeletesController
{
    public function __construct()
    {
        parent::__construct(Album::class);
    }
    
    public function show(string $slug = null)
    {
        if (auth()->user()) {
            $album = Album::slug($slug)->first();
        } else {
            $album = Album::slug($slug)->active()->first();
        }

        if (!$album) {
            return view('errors.404', ['message' => 'Het album die je zoekt bestaat niet.']);
        }

        foreach ($album->media as $media) {
            list($width, $height) = getimagesize($media->storagePath);
            $media->width = $width;
            $media->height = $height;
        }

        return view('album.show', compact('album'));
    }

    public function index()
    {
        return view('album.index', [
            'albums' => Album::orderByDesc('album_date')->get(),
        ]);
    }

    public function create()
    {
        return view('album.create');
    }

    public function edit(Album $album)
    {
        return view('album.edit', compact('album'));
    }

    public function store()
    {
        $album = Album::create($this->validateAlbum());

        if (request()->has('images')) {
            foreach (request()->images as $index => $image) {
                $album->media()->attach($image);
            }
        }

        return redirect()->route('album.index')->with('success', 'Het album is succesvol aangemaakt.');
    }

    public function update(Album $album)
    {
        $album->update($this->validateAlbum($album->id));

        $album->media()->sync(array_filter(request()->images ?? []));

        return redirect()->route('album.index')->with('success', 'Het album is succesvol bijgewerkt.');
    }

    public function destroy(Album $album)
    {
        $album->delete();

        return redirect()->route('album.index')->with('success', 'Het album is succesvol verwijderd.');
    }

    private function validateAlbum($albumId = null)
    {
        $data = request()->validate([
            'name' => ['required', 'string', 'max:55'],
            'slug' => ['required', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i', Rule::unique('albums')->ignore($albumId ?? 0)],
            'isActive' => ['nullable', 'in:on'],
            'album_date' => ['required', 'date'],
            'images' => ['nullable', 'array'],
            'description' => ['nullable', 'string'],
        ]);

        $data['isActive'] = isset($data['isActive']) && $data['isActive'] ? true : false;
        unset($data['images']);

        return $data;
    }
}

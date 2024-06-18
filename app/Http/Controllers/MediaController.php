<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Str;

class MediaController extends SoftDeletesController
{
    public function __construct()
    {
        parent::__construct(Media::class);
    }

    public function index()
    {
        $typeFilters = request()->input('type-filter', ['image', 'video']);
        request()->merge(['type-filter' => $typeFilters]);

        return view('media.index', [
            'allMedia' => Media::whereIn('type', $typeFilters)->latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('media.create');
    }

    public function store()
    {
        $uploadedFile = request()->file('media');
        if ($uploadedFile === null) {
            return redirect()->back()->withErrors(['media' => 'Er is geen media geüpload.']);
        }

        $filename = Str::uuid()->toString() . '.' . $uploadedFile->getClientOriginalExtension();

        if (Media::where('filename', $filename)->exists()) {
            return redirect()->back()->withErrors(['media' => 'Deze media is al geüpload.']);
        }

        $validatedData = request()->validate([
            'media' => ['required', 'mimes:jpeg,jpg,png,gif,svg,mp4', 'max:10240'],
            'alt_text' => ['nullable', 'string']
        ]);

        $uploadedFile->storeAs('public/media', $filename);

        $media = Media::create([
            'filename' => $filename,
            'alt_text' => $validatedData['alt_text']
        ]);

        $media->save();

        return redirect()->route('media.index');
    }

    public function destroy(int $id)
    {
        $media = Media::find($id);

        $media->delete();

        return redirect()->route('media.index');
    }

    public function destroyPermanently($id)
    {
        $model = $this->model::withTrashed()->find($id);

        $filePath = public_path('storage/media/' . $model->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($model) {
            $model->forceDelete();
        }

        return redirect()->route('trash.index')->with('success', 'Je hebt de gegevens permanent verwijderd!');
    }

    public function edit(int $id)
    {
        return view('media.edit', [
            'media' => Media::find($id)
        ]);
    }

    public function update(int $id)
    {
        $media = Media::findOrFail($id);

        $validatedData = request()->validate([
            'alt_text' => 'string'
        ]);

        $media->update($validatedData);

        return redirect()->route('media.index');
    }
}

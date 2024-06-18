<?php

namespace App\Livewire;

use App\Models\Media;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class MediaLibrary extends Component
{
    use WithFileUploads, WithPagination, WithoutUrlPagination;

    public $openTab = 'library';

    public function switchTab()
    {
        $this->openTab = $this->openTab === 'library' ? 'upload' : 'library';
    }

    public $supportedMimes = ['jpeg', 'jpg', 'png', 'gif', 'svg', 'mp4'];

    // Media upload properties
    public $uploadMedia;
    public $alt_text;

    public function mediaUpload()
    {
        if (!$this->uploadMedia) {
            return $this->addError('uploadMedia', 'Geen media geselecteerd.');
        }

        $filename = Str::uuid()->toString() . '.' . $this->uploadMedia->getClientOriginalExtension();

        if (Media::where('filename', $filename)->exists()) {
            return $this->addError('uploadMedia', 'Deze media is al geüpload.');
        }

        $this->validate([
            'uploadMedia' => ['required', 'mimes:' . implode(',', $this->supportedMimes), 'max:10240'],
            'alt_text' => ['nullable', 'string']
        ]);

        $this->uploadMedia->storeAs(path: 'public/media', name: $filename);

        $this->uploadMedia = Media::create([
            'filename' => $filename,
            'alt_text' => $this->alt_text,
        ]);

        $this->dispatch('selectMedia', mediaId: $this->uploadMedia->id, filename: $filename, altText: $this->uploadMedia->alt_text);

        $this->reset('uploadMedia', 'alt_text');
    }

    public $typeFilter = ['image', 'video'];

    public function render()
    {
        $allMedia = Media::whereIn('type', $this->typeFilter)->latest()->paginate(12);

        return view('livewire.media-library', compact('allMedia'));
    }
}

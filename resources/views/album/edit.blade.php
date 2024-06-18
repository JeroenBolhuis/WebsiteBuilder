@extends('layouts.admin')

@section('title', 'Album bewerken')

@section('pageTitle', 'Album bewerken')

@section('content')
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('album.update', $album) }}" method="POST">
        @csrf
        @method('PUT')
        <h1 class="block text-gray-700 text-lg font-bold mb-2">Bewerk het album "{{ $album->name }}"</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Naam *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="name" name="name" type="text" placeholder="Album naam" value="{{ old('name', $album->name) }}"
                required>

            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">
                Url *
            </label>
            <div class="flex items-center">
                <span class="mr-1">{{config('app.url')}}/albums/</span>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="slug" name="slug" type="text" placeholder="mijn-pagina"
                    value="{{ old('slug', $album->slug) }}" required>
            </div>

            @error('slug')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="album_date">
                Datum *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="album_date" name="album_date" type="date" placeholder="Datum"
                value="{{ old('album_date', $album->album_date) }}" required>

            @error('album_date')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Actief
                <div class="flex items-center cursor-pointer">
                    <input type="checkbox" name="isActive" class="sr-only peer" {{ $album->isActive ? 'checked' : '' }}>
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </div>
            </label>
            @error('isActive')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="images">
                    Media
                </label>
                <div class="media-inputs mb-4 flex flex-wrap gap-4">
                    @foreach ($album->media as $media)
                        <div class="parent media-chooser">
                            <div class="flex gap-2 p-2">
                                <button type="button" class="text-red-600 hover:text-red-900 remove-button ml-auto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <div class="bg-blue-200 p-10 rounded">
                                <x-media-chooser inputName="images[]" :value="$media->id" :mediaId="$media->id" />
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-media"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer">
                    Voeg media toe
                </button>
            </div>
        </div>

        @push('scripts')
            <script src="{{ asset('js/post/media-chooser.js') }}"></script>
            <script>
                document.getElementById('add-media').addEventListener('click', function() {
                    const mediaChooser = `
                        <div class="parent media-chooser">
                            <div class="flex gap-2 p-2">
                                <button type="button" class="text-red-600 hover:text-red-900 remove-button ml-auto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <div class="bg-blue-200 p-10 rounded">
                                <x-media-chooser inputName="images[]"/>
                            </div>
                        </div>`;

                    document.querySelector('.media-inputs').insertAdjacentHTML('beforeend', mediaChooser);
                    addEventListenerMediaChooser();
                });
            </script>
        @endpush

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Beschrijving
            </label>

            <x-text-editor
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                name="description" id="description" placeholder="Beschrijving">{!! old('description', $album->description) !!}</x-text-editor>

            @error('description')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button
                class="save-album bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer"
                type="submit">Opslaan
            </button>

            <div class="mt-4 sm:mt-0">
                <a href="{{ route('album.show', ['slug' => $album->slug]) }}"
                    class="inline-block text-blue-600 hover:text-blue-900 mr-4" target="_blank">Bekijk het album</a>

                <button type="button" class="text-red-600 hover:text-red-900 cursor-pointer"
                    onclick="showDeleteDialog({{ json_encode('het album ' . $album->name) }}, '{{ route('album.destroy', ['album' => $album->id]) }}')">Verwijderen</button>
            </div>
        </div>
    </form>

    <x-confirm-delete />
    <x-media-library-modal />
@endsection

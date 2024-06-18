@extends('layouts.admin')

@section('title', 'Mediabibliotheek')

@section('pageTitle', 'Mediabibliotheek')

@section('content')
    <a href="{{ route('media.create') }}"
        class="mb-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block" id="upload-button">
        Upload media
    </a>

    <div>
        <form id="filterForm" action="{{ route('media.index') }}" method="GET" class="mb-4 flex gap-4">
            <div>
                <input type="checkbox" id="imageFilter" value="image" name="type-filter[]"
                    onchange="document.getElementById('filterForm').submit()"
                    {{ in_array('image', request()->input('type-filter', [])) ? 'checked' : '' }}>
                <label for="imageFilter">Afbeeldingen</label>
            </div>
            <div>
                <input type="checkbox" id="videoFilter" value="video" name="type-filter[]"
                    onchange="document.getElementById('filterForm').submit()"
                    {{ in_array('video', request()->input('type-filter', [])) ? 'checked' : '' }}>
                <label for="videoFilter">Video's</label>
            </div>
        </form>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-8 gap-y-4 mb-4">
            @foreach ($allMedia as $media)
                <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
                    <x-media :media="$media" class="w-full h-40 object-contain" muted />

                    <div class="p-4">
                        <p class="text-lg font-semibold">{{ $media->alt_text }}</p>
                        <div class="flex justify-between items-center mt-2">
                            <a href="{{ route('media.edit', $media->id) }}"
                                class="text-blue-500 hover:text-blue-700 font-semibold">
                                Bewerken
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-900 cursor-pointer"
                                onclick="showDeleteDialog({{ json_encode('de media ' . $media->alt_text) }}, '{{ route('media.destroy', $media->id) }}')">Verwijderen</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $allMedia->links() }}
        </div>
    </div>
    <x-confirm-delete />
@endsection

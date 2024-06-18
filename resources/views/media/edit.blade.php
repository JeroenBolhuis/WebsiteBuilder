@extends('layouts.admin')

@section('title', 'Media aanpassen')

@section('pageTitle', 'Media aanpassen')

@section('content')
    <form action="{{ route('media.update', $media->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-md bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $media->id }}">
        <div class="mb-4">
            <label for="alt" class="block text-gray-700 text-sm font-bold mb-2">Omschrijving</label>
            <input type="text" name="alt_text" id="alt" class="border rounded py-2 px-3 w-full"
                value="{{ old('alt_text', $media->alt_text) }}">
            @error('alt_text')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Bewerken</button>
    </form>
@endsection

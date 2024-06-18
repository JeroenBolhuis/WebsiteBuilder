@extends('layouts.admin')

@section('title', 'Media uploaden')

@section('pageTitle', 'Media uploaden')

@section('content')
    <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data"
        class="max-w-md bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="media" class="block text-gray-700 text-sm font-bold mb-2">Media *</label>
            <input type="file" accept="image/png, image/jpg, image/jpeg, image/svg, image/gif, video/mp4" name="media" id="media"
                class="border rounded py-2 px-3 w-full" required value="{{ old('media') }}">
            @error('media')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="alt" class="block text-gray-700 text-sm font-bold mb-2">Omschrijving</label>
            <input type="text" name="alt_text" id="alt" class="border rounded py-2 px-3 w-full"
                value="{{ old('alt_text') }}">
            @error('alt_text')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="upload">Upload</button>
    </form>
@endsection

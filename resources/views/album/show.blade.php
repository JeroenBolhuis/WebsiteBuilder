@extends('layouts.app')

@section('title', $album->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/photoswipe.css') }}">
@endpush

@section('content')
    @if (!$album->isActive)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 alert" role="alert">
            <span class="font-bold">Let op!</span>
            <p>
                Het album is inactief.
                <a href="{{ route('album.edit', $album) }}" class="text-blue-500 underline" target="_blank">Album aanpassen</a>
            </p>
        </div>
    @endif

    <h1 class="text-6xl text-center font-bold pb-2">{{ $album->name }}</h1>
    <h1 class="text-xl text-center">{!! $album->description !!}</h1>
    <div class="grid grid-cols-2 my-6 gap-4 pswp-gallery" id="my-gallery">
        @foreach ($album->media as $media)
            <a href="{{ $media->fullPath }}" data-pswp-width="{{ $media->width }}" data-pswp-height="{{ $media->height }}"
                target="_blank">
                <x-media :media="$media" class="block w-full aspect-square object-contain" />
            </a>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/albumslider.js') }}"></script>
@endpush

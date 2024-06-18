@extends('layouts.app')

@section('title', $post->title)

@section('content')
    @if (!$post->isActive)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 alert" role="alert">
            <span class="font-bold">Let op!</span>
            <p>
                De Post is inactief.
                <a href="{{ route('post.edit', $post) }}" class="text-blue-500 underline" target="_blank">Post aanpassen</a>
            </p>
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ url()->previous() ?? '/' }}" class="text-blue-500 underline cursor-pointer mb-2 block">
            < Ga terug
        </a>

        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

        <div class="text-lg leading-relaxed mb-4">{!! $post->description !!}</div>

        <x-post-media :post="$post" class="rounded-md bg-gray-100 p-4" />
    </div>
@endsection

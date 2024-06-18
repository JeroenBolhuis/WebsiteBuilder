@extends('layouts.admin')

@section('title', 'Post aanpassen')

@section('pageTitle', 'Post aanpassen')

@section('content')

    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('post.acceptPost', ['post' => $post]) }}"
        method="POST">
        @csrf

        <h1 class="block text-gray-700 text-lg font-bold mb-2">Update {{ $post->title }}</h1>
        @if($post->postCategory)
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category">
                    Categorie
                </label>
                <p
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline">
                    {{ $post->postCategory->name }}
            </div>
        @endif
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Naam
            </label>
            <p
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline">
                {{ $post->name }}
            </p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Email
            </label>
            <p
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline">
                {{ $post->email }}
            </p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Titel
            </label>
            <p
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"">
                {{ $post->title }}
            </p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">
                Url
            </label>
            <p
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline">
                {{ $post->slug }}
            </p>
        </div>

        <div class="mb-4">
            <label class="inline-flex flex-col text-gray-700 text-sm font-bold mb-2">
                Actief
                <div class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="isActive" class="sr-only peer"
                        {{ old('isActive', $post->isActive) ? 'checked' : '' }}>
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </div>
            </label>
        </div>

        <div class="mb-4">
            <div class="max-w-[240px]">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="images">
                    Afbeeldingen
                </label>
                @if ($media != null)
                    @foreach ($media as $file)
                        <div class="parent">
                            <div class="flex gap-2 p-2">

                            </div>
                            <div class="bg-blue-200 p-10 rounded">
                                <img src="{{ Storage::url($file) }}" alt="Image">
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Beschrijving
            </label>
            <div
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline">
                {!! $post->description !!}
            </div>
        </div>

        <div class="flex flex-col items-center justify-between sm:flex-row">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer">
                Accepteren & bewerken
            </button>

            <div class="mt-4 sm:mt-0">
                <a class="text-red-600 hover:text-red-900 cursor-pointer" tabindex="0"
                    onclick="document.querySelector('.delete-post').submit()">Verwijderen</a>
            </div>
        </div>
    </form>

    <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST" class="hidden delete-post">
        @csrf
        @method('DELETE')
        <button type="submit">Verwijderen</button>
    </form>
@endsection

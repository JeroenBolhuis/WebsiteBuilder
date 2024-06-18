@extends('layouts.admin')

@section('title', 'Post aanmaken')

@section('pageTitle', 'Post aanmaken')

@section('content')
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('post.store') }}" method="POST">
        @csrf

        <h1 class="block text-gray-700 text-lg font-bold mb-2">Maak een post</h1>

        <input type="hidden" name="email" value="info@hetkoppel.nl">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Titel *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="title" name="title" type="text" placeholder="Mijn post" value="{{ old('title') }}" required>

            @error('title')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">
                Url *
            </label>
            <div class="flex items-center">
                <span class="mr-1">{{config('app.url')}}/posts/</span>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                    id="slug" name="slug" type="text" placeholder="mijn-post" value="{{ old('slug') }}" required>
            </div>
            @error('slug')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Actief
                <div class="flex items-center cursor-pointer">
                    <input type="checkbox" name="isActive" class="sr-only peer" {{ old('isActive') ? 'checked' : '' }}>
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
            <div class="max-w-[240px]">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="images">
                    Media
                </label>
                <div
                    class="media-inputs mb-4
                        [&>div:first-child>div>button.move-button[data-direction=up]]:hidden 
                        [&>div:last-child>div>button.move-button[data-direction=down]]:hidden
                        [&>div:not(:last-child)]:mb-4">

                    @for ($i = 0; $i < (old('images') ? count(old('images')) : 0); $i++)
                        <div class="parent">
                            <div class="flex gap-2 p-2">
                                <button type="button" class="move-button" data-direction="up">
                                    <i class="fas fa-arrow-up"></i>
                                </button>
                                <button type="button" class="move-button" data-direction="down">
                                    <i class="fas fa-arrow-down"></i>
                                </button>
                                <button type="button" class="text-red-600 hover:text-red-900 remove-button ml-auto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <div class="bg-blue-200 p-10 rounded">
                                <x-media-chooser inputName="images[]" :value="old('images.' . $i)" :mediaId="old('images.' . $i)" />
                            </div>
                        </div>
                    @endfor
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
                        <div class="parent">
                            <div class="flex gap-2 p-2">
                                <button type="button" class="move-button" data-direction="up">
                                    <i class="fas fa-arrow-up"></i>
                                </button>
                                <button type="button" class="move-button" data-direction="down">
                                    <i class="fas fa-arrow-down"></i>
                                </button>
                                <button type="button" class=" text-red-600 hover:text-red-900 remove-button ml-auto">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                            <div class="bg-blue-200 p-10 rounded">
                                <x-media-chooser inputName="images[]" />
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
                name="description" id="description" placeholder="Tekst hier">{!! old('description') !!}</x-text-editor>

            @error('description')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="inline-flex flex-col text-gray-700 text-sm font-bold mb-2">
                Categorie

                <select name="post_category_id"
                    class="rounded-md border border-gray-300 shadow-sm py-1 px-2 focus:shadow-outline">
                    <option disabled>Selecteer een categorie</option>
                    <option value="">Geen categorie</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('post_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </label>

            @error('post_category_id')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>  

        <div class="flex items-center justify-between">
            <input value="Aanmaken"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer"
                type="submit">
            </input>
        </div>
    </form>

    <x-media-library-modal />
@endsection

@push('scripts')
    <script src="{{ asset('js/page/page-slugs.js') }}"></script>
@endpush

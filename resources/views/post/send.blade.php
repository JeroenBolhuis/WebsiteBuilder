@extends('layouts.app')

@section('title', 'Post versturen')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Fout!</span>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('post.storeSend') }}"
        enctype="multipart/form-data" method="POST">
        @csrf

        <h1 class="block text-gray-700 text-lg font-bold mb-2">Maak een post</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Naam
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="name" name="name" type="text" placeholder="Jeroen Metsemakers" value="{{ old('name') }}">

            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                Email *
            </label>
            <input required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="email" name="email" type="email" placeholder="info@hetkoppel.nl" value="{{ old('email') }}">

            @error('email')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Titel *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="title" name="title" type="text" placeholder="Mijn post" value="{{ old('title') }}" required>

            @error('title')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="images">
                Afbeeldingen en/of video's
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="images" name="images[]" type="file" multiple value="{{ old('images') }}"
                accept="image/png, image/jpg, image/jpeg, image/svg, image/gif, video/mp4">

            @error('images.*')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                Beschrijving
            </label>

            <x-text-editor name="description" id="description"
                placeholder="Tekst hier">{!! old('description') !!}</x-text-editor>

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
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer"
                type="submit">
            </input>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function toggleDialog(id) {
            let el = document.querySelector(id);
            el.open ? el.close() : el.showModal();
        }
    </script>
@endpush

@push('styles')
    <x-head.text-editor-config />
@endpush

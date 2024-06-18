@extends('layouts.admin')

@section('title', 'Sponsor aanmaken')

@section('pageTitle', 'Sponsor aanmaken')

@section('content')
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('sponsors.store') }}" method="POST">
        @csrf

        <h1 class="block text-gray-700 text-lg font-bold mb-2">Maak een sponsor</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Naam *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="title" name="title" type="text" placeholder="Sponsor naam" value="{{ old('title') }}" required>

            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">
                Url *
            </label>
            <div class="flex items-center">
                <span class="mr-1">{{config('app.url')}}/</span>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="slug" name="slug" type="text" placeholder="mijn-pagina" value="{{ old('slug') }}" required>
            </div>

            @error('slug')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-gray-200 p-4 rounded mt-4">
            <label for="image" class="font-bold mb-2 block">Logo *</label>
            <x-media-chooser :mediaId="old('image_id')" inputName="image_id" />
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Actief
                <div class="flex items-center cursor-pointer">
                    <input type="checkbox" name="isActive" class="sr-only peer" {{ old('isActive') ? 'checked' : '' }}>
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </div>
            </label>
            @error('isActive')
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

    <x-media-library-modal />
@endsection

@push('scripts')
    <script src="{{ asset('js/page/page-slugs.js') }}"></script>
@endpush

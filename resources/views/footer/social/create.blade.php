@extends('layouts.admin')

@section('title', 'Social toevoegen')

@section('pageTitle', 'Social toevoegen')

@section('content')

    <form action="{{ route('socials.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Titel
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="name" name="name" type="text" placeholder="Mijn pagina" min="1"
                value="{{ old('name') }}" required>

            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="url">
                URL
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="url" name="url" type="text" placeholder="Mijn pagina" min="4"
                value="{{ old('url') }}" required>

            @error('url')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="icon">
                Icoontje
                <a target="_blank" href="https://fontawesome.com/search?o=r&f=brands"
                    title="Op FontAwesome kan een icoon uitgezocht worden. De naam van het icoon kan gekopieerd worden naar dit veld.">
                    ?
                </a>
            </label>

            <select name="icon" id="icon"
                class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                data-old="{{ old('icon') }}">
                <option value="">Geen</option>
                <option value="fa-brands fa-instagram">Instagram</option>
                <option value="fa-brands fa-tiktok">Tiktok</option>
                <option value="fa-brands fa-discord">Discord</option>
                <option value="fa-brands fa-youtube">YouTube</option>
                <option value="fa-brands fa-facebook">Facebook</option>
                <option value="fa-brands fa-x-twitter">X</option>
                <option value="fa-regular fa-envelope">Email</option>
                <option value="fa-solid fa-phone">Telefoon</option>
            </select>
            @error('icon')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex">
            <button class="ml-auto bg-green-600 text-white rounded px-4 py-2 hover:shadow-lg transition-shadow">
                Opslaan
            </button>
        </div>
    </form>

@endsection

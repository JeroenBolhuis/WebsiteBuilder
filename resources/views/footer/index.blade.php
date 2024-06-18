@extends('layouts.admin')

@section('title', 'Footer Bewerken')

@section('pageTitle', 'Footer bewerken')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form method="POST" class="bg-white p-3 rounded footer-form">
        @csrf
        <div class="bg-gray-200 p-4 rounded">
            <label for="title" class="font-bold mb-2 block">Titel *</label>
            <input type="text" name="title" id="title" class="block p-2 w-full border-b bg-gray-50 rounded"
                value="{{ $footer->title }}" required>
            @error('title')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-gray-200 p-4 rounded mt-4">
            <label for="content" class="font-bold mb-2 block">Inhoud *</label>
            <textarea type="text" name="content" id="content" class="block p-2 w-full border-b bg-gray-50 rounded"
                rows="8" required>{{ $footer->content }}</textarea>
            @error('content')
                <p class="text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-gray-200 p-4 rounded mt-4">
            <label for="image" class="font-bold mb-2 block">Foto</label>
            <x-media-chooser :mediaId="$footer->image_id" inputName="image_id" />
        </div>

        <div class="bg-white p-4 rounded mt-4 flex justify-between items-center">
            <div class="h-full ">
                <label title="Regelt de zichtbaarheid van de footer.">
                    <input type="checkbox" name="enabled" id="enabled" class="h-full"
                        {{ $footer->enabled ? 'checked' : '' }}>
                    Footer aanzetten
                </label>
                @error('enabled')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button class="self-end bg-green-600 text-white rounded px-4 py-2 hover:shadow-lg transition-shadow">
                    Opslaan
                </button>
            </div>

        </div>
    </form>

    <h2 class="text-2xl font-semibold py-4">Socials bewerken</h2>
    <div class="bg-white p-4 rounded mt-4 flex justify-between items-center">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Titel
                    </th>
                    <th scope="col" class="px-6 py-3">
                        URL
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Icoon
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ route('socials.create') }}" class="text-blue-500 float-right text-[.9rem]">
                            Nieuwe social
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($socials as $social)
                    <tr class="bg-white border-b">
                        <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                            <p>{{ $social->name }}</p>
                        </th>
                        <td class="px-6 py-2">
                            <p>{{ $social->url }}</p>
                        </td>
                        <td class="px-6 py-2">
                            <p><i class="{{ $social->icon }}"></i></p>
                        </td>
                        <td class="px-6 py-2 float-right">
                            <a href="{{ url()->route('socials.edit', ['social' => $social]) }}" type="submit"
                                class="text-blue-500">
                                Bewerken
                            </a>
                            <button type="button" class="text-red-600 hover:text-red-900 cursor-pointer"
                                onclick="showDeleteDialog({{ json_encode('de social ' . $social->name) }}, '{{ url()->route('socials.destroy', ['social' => $social]) }}')">Verwijderen</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-confirm-delete />
    <x-media-library-modal />
@endsection

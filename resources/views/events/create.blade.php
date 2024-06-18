@extends('layouts.admin')

@section('title', 'Evenement aanmaken')

@section('pageTitle', 'Evenement aanmaken')

@section('content')
    <div class="max-w-3xl mx-auto mt-8">
        <div class="mb-4">
            <button class="preview-button inline-block px-4 py-2 text-white bg-blue-600 hover:bg-blue-900 rounded mr-4"
                data-url="{{ route('event.savePreviewData') }}">
                Bekijk een preview van het evenement
            </button>
        </div>

        <form action="{{ route('event.store') }}" method="POST" class="event-form bg-white p-8 rounded-lg shadow-md border">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Titel *</label>
                <input required id="title" type="text" name="title" placeholder="Titel"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('title') }}">

                @error('title')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>
                
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">
                    Url *
                </label>
                <div class="flex items-center">
                    <span class="mr-1">{{config('app.url')}}/evenementen/</span>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                        id="slug" name="slug" type="text" placeholder="mijn-evenement" value="{{ old('slug') }}" required>
                </div>
                @error('slug')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image_id" class="block text-sm font-bold text-gray-700 mb-2">Media *</label>
                <x-media-chooser :mediaId="0" inputName="image_id" />
            </div>

            <div class="mb-6">
                <label for="preview-text" class="block text-sm font-bold text-gray-700 mb-2">Preview tekst</label>
                <textarea id="preview-text" name="preview_text" placeholder="Preview tekst"
                    class="input-field border rounded-md px-4 py-2 w-full">{!! old('preview_text') !!}</textarea>

                @error('preview_text')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="page-text" class="block text-sm font-bold text-gray-700 mb-2">Pagina tekst</label>
                <x-text-editor name="page_text" id="page-text"
                    placeholder="Tekst hier">{!! old('page_text') !!}</x-text-editor>

                @error('page_text')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="date" class="block text-sm font-bold text-gray-700 mb-2">Datum *</label>
                <input id="date" type="date" name="date" class="input-field border rounded-md px-4 py-2 w-full"
                    value="{{ old('date') }}" required>

                @error('date')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="start-time" class="block text-sm font-bold text-gray-700 mb-2">Begintijd *</label>
                <input id="start-time" type="time" name="start_time"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('start_time') }}" required>

                @error('start_time')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="end-time" class="block text-sm font-bold text-gray-700 mb-2">Eindtijd *</label>
                <input id="end-time" type="time" name="end_time" class="input-field border rounded-md px-4 py-2 w-full"
                    value="{{ old('end_time') }}" required>

                @error('end_time')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="street" class="block text-sm font-bold text-gray-700 mb-2">Straatnaam</label>
                <input id="street" type="text" name="street" placeholder="Straatnaam"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('street') }}">

                @error('street')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="house-number" class="block text-sm font-bold text-gray-700 mb-2">Huisnummer</label>
                <input id="house-number" type="text" name="house_number" placeholder="Huisnummer"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('house_number') }}">

                @error('house_number')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="city" class="block text-sm font-bold text-gray-700 mb-2">Stad</label>
                <input id="city" type="text" name="city" placeholder="Stad"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('city') }}">

                @error('city')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="zipcode" class="block text-sm font-bold text-gray-700 mb-2">Postcode</label>
                <input id="zipcode" type="text" name="zipcode" placeholder="Postcode"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('zipcode') }}">

                @error('zipcode')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="country" class="block text-sm font-bold text-gray-700 mb-2">Land</label>
                <input id="country" type="text" name="country" placeholder="Land"
                    class="input-field border rounded-md px-4 py-2 w-full" value="{{ old('country') }}">

                @error('country')
                    <p class="text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    Actief
                    <div class="flex items-center cursor-pointer">
                        <input type="checkbox" name="isActive" class="sr-only peer"
                            {{ old('isActive') ? 'checked' : '' }}>
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                    </div>
                </label>
            </div>

            <div class="flex flex-col items-center justify-between sm:flex-row">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer">
                    Aanmaken
                </button>
            </div>
        </form>
    </div>

    <x-media-library-modal />
@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/event/preview.js') }}"></script>    
    <script src="{{ asset('js/page/page-slugs.js') }}"></script>
@endpush

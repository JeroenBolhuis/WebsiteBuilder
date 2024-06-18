@extends('layouts.admin')

@section('title', 'Navigatie item aanmaken')

@section('pageTitle', 'Navigatie item aanmaken')

@section('content')
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('nav.store') }}" method="POST">
        @csrf

        <h1 class="block text-gray-700 text-lg font-bold mb-2">Maak een navigatie item</h1>

        <input type="hidden" name="parent_id" value="{{ $parent }}">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                Naam *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="name" name="name" type="text" placeholder="naam" value="{{ old('name') }}" required>

            @error('name')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <div class="flex flex-wrap">
                <div class="w-full md:w-auto md:flex-grow">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="page_id">
                        Bestemming
                    </label>
                    <div id="pageSelector">
                        <select name="page_id" id="page_id" placeholder="Pagina"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline">
                            <option value="">Geen bestemming</option>                            
                            @foreach ($pages as $index => $pageGroup)
                                <optgroup label="{{ $index ? 'Normale pagina\'s' : 'Andere pagina\'s' }} ">
                                    @foreach ($pageGroup as $page)
                                        <option value="{{ $page->id }}" {{ old('page_id') == $page->id ? 'selected' : '' }}>
                                            {{ $page->title }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        
                        @error('page_id')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div id="externalUrlField" style="display: none;">
                        <input type="text" name="url" id="url"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                            placeholder="URL" value="{{ old('url') }}">
                            
                        @error('url')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="ml-0 mt-2 md:ml-4 md:mt-0">
                    <label class="block isExternalCheckbox">
                        <p class="text-gray-700 text-sm font-bold mb-3.5">Extern</p>
                        <div class="flex items-center cursor-pointer">
                            <input type="checkbox" name="isExternal" id="isExternal" class="sr-only peer" {{ old('isExternal') ? 'checked' : '' }}>
                            <div
                                class="relative w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer">
                Aanmaken
            </button>
        </div>
    </form>
@endsection
        
@push('scripts')
    <script src="{{ asset('js/nav-external-url.js') }}"></script>
@endpush

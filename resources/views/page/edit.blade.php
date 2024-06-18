@extends('layouts.admin')

@push('meta')
    <meta name="page-id" content="{{ $page->id }}">
@endpush

@section('title', 'Pagina aanpassen')

@section('pageTitle', 'Pagina aanpassen')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 alert fade" role="alert">
            <span class="font-bold">Gelukt!</span>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="mb-4">
        <button class="preview-button inline-block px-4 py-2 text-white bg-blue-600 hover:bg-blue-900 rounded mr-4"
            data-url="{{ route('page.savePreviewData', ['page' => $page]) }}">
            Bekijk een preview van de pagina
        </button>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 mb-2">
        <div class="templates-container w-full sm:w-1/3">
            @include('components/draggable-templates')
            <div class="mt-4 p-5 min-h-7 border">
                <h2 class="text-gray-700 text-lg font-bold ">Gerefereerde pagina's</h2>
                <div id="linked-urls" class="flex flex-col">
                    @foreach ($urls as $url)
                        <a class="text-blue-500 hover:text-blue-700 truncate" href="{{ $url }}" target="_blank">
                            {{ $url }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div
            class="active-templates 
        [&>div:first-child>div>button.move-button[data-direction=up]]:hidden 
        [&>div:last-child>div>button.move-button[data-direction=down]]:hidden
        [&>div:not(:last-child)]:mb-4
        w-full sm:w-2/3 p-5 min-h-7 border">

            @foreach ($page->templates->sortBy('pivot.order') as $template)
                <div class="parent" data-pivot-id="{{ $template->pivot->id }}">
                    <div class="flex gap-2 p-2">
                        <button class="move-button" data-direction="up">
                            <i class="fas fa-arrow-up"></i>
                        </button>
                        <button class="move-button" data-direction="down">
                            <i class="fas fa-arrow-down"></i>
                        </button>
                        <button class=" text-red-600 hover:text-red-900 remove-button ml-auto">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="bg-blue-200 p-10 rounded template-container">
                        <form class="update-template flex flex-col align-start" method="POST"
                            action="{{ route('page.updateTemplateData', ['page' => $template->pivot->page_id]) }}">
                            @csrf
                            <input type="hidden" name="page_template_id" value="{{ $template->pivot->id }}">

                            <div class="[&>div>*:not(:last-child)]:mb-3">
                                <x-dynamic-component :component="'templates.' . $template->name . '.admin'" :template="$template" />
                            </div>

                            @if (count($template->inputNames) > 0)
                                <button type="submit"
                                    class="mt-5 btn cursor-pointer submit bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded max-w-[240px]">
                                    Opslaan
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('page.update', ['page' => $page->id]) }}"
        method="POST">
        @csrf
        @method('PUT')

        <h1 class="block text-gray-700 text-lg font-bold mb-2">Update {{ $page->title }}</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Titel *
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                id="title" name="title" type="text" placeholder="Mijn pagina"
                value="{{ old('title', $page->title) }}" required>

            @error('title')
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
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:shadow-outline"
                    id="slug" name="slug" type="text" placeholder="mijn-pagina"
                    value="{{ old('slug', $page->slug) }}" required>
            </div>

            @error('slug')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="inline-flex flex-col text-gray-700 text-sm font-bold mb-2">
                Actief
                <div class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="isActive" class="sr-only peer"
                        {{ old('isActive', $page->isActive) ? 'checked' : '' }}>
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </div>
            </label>
            @error('isActive')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col items-center justify-between sm:flex-row">
            <input value="Bijwerken"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:shadow-outline cursor-pointer"
                type="submit">
            </input>

            <div class="mt-4 sm:mt-0">
                <a href="{{ route('page.show', ['slug' => $page->slug]) }}"
                    class="inline-block text-blue-600 hover:text-blue-900 mr-4" target="_blank">Bekijk de pagina</a>
                <button type="button" class="text-red-600 hover:text-red-900 cursor-pointer"
                    onclick="showDeleteDialog({{ json_encode('de pagina ' . $page->title) }}, '{{ route('page.destroy', ['page' => $page->id]) }}')">Verwijderen</button>
            </div>
        </div>
    </form>
    <x-confirm-delete />
    <x-media-library-modal />
@endsection

@push('scripts')
    <script src="{{ asset('js/page/page-slugs.js') }}"></script>
    <script src="{{ asset('js/page/drag-drop-template-block.js') }}"></script>
    <script src="{{ asset('js/page/move-template.js') }}"></script>
    <script type="module" src="{{ asset('js/page/remove-template.js') }}"></script>
    <script type="module" src="{{ asset('js/page/update-template.js') }}"></script>
    <script type="module" src="{{ asset('js/page/update-linked-pages.js') }}"></script>
    <script>
        window.allTemplateInputs = {
            @foreach ($page->templates as $template)
                {{ $template->pivot->id }}: {!! json_encode(array_filter($template->inputNames)) !!},
            @endforeach
        };
    </script>
    <script type="module" src="{{ asset('js/page/preview.js') }}"></script>
    <script type="module" src="{{ asset('js/hide-urltitle.js') }}"></script>
@endpush

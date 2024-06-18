@extends('layouts.app')

@section('title', $page->title)

@section('content')
    @if (!$page->isActive)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 alert" role="alert">
            <span class="font-bold">Let op!</span>

            @if ($page->isRegularPage)
                <p>
                    De pagina is inactief.
                    <a href="{{ route('page.edit', $page) }}" class="text-blue-500 underline" target="_blank">Pagina aanpassen</a>
                </p>
            @else
                <p>
                    De sponsor is inactief.
                    <a href="{{ route('sponsors.edit', $page->sponsors->first()) }}" class="text-blue-500 underline" target="_blank">Sponsor aanpassen</a>
                </p>
            @endif
        </div>
    @endif

    @foreach ($page->templates->sortBy('pivot.order') as $template)
        <div class="mb-12">
            <x-dynamic-component :component="'templates.' . $template->name . '.page'" :template="$template" />
        </div>
    @endforeach
@endsection

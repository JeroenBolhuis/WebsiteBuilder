@extends('layouts.app')

@section('title', $event->title)

@section('content')
    @if (!$event->isActive)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 alert" role="alert">
            <span class="font-bold">Let op!</span>
            <p>
                Het evenement is inactief.
                @if (!$event->preview)
                    <a href="{{ route('event.edit', $event) }}" class="text-blue-500 underline" target="_blank">Evenement aanpassen</a>
                @endif
            </p>
        </div>
    @endif

    <div class="max-w-5xl mx-auto my-7 bg-white rounded-lg overflow-hidden shadow-lg">
        <div class="px-6 py-8 [&>*:not(:last-child)]:mb-4">
            <h1 class="text-2xl font-bold">{{ $event->title }}</h1>

            <div>
                @php
                    if ($event->image === null) {
                        $event->image = MediaHelper::getNoImage();
                    }
                @endphp

                <x-media :media="$event->image" class="w-full h-auto object-center rounded-lg" />
            </div>

            <div>
                <h2 class="text-2xl font-bold">Beschrijving</h2>
                <div>{!! $event->page_text !!}</div>
            </div>

            <div>
                <h2 class="text-2xl font-bold">Locatie</h2>
                <p>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->street . ' ' . $event->house_number . ', ' . $event->city . ', ' . $event->country) }}"
                        target="_blank" class="text-blue-600" aria-label="Link naar Google Maps">
                        {{ $event->street }} {{ $event->house_number }} <br>
                        {{ $event->city }}{{ $event->city != '' ? ', ' : '' }}{{ $event->country }}
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

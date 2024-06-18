@props(['template'])

@if ($event)
    <a href="{{ route('event.show', $event->slug) }}" aria-label="{{ $event->title }}">
        <div class="flex flex-col md:flex-row cursor-pointer bg-white shadow-md rounded-md overflow-hidden group">
            <div class="w-full md:w-1/3 overflow-hidden">
                @php
                    if ($event->image === null) {
                        $event->image = MediaHelper::getNoImage();
                    }
                @endphp

                <x-media :media="$event->image"
                    class="w-full h-48 object-cover rounded-md transition-transform duration-300 group-hover:scale-105" />
            </div>
            <div class="w-full md:w-2/3 p-4">
                <h2 class="text-xl font-bold mb-2">{{ $event->title }}</h2>
                <div class="flex justify-between mb-2">
                    <p>{{ Carbon::parse($event->date)->locale('nl_NL')->isoFormat('D MMMM YYYY') }}</p>
                    <p>{{ Carbon::parse($event->start_time)->format('H:i') }} tot
                        {{ Carbon::parse($event->end_time)->format('H:i') }}</p>
                </div>
                <p class="mb-2">{{ $event->preview_text }}</p>
                <p>
                    <b>Meer informatie</b>
                </p>
            </div>
        </div>
    </a>
@endif

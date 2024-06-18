@if ($events != null && count($events) > 0)
    <div>
        <h2 class="text-2xl font-bold mb-4">Recente evenementen</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($events as $event)
                @php
                    $image = MediaHelper::getMedia($event->image_id);
                @endphp
                <a href="{{ route('event.show', $event->slug) }}"
                    class="relative bg-gray-200 shadow-md rounded-lg overflow-hidden aspect-w-1 aspect-h-1 flex hover:scale-105 transition">
                    <div class="relative w-full h-full group">
                        <x-media :media="$image" class="object-contain w-full h-full" />
                        <div class="absolute bottom-0 left-0 right-0 h-16 bg-white bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="flex items-center justify-center flex-col h-full">
                                <h3 class="text-lg font-bold">{{ $event->title }}</h3>
                                <p class="mb-1">{{ date('d-m-Y', strtotime($event->date)) }}</p>
                            </div>     
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
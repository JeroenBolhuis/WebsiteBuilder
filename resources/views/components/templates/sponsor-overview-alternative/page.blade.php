<div class="sponsor-overview grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
    @if ($sponsors->count())
        @foreach ($sponsors as $sponsor)
            <div class="flex flex-col items-center bg-white rounded-lg shadow-md overflow-hidden">
                <a href="{{ route('page.show', [$sponsor->page_slug]) }}"
                    class="hover:opacity-75 transition-opacity duration-300">
                    <x-media :media="$sponsor->imageAttr" class="h-48 w-full object-cover" />
                    <div class="p-4">
                        <p class="text-lg font-semibold text-gray-800 w-full text-center">{{ $sponsor->name }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <p class="text-gray-600">Er zijn nog geen sponsors.</p>
    @endif
</div>

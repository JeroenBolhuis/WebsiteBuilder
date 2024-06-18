<div class="flex justify-center">
    <div class="flex flex-col w-full [&>div:last-child]:border-b-0">
        <a href="{{ route('post.send') }}"
            class="inline-block max-w-64 px-4 py-2 text-center text-white bg-blue-600 hover:bg-blue-900 rounded-md">
            Bericht inzenden
        </a>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($posts as $index => $post)
                <x-post-feed-item :post="$post" />

                @if (($index + 1) % 4 === 0 && $getAvailableSponsorsCount())
                    <div class="sponsor-slider mt-4 col-[1/-1]">
                        <h3 class="text-xl mb-4">Sponsors</h3>
                        <div class="slide-container">
                            @foreach ($getSlideSponsors() as $sponsor)
                                <a class="slide post-sponsor" href="{{ route('page.show', [$sponsor->page->slug]) }}"
                                    tabindex="0" title="{{ $sponsor->name }}">
                                    <x-media :media="$sponsor->imageAttr" class="max-w-full" />
                                    <span class="sr-only">{{ $sponsor->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>

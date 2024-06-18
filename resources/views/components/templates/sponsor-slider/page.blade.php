<div class="sponsor-carousel sponsor-slider">
    <h1 class="text-3xl font-bold mb-2">Onze sponsoren</h1>
    @if ($sponsors->count())
        <div class="slide-container">
            @foreach ($sponsors as $sponsor)
                <a class="slide hover:scale-105 transition-transform" href="{{ route('page.show', [$sponsor->page->slug]) }}" tabindex="-1"
                    title="{{ $sponsor->name }}">
                    <x-media :media="$sponsor->imageAttr" class="max-w-full" />
                    <span class="sr-only">{{ $sponsor->name }}</span>
                </a>
            @endforeach
        </div>
        <div class="controls">
            <button class="prev-btn" aria-label="Previous slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="play-pause-btn" aria-label="Play/Pause">
                <i class="fas fa-play"></i>
            </button>
            <button class="next-btn" aria-label="Next slide">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        @push('scripts')
            <script type="module" src="{{ asset('js/sponsor-carousel.js') }}"></script>
        @endpush
    @else
        <p>Er zijn nog geen sponsors.</p>
    @endif
</div>

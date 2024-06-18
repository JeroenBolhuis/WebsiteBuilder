@props(['post'])

@if ($post->media->count())
    <div {{ $attributes->merge(['class' => 'post-media relative w-full']) }}>
        <div class="relative overflow-hidden rounded-sm max-h-96" style="padding-bottom: 60%;">
            @foreach ($post->media as $media)
                <div class="duration-200 ease-in-out absolute inset-0" data-carousel-item>
                    <x-media :media="$media" class="w-full h-full object-contain" :targetUrl="route('post.show', [$post->slug])" />
                </div>
            @endforeach
        </div>

        @if ($post->media->count() > 1)
            <div class="controls">
                <!-- Slider controls -->
                <button type="button"
                    class="absolute h-[50%] transform -translate-y-1/2 top-1/2 start-0 z-[2] flex items-center justify-center px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-2 group-focus:ring-black group-focus:outline-none">
                        <i class="fas fa-chevron-left w-4 h-4 text-white"></i>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute h-[50%] transform -translate-y-1/2 top-1/2 end-0 z-[2] flex items-center justify-center px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-2 group-focus:ring-black group-focus:outline-none">
                        <i class="fas fa-chevron-right w-4 h-4 text-white"></i>
                        <span class="sr-only">Next</span>
                    </span>
                </button>

                <!-- Slider indicators -->
                <div
                    class="absolute z-[2] flex -translate-x-1/2 bottom-5 left-1/2 space-x-3
                        [&>button[aria-current=true]>span.indicator]:block">
                    @foreach ($post->media as $index => $media)
                        <button type="button" class="bg-black/30 w-3 h-3 rounded-full flex items-center justify-center"
                            aria-current="false" aria-label="Media {{ $index + 1 }}"
                            data-carousel-slide-to="{{ $index }}">
                            <span class="indicator hidden bg-white w-2 h-2 rounded-full"></span>
                            <span class="sr-only">Media {{ $index + 1 }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endif

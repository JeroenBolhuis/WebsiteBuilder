@props(['post'])

<div class="flex flex-col items-start bg-white rounded-sm border-b-[1px] border-gray-300 py-4">
    <h1 class="text-lg font-bold px-2 mb-2 underline">
        <a href="{{ route('post.show', [$post->slug]) }}">{{ $post->title }}</a>
    </h1>

    <x-post-media :post="$post" class="rounded-md bg-gray-100 p-4" />

    @if ($post->description)
        <div class="post-description p-4 mt-auto">
            {!! $post->description !!}

            @if ($post->isLongDescription)
                <a href="{{ route('post.show', [$post->slug]) }}" class="text-blue-500 underline cursor-pointer">
                    Lees meer over {{ $post->title }}...
                </a>
            @endif
        </div>
    @endif
</div>

@props(['sponsor'])

<div class="sponsor items-start bg-white rounded-sm border-b-[1px] py-4" title="{{ $sponsor->name }}">
    <div class="p-4 text-center">
        <h3 class="text-2xl font-bold">{{ $sponsor->name }}</h3>
        <a href="{{ route('page.show', [$sponsor->page_slug]) }}">
            <x-media :media="$sponsor->imageAttr" class="min-h-80 h-auto w-auto my-5 max-w-full mx-auto block"/>
        </a>
        <p>Werken bij {{ $sponsor->name }}? <a href="{{ route('page.show', [$sponsor->page_slug]) }}">Klik hier voor meer informatie!</a></p>
    </div>
</div>

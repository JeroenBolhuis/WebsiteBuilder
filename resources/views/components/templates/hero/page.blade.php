@props(['template'])

@php
    $image = MediaHelper::getMedia($template->pivot->data->image);
@endphp

<div class="hero-page min-h-[95vh] w-100 z-[-10]">
    {{-- Achtergrondafbeelding --}}
    <x-media :media="$image" class="inset-0 w-full h-[95vh] object-cover z-[-99] brightness-[0.55]" />

    {{-- Tekst overlappend op de afbeelding --}}
    <div class="absolute inset-0 flex items-center justify-center flex-col">
        <h1 class="text-white text-center text-7xl font-bold mb-5 animate-fadein">{!! $template->pivot->data->hoofdtekst !!}</h1>
        <p class="text-gray-400 text-center text-2xl">{!! $template->pivot->data->subtekst !!}</p>
    </div>
</div>

@push('scripts')
    <script type="module">
        const header = document.querySelector('header');
        const heroPages = document.querySelectorAll('.hero-page');

        if (header && heroPages) {
            heroPages.forEach((heroPage) => {
                header.appendChild(heroPage);
            });
        }
    </script>
@endpush

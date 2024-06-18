@props(['template'])

@php
    $image = MediaHelper::getMedia($template->pivot->data->afbeelding);
@endphp

<div class="w-full flex justify-center">
    
    <div class="flex justify-center items-center">
        <x-media :media="$image" :target-url="$template->pivot->data->media_url" :title="$template->pivot->data->media_title"
            class="lg:w-[{{ $template->pivot->data->width }}%] h-auto" />            
    </div>
</div>

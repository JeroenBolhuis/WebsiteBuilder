@props(['template'])
@php
    $media = MediaHelper::getMedia($template->pivot->data->media);
@endphp
<div class="flex items-center justify-center">
    <div class="max-w-screen-lg flex gap-4 flex-col md:flex-row mx-auto">
        <div class="md:w-1/2 flex items-center">
            {!! $template->pivot->data->tekst !!}
        </div>
        <div class="md:w-1/2">
            <x-media :media="$media" :target-url="$template->pivot->data->media_url" :title="$template->pivot->data->media_title"/>
        </div>
    </div>
</div>

  
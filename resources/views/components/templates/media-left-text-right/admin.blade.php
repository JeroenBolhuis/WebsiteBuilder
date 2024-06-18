@props(['template'])

<div>
    <x-media-chooser :mediaId="$template->pivot->data->media" inputName="media" />

    <div class="media_link-container">
        <label for="media_url" class="block text-gray-700 text-sm font-bold">Media Url:</label>
        <input type="text" name="media_url" class="border rounded py-2 px-3 w-full media_url"
            value="{{ $template->pivot->data->media_url }}">

        <div class="media_title_container mt-2 @if (empty($template->pivot->data->media_url)) hidden @endif">
            <label for="media_title" class="block text-gray-700 text-sm font-bold">Media Titel:</label>
            <input type="text" name="media_title" class="border rounded py-2 px-3 w-full media_title" value="{{ $template->pivot->data->media_title }}">
        </div>
    </div>

    <x-text-editor name="tekst" id="tekst-{{ $template->pivot->id }}"
        placeholder="Tekst hier">{!! $template->pivot->data->tekst !!}</x-text-editor>
</div>

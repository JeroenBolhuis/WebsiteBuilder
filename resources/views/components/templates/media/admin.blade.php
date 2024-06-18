@props(['template'])

<div>
    <x-media-chooser :mediaId="$template->pivot->data->afbeelding" inputName="afbeelding" />

    <div class="media_link-container">
        <label for="media_url" class="block text-gray-700 text-sm font-bold">Media Url:</label>
        <input type="text" name="media_url" class="border rounded py-2 px-3 w-full media_url"
            value="{{ $template->pivot->data->media_url }}">

        <div class="media_title_container mt-2 @if (empty($template->pivot->data->media_url)) hidden @endif">
            <label for="media_title" class="block text-gray-700 text-sm font-bold">Media Titel:</label>
            <input type="text" name="media_title" class="border rounded py-2 px-3 w-full media_title" value="{{ $template->pivot->data->media_title }}">
        </div>
    </div>
    <div class="pt-2">
        <label for="width" class="font-bold">Grootte: </label>
        <input type="number" name="width" id="width" min="0" max="100" value="{{ !empty($template->pivot->data->width) ? $template->pivot->data->width : 100 }}" class="p-1 rounded"><span>%</span>
    </div>
    
</div>

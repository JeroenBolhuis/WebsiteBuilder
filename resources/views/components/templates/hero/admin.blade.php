@props(['template'])

<div>
    <x-media-chooser :mediaId="$template->pivot->data->image" inputName="image" />

    <label for="hoofdtekst" class="block text-gray-700 text-sm font-bold mb-2">Hoofdtekst:</label>
    <input type="text" name="hoofdtekst" id="hoofdtekst" class="border rounded py-2 px-3 w-full"
        value="{{ $template->pivot->data->hoofdtekst }}">

    <label for="subtekst" class="block text-gray-700 text-sm font-bold mb-2">Subtekst:</label>
    <input type="text" name="subtekst" id="subtekst" class="border rounded py-2 px-3 w-full"
        value="{{ $template->pivot->data->subtekst }}">
</div>

@props(['mediaId', 'inputName', 'value'])

<div class="media-container">
    @php
        if (isset($mediaId)) {
            $media = MediaHelper::getMedia($mediaId);
        } else {
            $media = null;
        }
    @endphp

    <input type="hidden" class="media_id" name="{{ $inputName }}"
        value="{{ isset($value) && $value ? $value : old($inputName, $media ? $media->id : '') }}">

    @if ($media)
        <x-media :media="$media" class="w-full mb-4 media-url max-w-[16rem] max-h-[10rem]" />
    @else
        <img src="" alt="" class="w-full mb-4 media-url max-w-[16rem] max-h-[10rem] object-cover">
    @endif

    <button type="button"
        class="open-library-modal btn cursor-pointer bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded block text-center">
        Kies media
    </button>

    @error($inputName)
        <p class="text-red-600">{{ $message }}</p>
    @enderror
</div>

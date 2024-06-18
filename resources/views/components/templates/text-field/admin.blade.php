@props(['template'])

<div>
    <x-text-editor name="tekst" id="tekst-{{ $template->pivot->id }}"
        placeholder="Tekst hier">{!! $template->pivot->data->tekst !!}</x-text-editor>
</div>

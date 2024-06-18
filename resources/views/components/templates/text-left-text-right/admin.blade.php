@props(['template'])

<div>
    <input type="color" name="achtergrondkleur" value="{{ $template->pivot->data->achtergrondkleur ?? '#ffffff' }}">

    <x-text-editor name="tekst_links" id="tekst_links-{{ $template->pivot->id }}"
        placeholder="Tekst links hier">{!! $template->pivot->data->tekst_links !!}</x-text-editor>

    <x-text-editor name="tekst_rechts" id="tekst_rechts-{{ $template->pivot->id }}"
        placeholder="Tekst rechts hier">{!! $template->pivot->data->tekst_rechts !!}</x-text-editor>
</div>

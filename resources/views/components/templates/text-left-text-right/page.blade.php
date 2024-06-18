@props(['template'])
<div class="bg-[{{$template->pivot->data->achtergrondkleur ?? '#FFFFFF'}}] grid grid-cols-2 rounded p-2">
    <div>
        {!! $template->pivot->data->tekst_links !!}
    </div>
    <div>
        {!! $template->pivot->data->tekst_rechts !!}
    </div>
</div>

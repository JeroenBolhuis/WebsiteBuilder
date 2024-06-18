@props(['template'])

<div class="w-full flex justify-center flex-col [&>p]:p-2">
    {!! $template->pivot->data->tekst !!}
</div>

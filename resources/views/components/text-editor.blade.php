<div class="text-editor-container bg-white">
    <div {{ $attributes->except('name')->merge(['class' => 'quill-editor [&>.ql-editor]:min-h-32']) }}>{!! $slot !!}</div>
    <textarea class="hidden" type="hidden" name="{{ $attributes->get('name') }}"></textarea>
</div>

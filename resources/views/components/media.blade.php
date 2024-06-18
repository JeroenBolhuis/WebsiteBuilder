@props(['media', 'targetUrl' => null])

@if ($media->isImage())
    @if ($targetUrl)
        <a href="{{ strpos($targetUrl, 'http://') === 0 || strpos($targetUrl, 'https://') === 0 ? $targetUrl : '//' . $targetUrl }}"
            class="w-full @if (preg_match('/(\w*:w-\[\d+%])/', $attributes['class'], $matches)) flex justify-center items-center @endif" target="_blank">
    @endif
    <img src="{{ $media->fullPath }}" alt="{{ $media->alt_text }}" {{ $attributes->merge() }}>
    @if ($targetUrl)
        </a>
    @endif
@else
    <video src="{{ $media->fullPath }}" title="{{ $media->alt_text }}" controls {{ $attributes->merge() }}></video>
@endif

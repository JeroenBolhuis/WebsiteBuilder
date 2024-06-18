@props(['item'])

@if (count($item->children) > 0)
    <x-header.nav-dropdown :item="$item" />
@else
    <li>
        <a @if ($item->page && $item->page->slug) 
                href="{{ route('page.show', ['slug' => $item->page->slug]) }}" 
            @elseif ($item->url)
                href="{{ $item->url }}" 
                target="_blank"
            @endif
            tabindex="0"
            class="block py-2 px-3 text-[{{ $settings->secondary_color }}] rounded hover:bg-[{{ $settings->secondary_color }}] hover:text-[{{ $settings->primary_color }}] duration-100 cursor-{{ ($item->page && $item->page->slug) || $item->url ? 'pointer' : 'default' }}">
            {{ $item->name }}
        </a>
    </li>
@endif

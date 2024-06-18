@props(['item'])

<div class="dropdown group relative">
    <a @if ($item->page && $item->page->slug) 
            href="{{ route('page.show', ['slug' => $item->page->slug]) }}" 
        @elseif ($item->url)
            href="{{ $item->url }}" 
            target="_blank"
        @endif
        tabindex="0"
        class="flex items-center py-2 px-3 text-[{{ $settings->secondary_color }}] rounded hover:bg-[{{ $settings->secondary_color }}] hover:text-[{{ $settings->primary_color }}] duration-100 cursor-{{ ($item->page && $item->page->slug) || $item->url ? 'pointer' : 'default' }}">
        {{ $item->name }}
        <i class="fas fa-chevron-down ml-auto md:ml-2 -mr-1 text-sm"></i>
    </a>

    <div
        class="dropdown-content md:left-auto md:right-0 z-[100] p-[0.25rem] bg-[{{ $settings->primary_color }}] border border-2 border-[{{ $settings->secondary_color }}] absolute left-0 md:w-40 w-full origin-top-left rounded-md shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300">
        @foreach ($item->children as $child)
            <x-header.nav-link :item="$child" />
        @endforeach
    </div>
</div>

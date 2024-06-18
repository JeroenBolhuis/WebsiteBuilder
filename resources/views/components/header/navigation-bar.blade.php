<div
    class="site-navigation py-2 w-full bg-[{{ $settings->primary_color }}] z-10 fixed top-0 md:min-h-20 flex items-center">
    <div
        class="inner-wrap mx-auto max-w-[1200px] px-4 sm:px-8 md:px-20 md:gap-y-4 flex justify-between items-center w-full flex-wrap">
        <div class="logo-wrapper">
            <a href="/" title="Voor en door Werktuigbouwkunde studenten!"
                class="logo-text text-white text-2xl font-bold uppercase transition-all duration-100">
                @if ($settings->image_id != null && $settings->use_logo)
                    <x-media :media="$settings->image" class="h-12 md:h-16" />
                @else
                    WTB SV Het Koppel
                @endif
            </a>
        </div>

        <div class="flex items-center md:hidden md:order-2 space-x-1 md:space-x-0">
            <button data-collapse-toggle="navbar" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-gray-20"
                aria-controls="navbar" aria-expanded="false">
                <span class="sr-only">{{ __('Open main menu') }}</span>
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 md:ml-auto" id="navbar">
            <ul
                class="flex flex-col font-medium font-md p-2 md:p-0 mt-4 border border-gray-100 rounded-lg md:flex-wrap md:gap-x-4 md:md:gap-y-2 md:flex-row md:mt-0 md:border-0">
                @foreach ($nav_items->where('parent_id', null) as $item)
                    <x-header.nav-link :item="$item" />
                @endforeach
            </ul>
        </nav>
    </div>
</div>
<div class="nav-placeholder" style="visibility: hidden;"></div>

@push('scripts')
    <script src="{{ asset('js/navigation-bar.js') }}"></script>
@endpush

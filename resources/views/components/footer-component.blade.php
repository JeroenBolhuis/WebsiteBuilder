@if ($footer && $footer->enabled)
    <footer class="bg-[{{ $settings->primary_color }}] text-white py-6 mt-auto">
        <div class="inner-wrap mx-auto max-w-[1200px] px-8 md:px-20  mt-2">
            <aside class="flex flex-col lg:flex-row justify-between mb-6">
                <div class="flex-1">
                    <h3 class="text-2xl lg:text-3xl font-semibold mb-4">{{ $footer->title }}</h3>
                    <p class="text-gray-300">
                        {!! nl2br($footer->content) !!}
                    </p>

                    <ul class="text-gray-400 pt-2">
                        @foreach ($socials as $social)
                            @if ($social->icon == 'fa-regular fa-envelope')
                                <li>
                                    <a href="mailto:{{ $social->url }}">
                                        <i class="{{ $social->icon }} pr-1"></i>
                                        {{ $social->name }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $social->url }}" target="_blank">
                                        <i class="{{ $social->icon }} pr-1"></i>
                                        {{ $social->name }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="self-center">
                    <x-media :media="$footer->image" class="max-h-56 my-5 block self-center" />
                </div>
            </aside>

            <div class="pt-6 border-t-[1px] border-solid border-[rgba(255,255,255,.1)]">
                <span class="block text-gray-400 text-center sm:text-left">
                    Gerealiseerd door Avans projectgroep D
                </span>
            </div>
        </div>
    </footer>
@endif

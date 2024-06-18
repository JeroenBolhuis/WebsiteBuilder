@props(['template', 'albums'])

@if ($albums->count())
    <div class="flex flex-col md:flex-row gap-4">
        <div class="md:w-[35%] flex flex-col gap-2">
            @foreach ($years as $index => $year)
                <button
                    class="pl-8 py-2 shadow-lg rounded-md  flex items-center {{ $index === 0 ? 'bg-gray-200' : 'bg-gray-50' }}"
                    onclick="filterAlbums('{{ $year }}')" data-year="{{ $year }}">
                    {{ $year }}
                    <i class="fas fa-chevron-right ml-auto mr-4"></i>
                </button>
            @endforeach
        </div>

        <div class="md:w-[65%] grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach ($albums as $album)
                <div class="album-card relative mx-1 transition ease-in-out hover:-translate-y-1 hover:scale-105 duration-300"
                    data-year="{{ Carbon::parse($album->album_date)->format('Y') }}">
                    <a href="{{ route('album.show', [$album->slug]) }}">
                        @if ($albumCount = $album->media->count())
                            <x-media :media="$album->media->first()" class="block w-full aspect-[2/1] object-cover" />
                        @endif

                        <div
                            class="{{ $albumCount ? 'absolute inset-0' : 'h-full' }} flex items-center justify-center flex-col bg-opacity-50 bg-gray-900">
                            <p class="text-white text-center text-5xl font-bold mb-1">{!! $album->name !!}</p>
                            <p class="text-white text-center text-xl font-bold">{{ $album->album_date }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p>Er zijn nog geen albums.</p>
@endif

@push('scripts')
    <script>
        function filterAlbums(year) {
            document.querySelectorAll('.album-card').forEach(card => {
                card.style.display = card.dataset.year === year ? 'block' : 'none';
            });

            document.querySelectorAll('button[data-year]').forEach(button => {
                if (button.dataset.year === year) {
                    button.classList.add('bg-gray-200');
                    button.classList.remove('bg-gray-50');
                } else {
                    button.classList.remove('bg-gray-200');
                    button.classList.add('bg-gray-50');
                }
            });
        }

        filterAlbums('{{ $years->first() }}');
    </script>
@endpush

<div class="sponsor-overview">
    @if ($sponsors->count())
        @foreach ($sponsors as $sponsor)
            <x-sponsor-component :sponsor="$sponsor" />
        @endforeach
    @else
        <p>Er zijn nog geen sponsors.</p>
    @endif
</div>
@if ($events->count())
    @foreach ($events as $event)
        <div class="my-6">
            <x-templates.single-event.page :event="$event" />
        </div>
    @endforeach

    <div class="mt-4">
        {{ $events->links() }}
    </div>
@else
    <p>Er zijn geen evenementen gevonden.</p>
@endif

@props(['template'])
<div>
    <label for="event" class="block text-sm font-bold text-gray-700 mb-2">Evenement</label>
    <select id="event" name="event_id" class="input-field border rounded-md px-4 py-2 w-full">
        <option value="">Selecteer een evenement</option>
        @foreach ($events as $event)
            <option value="{{ $event->id }}" {{ $template->pivot->data->event_id == $event->id ? 'selected' : '' }}>
                {{ $event->title }}
            </option>
        @endforeach
    </select>
    <p class="text-sm text-gray-500 mt-1">
        Selecteer een evenement om te tonen op de pagina. De template laat de foto, titel, datum, tijden en preview tekst van het evenement zien.
    </p>
</div>

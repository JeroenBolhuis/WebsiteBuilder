<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class EventsController extends SoftDeletesController
{
    public function __construct()
    {
        parent::__construct(Event::class);
    }
    
    public function index()
    {
        return view('events.index', [
            'events' => Event::all(),
        ]);
    }

    public function show(string $slug = null)
    {        
        if (auth()->user()) {
            $event = Event::slug($slug)->first();
        } else {
            $event = Event::slug($slug)->active()->first();
        }

        if (!$event) {
            return view('errors.404', ['message' => 'Het evenement die je zoekt bestaat niet.']);
        }

        return view('events.show', compact('event'));
    }

    public function savePreviewData($id = null)
    {
        try {
            $data = $this->validateEvent($id);
        } catch (ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Validation failed', 'errors' => $e->errors()]);
        }

        session()->put('event_preview_data', json_encode($data));

        if (session()->has('event_preview_data')) {
            return response()->json(['status' => 'success', 'message' => 'Preview data saved!', 'url' => route('event.preview')]);
        }

        return response()->json(['status' => 'error'], 500);
    }

    public function preview()
    {
        $data = json_decode(session()->get('event_preview_data'), true);

        if (!$data) {
            return view('errors.404', ['message' => 'Er zijn geen preview gegevens gevonden. Controleer de gegevens en probeer het opnieuw.']);
        }

        $event = new Event();

        foreach ($data as $key => $value) {
            $event->$key = $value;
        }

        $event->preview = true;

        return view('events.show', compact('event'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store()
    {
        Event::create($this->validateEvent());

        return redirect()->route('event.index');
    }

    private function validateEvent($eventId = null)
    {
        $parameters = request()->validate([
            'title' => ['required', 'string', 'max:55'],
            'slug' => ['required', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/i', Rule::unique('events')->ignore($eventId ?? 0)],
            'image_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    if (empty($value)) {
                        $fail('Er is nog geen media geselecteerd.');
                    }
                },
            ],
            'preview_text' => 'nullable',
            'page_text' => 'nullable',
            'date' => 'required',
            'street' => 'nullable',
            'house_number' => 'nullable',
            'city' => 'nullable',
            'zipcode' => 'nullable',
            'country' => 'nullable',
            'isActive' => ['nullable', 'in:on'],
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $parameters['country'] = $parameters['country'] ?? 'Nederland';
        $parameters['isActive'] = isset($parameters['isActive']) && $parameters['isActive'] ? true : false;

        return $parameters;
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Event $event)
    {
        $event->update($this->validateEvent($event->id));

        return redirect()->route('event.index');
    }

    public function destroy(Event $event)
    {
        Event::destroy($event->id);
        return redirect()->route('event.index');
    }
}

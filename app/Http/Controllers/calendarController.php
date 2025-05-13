<?php

// app/Http/Controllers/CalendarController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function getEvents()
    {
        return response()->json(Event::select('id', 'title', 'start', 'end')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:due_date',
        ]);

        $event = Event::create([
            'title' => $request->title,
            'start' => $request->due_date,
            'end' => $request->end_date,
        ]);

        return response()->json([
            'id' => $event->id,
            'title' => $event->title,
            'due_date' => $event->start,
            'end_date' => $event->end,
        ]);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'start' => 'sometimes|required|date',
            'end' => 'sometimes|required|date|after_or_equal:start',
        ]);

        $event->update($request->only(['title', 'start', 'end']));

        return response()->json(['message' => 'Event updated']);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}

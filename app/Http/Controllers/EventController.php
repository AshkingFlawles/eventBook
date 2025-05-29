<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Display a listing of events
    public function index()
    {
        // Optionally eager load venue relationship if exists
        return response()->json(Event::with('venue')->get());
    }

    // Store a newly created event
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
            'venue_id' => 'required|exists:venues,id',
        ]);

        $event = Event::create($validated);
        return response()->json($event, 201);
    }

    // Display the specified event
    public function show($id)
    {
        $event = Event::with('venue')->findOrFail($id);
        return response()->json($event);
    }

    // Update the specified event
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date',
            'venue_id' => 'sometimes|required|exists:venues,id',
        ]);

        $event->update($validated);
        return response()->json($event);
    }

    // Remove the specified event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(null, 204);
    }
}

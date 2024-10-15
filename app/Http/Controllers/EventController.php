<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
{
    $events = Event::all();
    return view('events.index', compact('events'));
}

public function create()
{
    $venues = Venue::all();
    return view('events.create', compact('venues'));
}

public function store(Request $request)
{
    $request->validate([
        'venue_id' => 'required',
        'title' => 'required',
        'description' => 'required',
        'start_time' => 'required|date',
        'end_time' => 'required|date',
        'is_ticketed' => 'required|boolean',
    ]);

    Event::create($request->all());
    return redirect()->route('events.index');
}

public function show(Event $event)
{
    return view('events.show', compact('event'));
}

public function edit(Event $event)
{
    $venues = Venue::all();
    return view('events.edit', compact('event', 'venues'));
}

public function update(Request $request, Event $event)
{
    $request->validate([
        'venue_id' => 'required',
        'title' => 'required',
        'description' => 'required',
        'start_time' => 'required|date',
        'end_time' => 'required|date',
        'is_ticketed' => 'required|boolean',
    ]);

    $event->update($request->all());
    return redirect()->route('events.index');
}

public function destroy(Event $event)
{
    $event->delete();
    return redirect()->route('events.index');
}

//full call test
public function getEvents()
    {
        $events = Event::all();
        return response()->json($events);
    }

}
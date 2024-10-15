<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('bookings.index', compact('bookings'));
    }
    
    public function create()
    {
        $events = Event::all();
        return view('bookings.create', compact('events'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'num_tickets' => 'required|integer|min=1',
        ]);
    
        $event = Event::find($request->event_id);
    
        if ($event->is_ticketed) {
            // Implement ticketing logic if needed
        }
    
        Booking::create([
            'event_id' => $request->event_id,
            'user_id' => auth()->id(),
            'num_tickets' => $request->num_tickets,
        ]);
    
        return redirect()->route('bookings.index');
    }
    
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }
    
    public function edit(Booking $booking)
    {
        $events = Event::all();
        return view('bookings.edit', compact('booking', 'events'));
    }
    
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'event_id' => 'required',
            'num_tickets' => 'required|integer|min=1',
        ]);
    
        $booking->update($request->all());
        return redirect()->route('bookings.index');
    }
    
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index');
    }    
}
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Return booking trends data aggregated by date (last 30 days)
    public function bookingTrends()
    {
        $trends = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return response()->json($trends);
    }

    // Store a new booking for event or venue
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'venue_id' => 'nullable|exists:venues,id',
            'num_tickets' => 'required|integer|min:1',
        ]);

        if (empty($data['event_id']) && empty($data['venue_id'])) {
            throw ValidationException::withMessages([
                'event_id' => ['Either event_id or venue_id must be provided.'],
                'venue_id' => ['Either event_id or venue_id must be provided.'],
            ]);
        }

        $data['user_id'] = Auth::id();

        $booking = Booking::create($data);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ], 201);
    }
}

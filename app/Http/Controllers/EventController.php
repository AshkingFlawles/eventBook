<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'venue_id' => 'required|exists:venues,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'is_ticketed' => 'required|boolean',
        'ticket_price' => 'nullable|numeric|min:0',
    ]);

        try {
            DB::beginTransaction();

            // Add user_id if authenticated
            if (auth()->check()) {
                $validated['user_id'] = auth()->id();
            }

            $event = Event::create($validated);

            DB::commit();

            // Load relationships only if they exist
            $relationships = ['venue'];
            if ($event->user_id) {
                $relationships[] = 'user';
            }

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'data' => $event->load($relationships)
            ], 201);


        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating event: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create event. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while creating the event.'
            ], 500);
        }
    }

    public function index()
    {
        try {
            $events = Event::with(['venue', 'user'])->get();
            
            return response()->json([
                'success' => true,
                'data' => $events
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred.'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $event = Event::with(['venue', 'user'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $event
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'venue_id' => 'sometimes|required|exists:venues,id',
                'start_time' => 'sometimes|required|date',
                'end_time' => 'sometimes|required|date|after:start_time',
            ]);

            DB::beginTransaction();
            
            $event->update($validated);
            
            DB::commit();

            $relationships = ['venue'];
            if ($event->user_id) {
                $relationships[] = 'user';
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully',
                'data' => $event->fresh($relationships)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating event: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete event',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred.'
            ], 500);
        }
    }
}

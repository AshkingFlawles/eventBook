<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VenueController extends Controller
{
    /**
     * Display a listing of venues
     */
    public function index()
    {
        return response()->json(Venue::all());
    }

    /**
     * Store a newly created venue in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'price_per_hour' => 'required|numeric|min:0',
            'wheelchair_accessible' => 'boolean',
            'parking_available' => 'boolean',
        ]);
        
        try {
            DB::beginTransaction();

            $validated['status'] = 'draft';

            if (auth()->check()) {
                $validated['user_id'] = auth()->id();
            }

            $venue = Venue::create($validated);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venue created successfully',
                'data' => $venue
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating venue: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to create venue. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while creating the venue.'
            ], 500);
        }
    }

    /**
     * Display the specified venue.
     */
    public function show($id)
    {
        try {
            $venue = Venue::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $venue
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Venue not found'
            ], 404);
        }
    }

    /**
     * Update the specified venue in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $venue = Venue::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'type' => 'sometimes|required|string|max:255',
                'price_per_hour' => 'sometimes|required|numeric|min:0',
                'wheelchair_accessible' => 'boolean',
                'parking_available' => 'boolean',
            ]);
            
            DB::beginTransaction();
            
            $venue->update($validated);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Venue updated successfully',
                'data' => $venue->fresh()
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Venue not found'
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating venue: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update venue. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while updating the venue.'
            ], 500);
        }
    }

    /**
     * Remove the specified venue from storage.
     */
    public function destroy($id)
    {
        try {
            $venue = Venue::findOrFail($id);
            $venue->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Venue deleted successfully'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Venue not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete venue',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while deleting the venue.'
            ], 500);
        }
    }
}

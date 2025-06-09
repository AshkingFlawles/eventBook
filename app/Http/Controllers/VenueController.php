<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VenueController extends Controller
{
    // Display a listing of venues
    public function index()
    {
        return response()->json(Venue::all());
    }

    /**
     * Store a newly created venue in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            // Basic Information
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'currency' => 'required|string|size:3|in:USD,EUR,GBP,JPY,CAD,AUD',
            
            // Location
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            
            // Capacity and Space
            'min_capacity' => 'nullable|integer|min:0',
            'max_capacity' => 'nullable|integer|min:0|gte:min_capacity',
            'area_sqft' => 'nullable|numeric|min:0',
            'ceiling_height' => 'nullable|numeric|min:0',
            
            // Pricing
            'pricing_model' => 'required|in:per_hour,per_day,per_week,per_month,per_event,per_person,package,subscription',
            'price_per_hour' => 'nullable|required_if:pricing_model,hourly|numeric|min:0',
            'price_per_day' => 'nullable|required_if:pricing_model,daily|numeric|min:0',
            'price_per_week' => 'nullable|required_if:pricing_model,weekly|numeric|min:0',
            'price_per_month' => 'nullable|required_if:pricing_model,monthly|numeric|min:0',
            'per_event_price' => 'nullable|required_if:pricing_model,per_event|numeric|min:0',
            'price_per_person' => 'nullable|required_if:pricing_model,per_person|numeric|min:0',
            'min_guests' => 'nullable|integer|min:0',
            'max_guests' => 'nullable|integer|min:0|gte:min_guests',
            'has_deposit' => 'boolean',
            'deposit_amount' => 'nullable|required_if:has_deposit,true|numeric|min:0',
            'deposit_percentage' => 'nullable|required_if:has_deposit,true|numeric|between:0,100',
            'pricing_notes' => 'nullable|string',
            
            // Availability
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i|after:opening_time',
            'unavailable_days' => 'nullable|json',
            
            // Contact Information
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            
            // Media
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video_tour_url' => 'nullable|url|max:255',
            'virtual_tour_url' => 'nullable|url|max:255',
            
            // JSON Fields
            'facilities' => 'nullable|json',
            'pricing_tiers' => 'nullable|json',
            'pricing_packages' => 'nullable|json',
            'subscription_plans' => 'nullable|json',
            'additional_fees' => 'nullable|json',
            'features' => 'nullable|json',
            
            // Status
            'status' => 'nullable|string|in:draft,published,unpublished',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'featured_until' => 'nullable|date|after:today',
            'user_id' => 'nullable|exists:users,id'
        ]);
        
        try {
            // Start a database transaction
            DB::beginTransaction();
            
            // Handle file uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('venues/' . now()->format('Y/m'), 'public');
                    $imagePaths[] = $path;
                }
                $validated['images'] = $imagePaths;
            }
            
            // Set default status if not provided
            if (!isset($validated['status'])) {
                $validated['status'] = 'draft';
            }
            
            // Set the authenticated user as the owner if user_id is not provided
            if (!isset($validated['user_id']) && auth()->check()) {
                $validated['user_id'] = auth()->id();
            }
            
                // Create the venue
                $venue = Venue::create($validated);
            
            // Commit the transaction
            DB::commit();
            
            // Return success response with the created venue
            return response()->json([
                'success' => true,
                'message' => 'Venue created successfully',
                'data' => $venue->load('user')
            ], 201);
            
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            
            // Log the error
            \Log::error('Error creating venue: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to create venue. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while creating the venue.'
            ], 500);
        }
    }

    /**
     * Display the specified venue.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        return response()->json([
            'success' => true,
            'data' => $venue->load('reviews', 'bookings')
        ]);
    }

    /**
     * Update the specified venue in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        // Validate the request
        $validated = $request->validate([
            // Basic Information
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|required|string|max:255',
            'currency' => 'sometimes|required|string|size:3|in:USD,EUR,GBP,JPY,CAD,AUD',
            
            // Location
            'address' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            
            // Capacity and Space
            'min_capacity' => 'nullable|integer|min:0',
            'max_capacity' => 'nullable|integer|min:0|gte:min_capacity',
            'area_sqft' => 'nullable|numeric|min:0',
            'ceiling_height' => 'nullable|numeric|min:0',
            
            // Pricing
            'pricing_model' => 'sometimes|required|in:per_hour,per_day,per_week,per_month,per_event,per_person,package,subscription',
            'price_per_hour' => 'nullable|required_if:pricing_model,hourly|numeric|min:0',
            'price_per_day' => 'nullable|required_if:pricing_model,daily|numeric|min:0',
            'price_per_week' => 'nullable|required_if:pricing_model,weekly|numeric|min:0',
            'price_per_month' => 'nullable|required_if:pricing_model,monthly|numeric|min:0',
            'per_event_price' => 'nullable|required_if:pricing_model,per_event|numeric|min:0',
            'price_per_person' => 'nullable|required_if:pricing_model,per_person|numeric|min:0',
            'min_guests' => 'nullable|integer|min:0',
            'max_guests' => 'nullable|integer|min:0|gte:min_guests',
            'has_deposit' => 'boolean',
            'deposit_amount' => 'nullable|required_if:has_deposit,true|numeric|min:0',
            'deposit_percentage' => 'nullable|required_if:has_deposit,true|numeric|between:0,100',
            'pricing_notes' => 'nullable|string',
            
            // Availability
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i|after:opening_time',
            'unavailable_days' => 'nullable|json',
            
            // Contact Information
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'sometimes|required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            
            // Media
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video_tour_url' => 'nullable|url|max:255',
            'virtual_tour_url' => 'nullable|url|max:255',
            
            // JSON Fields
            'facilities' => 'nullable|json',
            'pricing_tiers' => 'nullable|json',
            'pricing_packages' => 'nullable|json',
            'subscription_plans' => 'nullable|json',
            'additional_fees' => 'nullable|json',
            'features' => 'nullable|json',
            
            // Status
            'status' => 'nullable|string|in:draft,published,unpublished',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'featured_until' => 'nullable|date|after:today',
        ]);
        
        try {
            // Start a database transaction
            DB::beginTransaction();
            
            // Handle file uploads if any
            if ($request->hasFile('images')) {
                // Delete old images
                if (is_array($venue->images)) {
                    foreach ($venue->images as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                }
                
                // Upload new images
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('venues/' . now()->format('Y/m'), 'public');
                    $imagePaths[] = $path;
                }
                $validated['images'] = $imagePaths;
            }
            
            // Update the venue
            $venue->update($validated);
            
            // Commit the transaction
            DB::commit();
            
            // Return success response with the updated venue
            return response()->json([
                'success' => true,
                'message' => 'Venue updated successfully',
                'data' => $venue->fresh()
            ]);
            
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            
            // Log the error
            \Log::error('Error updating venue: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to update venue. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred while updating the venue.'
            ], 500);
        }
    }

    /**
     * Remove the specified venue from storage.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        try {
            // Delete associated images from storage
            if (!empty($venue->images)) {
                foreach ($venue->images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
            
            // Soft delete the venue
            $venue->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Venue deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete venue',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

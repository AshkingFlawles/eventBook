<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    // Display a listing of venues
    public function index()
    {
        return response()->json(Venue::all());
    }

    // Store a newly created venue
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'capacity' => 'nullable|integer',
            'price_per_hour' => 'nullable|numeric',
            'venue_type' => 'nullable|string|in:cafe,restaurant,open_space,hall,marquee,conference_room,event_center,rooftop,other',
            'custom_venue_type' => 'nullable|string|max:255',
            'available_from' => 'nullable|date_format:H:i',
            'available_to' => 'nullable|date_format:H:i',
            'owner_id' => 'nullable|exists:users,id',
            'floor_area_sqft' => 'nullable|integer',
            'layout_type' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:20',
            'photo_gallery' => 'nullable|array',
            'video_tour_url' => 'nullable|url',
            'minimum_booking_hours' => 'nullable|integer',
            'max_booking_hours' => 'nullable|integer',
            'pricing_model' => 'nullable|string|in:per_hour,per_day,custom',
            'security_deposit' => 'nullable|numeric',
            'restrooms_available' => 'nullable|boolean',
            'air_conditioning' => 'nullable|boolean',
            'heating' => 'nullable|boolean',
            'security_staff' => 'nullable|boolean',
            'internet_access' => 'nullable|boolean',
            'status' => 'nullable|string|in:active,inactive,maintenance,reserved,pending',
            'menu_file' => 'nullable|file|mimes:pdf,xlsx,xls,csv|max:10240',
            'parking_available' => 'nullable|boolean',
            'wheelchair_accessible' => 'nullable|boolean',
            'kitchen_facilities' => 'nullable|boolean',
            'catering_available' => 'nullable|boolean',
            'sound_system' => 'nullable|boolean',
            'stage_available' => 'nullable|boolean',
            'outdoor_area' => 'nullable|boolean',
            'decor_services' => 'nullable|boolean',
            'lighting_options' => 'nullable|string',
            'seating_arrangement_options' => 'nullable|string',
            'custom_rules' => 'nullable|string',
            'booking_policy' => 'nullable|string',
            'chairs' => 'nullable|integer',
            'tables' => 'nullable|integer',
        ]);

        $venue = Venue::create($validated);
        return response()->json($venue, 201);
    }

    // Display the specified venue
    public function show($id)
    {
        $venue = Venue::findOrFail($id);
        return response()->json($venue);
    }

    // Update the specified venue
    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'capacity' => 'nullable|integer',
            'price_per_hour' => 'nullable|numeric',
            'venue_type' => 'nullable|string|max:255',
            'available_from' => 'nullable|date_format:H:i',
            'available_to' => 'nullable|date_format:H:i',
            'owner_id' => 'nullable|exists:users,id',
            'parking_available' => 'nullable|boolean',
            'wheelchair_accessible' => 'nullable|boolean',
            'kitchen_facilities' => 'nullable|boolean',
            'catering_available' => 'nullable|boolean',
            'sound_system' => 'nullable|boolean',
            'stage_available' => 'nullable|boolean',
            'outdoor_area' => 'nullable|boolean',
            'decor_services' => 'nullable|boolean',
            'lighting_options' => 'nullable|string',
            'seating_arrangement_options' => 'nullable|string',
            'photo_gallery' => 'nullable|array',
            'custom_rules' => 'nullable|string',
            'booking_policy' => 'nullable|string',
            'chairs' => 'nullable|integer',
            'tables' => 'nullable|integer',
        ]);

        $venue->update($validated);
        return response()->json($venue);
    }

    // Remove the specified venue
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();
        return response()->json(null, 204);
    }
}

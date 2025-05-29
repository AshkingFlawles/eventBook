<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'location', 'address', 'city', 'state', 'country', 'zip_code',
        'latitude', 'longitude', 'capacity', 'price_per_hour', 'venue_type', 'custom_venue_type', 'available_from', 'available_to',
        'owner_id', 'floor_area_sqft', 'layout_type', 'contact_email', 'contact_phone', 'photo_gallery', 'video_tour_url',
        'minimum_booking_hours', 'max_booking_hours', 'pricing_model', 'security_deposit',
        'restrooms_available', 'air_conditioning', 'heating', 'security_staff', 'internet_access',
        'status', 'menu_file',
        'parking_available', 'wheelchair_accessible', 'kitchen_facilities', 'catering_available',
        'sound_system', 'stage_available', 'outdoor_area', 'decor_services', 'lighting_options',
        'seating_arrangement_options', 'custom_rules', 'booking_policy', 'chairs', 'tables',
    ];

    protected $casts = [
        'parking_available' => 'boolean',
        'wheelchair_accessible' => 'boolean',
        'kitchen_facilities' => 'boolean',
        'catering_available' => 'boolean',
        'sound_system' => 'boolean',
        'stage_available' => 'boolean',
        'outdoor_area' => 'boolean',
        'decor_services' => 'boolean',
        'restrooms_available' => 'boolean',
        'air_conditioning' => 'boolean',
        'heating' => 'boolean',
        'security_staff' => 'boolean',
        'internet_access' => 'boolean',
        'photo_gallery' => 'array',
        'available_from' => 'datetime:H:i',
        'available_to' => 'datetime:H:i',
    ];
}

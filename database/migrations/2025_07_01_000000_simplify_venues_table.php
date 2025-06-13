<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SimplifyVenuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            // Drop foreign key constraint on user_id before dropping the column
            if (Schema::hasColumn('venues', 'user_id')) {
                $table->dropForeign(['user_id']);
            }

            $columnsToDrop = [
                'description',
                'location',
                'address',
                'city',
                'state',
                'country',
                'zip_code',
                'latitude',
                'longitude',
                'capacity',
                'floor_area_sqft',
                'layout_type',
                'contact_email',
                'contact_phone',
                'photo_gallery',
                'video_tour_url',
                'max_booking_hours',
                'pricing_model',
                'security_deposit',
                'restrooms_available',
                'air_conditioning',
                'heating',
                'security_staff',
                'internet_access',
                'status',
                'menu_file',
                'custom_venue_type',
                'available_from',
                'available_to',
                'chairs',
                'tables',
                'custom_rules',
                'booking_policy',
                'outdoor_area',
                'decor_services',
                'lighting_options',
                'seating_arrangement_options',
                'catering_available',
                'kitchen_facilities',
                'sound_system',
                'stage_available',
                'user_id',
                'created_at',
                'updated_at',
                'deleted_at',
                'is_active',
                'is_featured',
                'featured_until',
                'features',
                'facilities',
                'pricing_tiers',
                'pricing_packages',
                'subscription_plans',
                'additional_fees',
            ];

            // Remove duplicates and keep only columns that exist in the table and are not in simplified model
            $columnsToDrop = array_diff($columnsToDrop, ['wheelchair_accessible', 'parking_available', 'name', 'type', 'price_per_hour']);

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('venues', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is irreversible for simplicity
    }
}

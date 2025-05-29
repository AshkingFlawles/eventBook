<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('capacity')->nullable();
            $table->decimal('price_per_hour', 8, 2)->nullable();
            $table->string('venue_type')->nullable();
            $table->string('custom_venue_type', 255)->nullable();
            $table->time('available_from')->nullable();
            $table->time('available_to')->nullable();

            // Owner ID can be any user for now, to be refined later
            $table->unsignedBigInteger('owner_id')->nullable();

            // New fields for venue dimensions & layout
            $table->integer('floor_area_sqft')->nullable();
            $table->string('layout_type')->nullable();

            // New fields for contact & admin info
            $table->string('contact_email')->nullable();
            $table->string('contact_phone', 20)->nullable();

            // New fields for images & media
            $table->json('photo_gallery')->nullable();
            $table->string('video_tour_url')->nullable();

            // New fields for booking rules & pricing
            $table->integer('minimum_booking_hours')->nullable();
            $table->integer('max_booking_hours')->nullable();
            $table->string('pricing_model')->nullable();
            $table->decimal('security_deposit', 10, 2)->nullable();

            // New fields for additional facilities
            $table->boolean('restrooms_available')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->boolean('heating')->default(false);
            $table->boolean('security_staff')->default(false);
            $table->boolean('internet_access')->default(false);

            // Status field
            $table->string('status')->default('pending');

            // Menu file upload
            $table->string('menu_file')->nullable();

            // Optional features
            $table->boolean('parking_available')->default(false);
            $table->boolean('wheelchair_accessible')->default(false);
            $table->boolean('kitchen_facilities')->default(false);
            $table->boolean('catering_available')->default(false);
            $table->boolean('sound_system')->default(false);
            $table->boolean('stage_available')->default(false);
            $table->boolean('outdoor_area')->default(false);
            $table->boolean('decor_services')->default(false);
            $table->text('lighting_options')->nullable();
            $table->text('seating_arrangement_options')->nullable();
            $table->text('custom_rules')->nullable();
            $table->text('booking_policy')->nullable();

            // Furniture counts
            $table->integer('chairs')->nullable();
            $table->integer('tables')->nullable();

            // Foreign key constraint for owner_id
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn([
                'address', 'city', 'state', 'country', 'zip_code', 'latitude', 'longitude',
                'price_per_hour', 'venue_type', 'custom_venue_type', 'available_from', 'available_to', 'owner_id',
                'floor_area_sqft', 'layout_type', 'contact_email', 'contact_phone', 'photo_gallery', 'video_tour_url',
                'minimum_booking_hours', 'max_booking_hours', 'pricing_model', 'security_deposit',
                'restrooms_available', 'air_conditioning', 'heating', 'security_staff', 'internet_access',
                'status', 'menu_file',
                'parking_available', 'wheelchair_accessible', 'kitchen_facilities', 'catering_available',
                'sound_system', 'stage_available', 'outdoor_area', 'decor_services', 'lighting_options',
                'seating_arrangement_options', 'custom_rules', 'booking_policy',
                'chairs', 'tables'
            ]);
        });
    }
};

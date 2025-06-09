<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Basic Information
        'name', 'description', 'venue_type', 'currency',
        
        // Location
        'address', 'city', 'state', 'postal_code', 'country', 'latitude', 'longitude',
        
        // Capacity and Space
        'min_capacity', 'max_capacity', 'area_sqft', 'ceiling_height',
        
        // Pricing
        'pricing_model', 'price_per_hour', 'price_per_day', 'price_per_week', 'price_per_month',
        'per_event_price', 'price_per_person', 'min_guests', 'max_guests',
        'has_deposit', 'deposit_amount', 'deposit_percentage', 'pricing_notes',
        
        // Availability
        'opening_time', 'closing_time', 'unavailable_days',
        
        // Contact Information
        'contact_name', 'contact_email', 'contact_phone', 'website',
        
        // Media
        'images', 'video_tour_url', 'virtual_tour_url',
        
        // Additional Features (JSON fields)
        'facilities', 'pricing_tiers', 'pricing_packages', 'subscription_plans',
        'additional_fees', 'features',
        
        // Status
        'status', 'is_active', 'is_featured', 'featured_until', 'user_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // JSON fields
        
        // JSON Arrays
        'unavailable_days' => 'array',
        'images' => 'array',
        'facilities' => 'array',
        'pricing_tiers' => 'array',
        'pricing_packages' => 'array',
        'subscription_plans' => 'array',
        'additional_fees' => 'array',
        'features' => 'array',
        
        // Dates
        'opening_time' => 'datetime:H:i',
        'closing_time' => 'datetime:H:i',
        'featured_until' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($venue) {
            $venue->slug = \Illuminate\Support\Str::slug($venue->name);
        });
        
        static::updating(function ($venue) {
            $venue->slug = \Illuminate\Support\Str::slug($venue->name);
        });
    }
    
    /**
     * Scope a query to only include active venues.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope a query to only include featured venues.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                    ->where(function($q) {
                        $q->whereNull('featured_until')
                          ->orWhere('featured_until', '>', now());
                    });
    }

    /**
     * Get the user that owns the venue.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

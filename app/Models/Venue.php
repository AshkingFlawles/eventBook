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
        'name',
        'description',
        'type',
        'price_per_hour',
        'wheelchair_accessible',
        'parking_available',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'wheelchair_accessible' => 'boolean',
        'parking_available' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'venue_id',
        'user_id',
        'start_time',
        'end_time',
        'is_ticketed',
        'ticket_price',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_ticketed' => 'boolean',
        'ticket_price' => 'decimal:2',
    ];

    /**
     * Get the venue that owns the event.
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * Get the user that owns the event.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
      protected $fillable = [
        'title', 'description', 'start_time', 'end_time', 'venue_id', 'is_ticketed',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}

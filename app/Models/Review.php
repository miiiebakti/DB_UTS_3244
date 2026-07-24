<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'rating',
        'review',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
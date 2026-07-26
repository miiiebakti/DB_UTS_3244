<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPrice extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'start_date',
        'end_date',
        'quota',
        'sold',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
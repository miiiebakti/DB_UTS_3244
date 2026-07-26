<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'poster_path',
        'stock',
        'price',
        'category_id',
    ];

    // Relasi kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ticket price
    public function ticketPrices()
    {
        return $this->hasMany(TicketPrice::class);
    }

    // Ambil harga tiket yang sedang berlaku
    public function getCurrentTicketPriceAttribute()
    {
        return $this->ticketPrices()
            ->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhereDate('end_date', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('quota')
                      ->orWhereColumn('sold', '<', 'quota');
            })
            ->orderBy('start_date')
            ->first();
    }
}
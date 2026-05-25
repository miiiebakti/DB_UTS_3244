<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

public function category()
{
    return $this->belongsTo(Category::class);
}
    protected $fillable = [
    'category_id',
    'title',
    'description',
    'date',
    'location',
    'price',
    'stock',
    'poster_path'
];
}

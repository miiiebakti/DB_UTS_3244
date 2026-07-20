<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['name','created_by','updated_by'];

    public function penguruses()
    {
        return $this->hasMany(Pengurus::class);
    }
}

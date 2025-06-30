<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'capacity', 'type', 'price'];  // Add other relevant fields as needed
    public function admissions()
    {
        return $this->hasMany(Admission::class, 'room_id');
    }
}

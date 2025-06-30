<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalManager extends Model
{
    protected $fillable = ['nik', 'full_name', 'username', 'password', 'email', 'phone_number'];
}
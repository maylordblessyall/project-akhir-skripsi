<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'nik', 'full_name', 'username', 'password', 'email', 'phone_number' 
    ];
}

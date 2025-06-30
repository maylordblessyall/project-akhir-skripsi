<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationStaff extends Model
{
    protected $table = 'registration_staff'; // Laravel convention for table naming
    protected $fillable = ['nik', 'full_name', 'username', 'password', 'email', 'phone_number'];
}

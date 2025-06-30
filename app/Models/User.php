<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'access_level',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRole()
    {
        switch ($this->access_level) {
            case 'admin':
                return 'Admin';
            case 'doctor':
                return 'Doctor';
            case 'registration_staff':
                return 'Registration Staff';
            case 'perawat':
                return 'Nurse';
            case 'hospital_manager':
                return 'Hospital Manager';
            default:
                return 'User';
        }
    }

    public function isAdmin()
    {
        return $this->access_level === 'admin';
    }

    public function isDoctor()
    {
        return $this->access_level === 'doctor';
    }

    public function isRegistrationStaff()
    {
        return $this->access_level === 'registration_staff';
    }

    public function isNurse()
    {
        return $this->access_level === 'perawat';
    }

    public function isHospitalManager()
    {
        return $this->access_level === 'hospital_manager';
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function setPasswordHashAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['username'] = $value;
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }
}
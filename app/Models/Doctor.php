<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $fillable = ['user_id', 'full_name', 'specialty', 'email', 'phone_number'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id_doctor', 'id');
    }
}
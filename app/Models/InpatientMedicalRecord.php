<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpatientMedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', 'doctor_id', 'patient_id', 'date_recorded',
        'subjective', 'objective', 'assessment', 'plan'
    ];

    // Relationships
    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id'); 
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id'); 
    }
}
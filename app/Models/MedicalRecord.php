<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class MedicalRecord extends Model
{
    protected $fillable = ['id_appointment', 'id_patient', 'id_doctor', 'patient_name','date_recorded', 'subjective', 'objective', 'assessment', 'plan'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'id_doctor');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'id_appointment');
    }
    
    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\MedicalRecord;

class Appointment extends Model
{
    protected $table = 'appointments';
    protected $fillable = ['id_patient', 'id_doctor', 'date', 'start_time', 'end_time', 'notes', 'payment_method', 'amount'];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'id_patient');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'id_doctor');
    }

    public function hasMedicalRecord()
    {
        return $this->medicalRecords()->exists();
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'id_appointment');
    }

    protected $casts = [
        'date' => 'datetime',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];
}
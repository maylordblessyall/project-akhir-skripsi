<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorCommission extends Model
{
    protected $fillable = ['doctor_id', 'admission_id', 'commission_amount']; 

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function inpatientMedicalRecord()
    {
        return $this->belongsTo(InpatientMedicalRecord::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $fillable = [
        'nik',
        'full_name', // Confirm this matches the column name
        'date_of_birth',
        'gender',
        'address',
        'phone_number',
        'email',
        'golongan_darah',
        'alergi',
        'riwayat_medis',
        'obat_yang_dikonsumsi',
    ];

    // Add this to cast 'date_of_birth' to a date object
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id_patient');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_patient');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use Carbon\Carbon;
class Admission extends Model
{
    protected $table = 'admissions';

    protected $fillable = [
        'patient_id', 'admission_date', 'discharge_date','total_bill', 'room_id', 'reason', 'doctor_id', 'payment_status'
    ];    

    // Relationship with Patient (BelongsTo)
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relationship with Room (BelongsTo)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    //Relationship with doctor(BelongsTo)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Check if a room is occupied (Helper function)
    public static function isRoomOccupied($roomId)
    {
        return self::where('room_id', $roomId)
            ->whereNull('discharge_date') 
            ->exists();
    }

    // Relationship with Inpatient Medical Records (HasMany)
    public function inpatientMedicalRecords()
    {
        return $this->hasMany(InpatientMedicalRecord::class);
    }
    public function doctorCommissions()
    {
        return $this->hasMany(DoctorCommission::class);
    }
    public function calculateTotalBill() 
    {
        $dischargeDate = Carbon::parse($this->discharge_date ?? now());
        $admissionDate = Carbon::parse($this->admission_date);
        $daysStayed = $dischargeDate->diffInDays($admissionDate) + 1;

        $totalRoomBill = $daysStayed * $this->room->price;
        $totalCommission = $this->doctorCommissions->sum('commission_amount');

        return $totalRoomBill + $totalCommission;
    }
}
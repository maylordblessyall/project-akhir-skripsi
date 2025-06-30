<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\InpatientMedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    public function showDashboard(Request $request): View
    {
        $user = Auth::user();
    
        Log::info('User attempting to access doctor dashboard', [
            'user_id' => $user->id,
            'access_level' => $user->access_level,
        ]);
    
        // Create or retrieve doctor profile
        $doctor = $user->doctor;
        if (!$doctor && in_array($user->access_level, [ 'doctor'])) {
            Log::info('Creating doctor profile for user', ['user_id' => $user->id]);
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'nik' => 'AUTO' . $user->id,
                'full_name' => $user->username ?? 'Dr. ' . $user->email,
                'specialization' => 'General',
                'email' => $user->email,
                'phone_number' => '1234567890',
                'amount' => 0.00,
            ]);
        }
    
            // Fetch appointments for the doctor for today
            $today = Carbon::today()->format('Y-m-d');
            $appointments = Appointment::where('id_doctor', $doctor->id)
                ->whereDate('date', $today)
                ->with(['patient', 'doctor'])
                ->orderBy('start_time', 'asc')
                ->paginate(10);
    
        return view('doctors.menu', [
            'doctor' => $doctor,
            'access_level' => $user->access_level,
            'appointments' => $appointments,
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $user = Auth::user();

        $records = MedicalRecord::query();

        // If user is a doctor, only show their own records
        if ($user->access_level === 'doctor' && $user->doctor) {
            $records->whereHas('appointment', function ($query) use ($user) {
                $query->where('id_doctor', $user->doctor->id);
            });
        }

        if ($search) {
            $records->where(function($query) use ($search) {
                $query->where('id_patient', $search)
                      ->orWhere('patient_name', $search);
            });
        }

        $records = $records->paginate(10);

        return view('medical_records.index', compact('records'));
    }

    public function create(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        return view('medical_records.create', compact('patients', 'doctors', 'appointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_appointment' => 'required|exists:appointments,id',
            'id_patient' => 'required|exists:patients,id',
            'id_doctor' => 'required|exists:doctors,id',
            'full_name' => 'required|exists:patients,full_name',
            'date_recorded' => 'required|date',
            'subjective' => 'required',
            'objective' => 'required',
            'assessment' => 'required',
            'plan' => 'required',
        ]);

        $appointment = Appointment::findOrFail($request->input('id_appointment'));

        $medicalRecord = new MedicalRecord;
        $medicalRecord->id_appointment = $appointment->id;
        $medicalRecord->id_patient = $appointment->patient->id;
        $medicalRecord->id_doctor = $appointment->doctor->id;
        $medicalRecord->patient_name = $appointment->patient->full_name;
        $medicalRecord->date_recorded = date('Y-m-d');
        $medicalRecord->subjective = $request->input('subjective');
        $medicalRecord->objective = $request->input('objective');
        $medicalRecord->assessment = $request->input('assessment');
        $medicalRecord->plan = $request->input('plan');

        $medicalRecord->save();

        return redirect()->route('doctors.menu')->with('success', 'Medical Record created successfully');
    }

    public function showDetails($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $medicalRecords = MedicalRecord::where('id_patient', $id)->get();

            return view('patients.details', compact('patient', 'medicalRecords'));
        } catch (\Exception $e) {
            return redirect()->route('patients.index')->with('error', 'Failed to load patient details.');
        }
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return view('medical_records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        return view('medical_records.edit', compact('medicalRecord'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $request->validate([
            'id_patient' => 'required',
            'id_doctor' => 'required',
            'date_recorded' => 'required|date',
            'subjective' => 'required',
            'objective' => 'required',
            'assessment' => 'required',
            'plan' => 'required',
        ]);

        $medicalRecord->update($request->all());

        return redirect()->route('medical_records.index')->with('success', 'Medical Record updated successfully');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        return redirect()->route('medical_records.index')->with('success', 'Medical Record deleted successfully');
    }

    public function printDetails(Patient $patient)
    {
        $medicalRecords = MedicalRecord::where('id_patient', $patient->id)->get();
        return view('patients.printDetails', compact('patient', 'medicalRecords'));
    }
}
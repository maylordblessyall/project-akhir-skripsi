<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        // Check if the user is a doctor
        $user = Auth::user();
        if ($user && $user->access_level === 'doctor') {
            return redirect()->route('doctors.menu')->with('error', 'Access denied. Doctors cannot view this page.');
        }

        $patients = Patient::all();
        $doctors = Doctor::all();

        $today = Carbon::today()->format('Y-m-d');

        $query = Appointment::query();

        if (!$request->has('date_from') && !$request->has('date_to')) {
            $query->whereDate('date', $today);
            $request->merge(['date_from' => $today, 'date_to' => $today]);
        } else {
            if ($request->has('date_from') && $request->has('date_to')) {
                try {
                    $startDate = Carbon::parse($request->date_from);
                    $endDate = Carbon::parse($request->date_to);
                } catch (\Exception $e) {
                    
                }

                if (isset($startDate)) {
                    $query->whereDate('date', '>=', $startDate);
                }

                if (isset($endDate)) {
                    $query->whereDate('date', '<=', $endDate);
                }
            }

            if ($request->filled('id_patient')) {
                $query->where('id_patient', $request->id_patient);
            }

            if ($request->filled('id_doctor')) {
                $query->where('id_doctor', $request->id_doctor);
            }
        }

        $appointments = $query->with('patient', 'doctor')->orderBy('date', 'asc')->paginate(10);

        // Get the authenticated user's access_level
        $accessLevel = $user->access_level;

        return view('appointments.index', [
            'appointments' => $appointments,
            'filters' => [
                'date_from' => $request->get('date_from', $today),
                'date_to' => $request->get('date_to', $today),
                'id_patient' => $request->get('id_patient'),
                'id_doctor' => $request->get('id_doctor'),
            ],
            'patients' => $patients,
            'doctors' => $doctors,
            'access_level' => $accessLevel,
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all(); 

        return view('appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time_slot' => 'required|in:morning,afternoon',
            'id_patient' => 'required|exists:patients,id',
            'id_doctor' => 'required|exists:doctors,id',
            'payment_method' => 'required|in:qris,cash',
            'amount' => 'required|numeric|min:0.01',
            'notes' => 'nullable',
        ]);

        $startTime = $request->time_slot === 'morning' ? '09:00:00' : '13:00:00';
        $endTime = $request->time_slot === 'morning' ? '12:00:00' : '16:00:00';

        Appointment::create([
            'date' => $request->date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'id_patient' => $request->id_patient,
            'id_doctor' => $request->id_doctor,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'notes' => $request->notes,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully!');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'id_doctor' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'required',
        ]);

        $appointment->update($request->all());

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully');
    }
}
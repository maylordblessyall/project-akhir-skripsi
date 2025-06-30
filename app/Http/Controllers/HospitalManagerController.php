<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\HospitalManager;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HospitalManagerController extends Controller
{
    public function showDashboard(Request $request)
    {
        // Define date variables using Carbon
        $today = Carbon::today();
        $startOfMonth = $today->copy()->startOfMonth();
        $startOfYear = $today->copy()->startOfYear();

        // Get appointment totals (default: today, month, year)
        $totals = $this->getAppointmentTotals();

        // Handle custom date range for filtering
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        // Fetch all doctors for the dropdown
        $doctors = Doctor::all();

        // Handle doctor filter
        $doctorId = $request->input('doctor_id');

        // Fetch all appointments with optional date and doctor filtering
        $appointmentsQuery = Appointment::query();
        if ($startDate && $endDate) {
            $appointmentsQuery->whereBetween('date', [$startDate, $endDate]);
        }
        if ($doctorId) {
            $appointmentsQuery->where('id_doctor', $doctorId);
        }
        $appointments = $appointmentsQuery->with('patient', 'doctor')
            ->paginate(10, ['*'], 'appointments_page');

        // Fetch all medical records with optional date and doctor filtering
        $medicalRecordsQuery = MedicalRecord::query();
        if ($startDate && $endDate) {
            $medicalRecordsQuery->whereBetween('date_recorded', [$startDate, $endDate]);
        }
        if ($doctorId) {
            $medicalRecordsQuery->where('id_doctor', $doctorId);
        }
        $medicalRecords = $medicalRecordsQuery->with('patient', 'doctor', 'appointment')
            ->paginate(10, ['*'], 'medical_records_page');

        // Optional patient search (only if provided)
        $searchQuery = $request->input('search');
        $patient = null;

        if ($searchQuery) {
            $patient = Patient::where('id', $searchQuery)
                              ->orWhere('full_name', 'like', "%$searchQuery%")
                              ->first();

            if ($patient) {
                // Filter appointments and medical records by patient if search is used
                $appointmentsQuery->where('id_patient', $patient->id);
                $medicalRecordsQuery->where('id_patient', $patient->id);
                $appointments = $appointmentsQuery->with('patient', 'doctor')
                    ->paginate(10, ['*'], 'appointments_page');
                $medicalRecords = $medicalRecordsQuery->with('patient', 'doctor', 'appointment')
                    ->paginate(10, ['*'], 'medical_records_page');
            }
        }

        // Return the view with all data
        return view('managers.index', compact(
            'totals', 'appointments', 'medicalRecords', 'patient', 'searchQuery', 'startDate', 'endDate', 'doctors', 'doctorId'
        ));
    }

    // Print all appointments (not paginated)
    public function printAppointments(Request $request)
    {
        // Handle custom date range for filtering
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        // Handle doctor filter
        $doctorId = $request->input('doctor_id');
        $selectedDoctor = $doctorId ? Doctor::find($doctorId) : null;

        // Fetch all appointments with optional date and doctor filtering (no pagination)
        $appointmentsQuery = Appointment::query();
        if ($startDate && $endDate) {
            $appointmentsQuery->whereBetween('date', [$startDate, $endDate]);
        }
        if ($doctorId) {
            $appointmentsQuery->where('id_doctor', $doctorId);
        }

        // Optional patient search
        $searchQuery = $request->input('search');
        $patient = null;
        if ($searchQuery) {
            $patient = Patient::where('id', $searchQuery)
                              ->orWhere('full_name', 'like', "%$searchQuery%")
                              ->first();
            if ($patient) {
                $appointmentsQuery->where('id_patient', $patient->id);
            }
        }

        $appointments = $appointmentsQuery->with('patient', 'doctor')->get();

        return view('managers.print_appointments', compact('appointments', 'startDate', 'endDate', 'patient', 'searchQuery', 'selectedDoctor'));
    }

    // Print all medical records (not paginated)
    public function printMedicalRecords(Request $request)
    {
        // Handle custom date range for filtering
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : null;

        // Handle doctor filter
        $doctorId = $request->input('doctor_id');
        $selectedDoctor = $doctorId ? Doctor::find($doctorId) : null;

        // Fetch all medical records with optional date and doctor filtering (no pagination)
        $medicalRecordsQuery = MedicalRecord::query();
        if ($startDate && $endDate) {
            $medicalRecordsQuery->whereBetween('date_recorded', [$startDate, $endDate]);
        }
        if ($doctorId) {
            $medicalRecordsQuery->where('id_doctor', $doctorId);
        }

        // Optional patient search
        $searchQuery = $request->input('search');
        $patient = null;
        if ($searchQuery) {
            $patient = Patient::where('id', $searchQuery)
                              ->orWhere('full_name', 'like', "%$searchQuery%")
                              ->first();
            if ($patient) {
                $medicalRecordsQuery->where('id_patient', $patient->id);
            }
        }

        $medicalRecords = $medicalRecordsQuery->with('patient', 'doctor', 'appointment')->get();

        return view('managers.print_medical_records', compact('medicalRecords', 'startDate', 'endDate', 'patient', 'searchQuery', 'selectedDoctor'));
    }

    // Simplified helper function for appointment totals
    private function getAppointmentTotals()
    {
        return [
            'totalToday' => Appointment::whereDate('date', Carbon::today())->count(),
            'totalThisMonth' => Appointment::whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->count(),
            'totalThisYear' => Appointment::whereYear('date', Carbon::now()->year)->count()
        ];
    }

    // Other methods (index, create, store, etc.) remain unchanged
    public function index()
    {
        $hospitalManagers = HospitalManager::all();
        return view('hospital_managers.index', compact('hospitalManagers'));
    }

    public function create()
    {
        return view('hospital_managers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:hospital_managers,email',
            'phone_number' => 'required|unique:hospital_managers,phone_number',
        ]);

        HospitalManager::create($request->all());

        return redirect()->route('hospital_managers.index')->with('success', 'Hospital Manager created successfully');
    }

    public function show(HospitalManager $hospitalManager)
    {
        return view('hospital_managers.show', compact('hospitalManager'));
    }

    public function edit(HospitalManager $hospitalManager)
    {
        return view('hospital_managers.edit', compact('hospitalManager'));
    }

    public function update(Request $request, HospitalManager $hospitalManager)
    {
        $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:hospital_managers,email,' . $hospitalManager->id,
            'phone_number' => 'required|unique:hospital_managers,phone_number,' . $hospitalManager->id,
        ]);

        $hospitalManager->update($request->all());

        return redirect()->route('hospital_managers.index')->with('success', 'Hospital Manager updated successfully');
    }

    public function destroy(HospitalManager $hospitalManager)
    {
        $hospitalManager->delete();

        return redirect()->route('hospital_managers.index')->with('success', 'Hospital Manager deleted successfully');
    }
}
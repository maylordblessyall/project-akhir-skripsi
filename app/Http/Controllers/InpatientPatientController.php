<?php
namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Add this import
use Carbon\Carbon;

class InpatientPatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }
    
        // Filter for inpatients and order from oldest to newest
        $patients = $query
    
            ->oldest() // Change to oldest()
            ->paginate(10);
    
        return view('inpatient.index', compact('patients'));
    }

    public function create()
    {
        return view('inpatient.create'); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', Rule::unique('patients')], // Validate and ensure NIK is unique
            'full_name' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', Rule::in(['male', 'female'])], // Validate gender
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email' => ['nullable', 'email', Rule::unique('patients')], // Validate email (optional)
            'golongan_darah' => ['nullable', 'string', Rule::in(['A', 'B', 'AB', 'O'])], // Validate blood type (optional)
            'alergi' => ['nullable', 'string'],
            'riwayat_medis' => ['nullable', 'string'],
            'obat_yang_dikonsumsi' => ['nullable', 'string'],
        ]);

        Patient::create($validatedData);

        return redirect()->route('inpatient.patients.index')->with('success', 'Patient created successfully.');
    }
    
    public function edit(Patient $patient)
    {
        return view('inpatient.edit', compact('patient')); 
    }

    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', Rule::unique('patients')->ignore($patient->id)], // Validate and ensure NIK is unique except for the current patient
            'full_name' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', Rule::in(['male', 'female'])], // Validate gender
            'address' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email' => ['nullable', 'email', Rule::unique('patients')->ignore($patient->id)], // Validate email (optional)
            'golongan_darah' => ['nullable', 'string', Rule::in(['A', 'B', 'AB', 'O'])], // Validate blood type (optional)
            'alergi' => ['nullable', 'string'],
            'riwayat_medis' => ['nullable', 'string'],
            'obat_yang_dikonsumsi' => ['nullable', 'string'],
        ]);

        $patient->update($validatedData);

        return redirect()->route('inpatient.patients.index')->with('success', 'Patient updated successfully.');
    }

    // ... other methods (e.g., destroy) ...
}

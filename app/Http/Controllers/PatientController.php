<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $patients = Patient::query();
        if ($search) {
            $patients->where(function($query) use ($search) {
            $query->where('id', $search)
            ->orWhere('nik',$search)
            ->orWhere('full_name',$search)
            ->orWhere('email',$search);
            })
            ->paginate(10);
        }

        // Apply further filtering or sorting if needed
        $patients = $patients->paginate(10); // Adjust pagination as needed

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required|string|max:20|unique:patients,phone_number',
            'email' => 'required|email|unique:patients,email',
            // Add other fields as needed
        ]);

        Patient::create($validatedData);

        return redirect()->route('patients.index')->with('success', 'Patient created successfully');
    }

    public function getDetails($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $medicalRecords = MedicalRecord::where('id_patient', $id)->get();

            return response()->json([
                'patient' => $patient,
                'medicalRecords' => $medicalRecords,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load patient details.'], 500);
        }
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
    
    public function printDetails(Patient $patient)
    {
        $medicalRecords = MedicalRecord::where('id_patient', $patient->id)->get();
        return view('patients.printDetails', compact('patient', 'medicalRecords'));
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'nik' => 'required|unique:patients,nik,' . $patient->id,
            'full_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required|string|max:20|unique:patients,phone_number,' . $patient->id,
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            // Add other fields as needed
        ]);

        $patient->update($validatedData);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Admission;
use App\Models\InpatientMedicalRecord;
use App\Models\DoctorCommission;
use App\Models\Room;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InpatientMedicalRecordController extends Controller
{
    public function createForInpatient(Admission $admission)
    {
        $doctors = Doctor::all();
        return view('medical_records.create_for_inpatient', compact('admission', 'doctors'));
    }

    public function storeForInpatient(Request $request, Admission $admission)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'date_recorded' => 'required|date',
                'subjective' => 'required|string',
                'objective' => 'required|string',
                'assessment' => 'required|string',
                'plan' => 'required|string',
            ]);

            $validatedData['admission_id'] = $admission->id;
            $validatedData['patient_id'] = $admission->patient_id;
            $validatedData['doctor_id'] = $admission->doctor_id; 

            InpatientMedicalRecord::create($validatedData);

            $doctorCommissionRate = DoctorCommission::where('doctor_id', $admission->doctor_id)->value('commission_amount');
            if (!$doctorCommissionRate) {
                throw new \Exception("Doctor commission rate not found for doctor ID: " . $admission->doctor_id);
            }

            // Create the doctor's commission record
            DoctorCommission::create([
                'doctor_id' => $admission->doctor_id,
                'admission_id' => $admission->id,
                'commission_amount' => $doctorCommissionRate, // Use the commission rate
            ]);

            // Update the total bill in the Admission model
            $admission->total_bill += $doctorCommissionRate;
            $admission->save();
            DB::commit();

            return redirect()->route('admissions.index')
                ->with('success', 'Medical record for inpatient created successfully.');

        } catch (ValidationException $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to create medical record: ' . $e->getMessage());
        }
    }
    
    public function indexInpatient(Request $request)
    {
        // Fetch doctors for the dropdown
        $doctors = Doctor::orderBy('full_name')->get();

        // Build the query for inpatient medical records
        $query = InpatientMedicalRecord::with(['admission.patient', 'admission.doctor'])
            ->whereHas('admission');

        // Filter by patient name or ID
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $query->whereHas('admission.patient', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }

        // Filter by doctor
        if ($request->has('doctor_id') && $request->input('doctor_id')) {
            $doctorId = $request->input('doctor_id');
            $query->whereHas('admission', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->input('start_date')) {
            $query->whereHas('admission', function ($q) use ($request) {
                $q->where('admission_date', '>=', $request->input('start_date'));
            });
        }

        if ($request->has('end_date') && $request->input('end_date')) {
            $query->whereHas('admission', function ($q) use ($request) {
                $q->where('admission_date', '<=', $request->input('end_date'));
            });
        }

        // Paginate results
        $inpatientMedicalRecords = $query->latest()->paginate(10);

        return view('medical_records.index_inpatient', compact('inpatientMedicalRecords', 'doctors'));
    }

        public function printInpatient(Request $request)
    {
        $query = InpatientMedicalRecord::with(['admission.patient', 'admission.doctor'])
            ->whereHas('admission');

        $searchQuery = null;
        if ($request->has('search') && $request->input('search')) {
            $search = $request->input('search');
            $searchQuery = $search;
            $query->whereHas('admission.patient', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }

        $selectedDoctor = null;
        if ($request->has('doctor_id') && $request->input('doctor_id')) {
            $doctorId = $request->input('doctor_id');
            $selectedDoctor = Doctor::find($doctorId);
            $query->whereHas('admission', function ($q) use ($doctorId) {
                $q->where('doctor_id', $doctorId);
            });
        }

        $startDate = $request->has('start_date') && $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))
            : null;
        if ($startDate) {
            $query->whereHas('admission', function ($q) use ($startDate) {
                $q->where('admission_date', '>=', $startDate);
            });
        }

        $endDate = $request->has('end_date') && $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))
            : null;
        if ($endDate) {
            $query->whereHas('admission', function ($q) use ($endDate) {
                $q->where('admission_date', '<=', $endDate);
            });
        }

        $inpatientMedicalRecords = $query->latest()->get();

        return view('medical_records.print_inpatient', compact(
            'inpatientMedicalRecords',
            'startDate',
            'endDate',
            'selectedDoctor',
            'searchQuery'
        ));
    }

    public function showDetailsInpatient(Admission $admission) 
    {
        // Fetch all inpatient medical records for the given admission
        $medicalRecords = InpatientMedicalRecord::where('admission_id', $admission->id)
            ->with('admission.doctor')
            ->get();

        // Fetch the patient from the admission
        $patient = $admission->patient;

        // Check if any medical records were found
        if ($medicalRecords->isEmpty()) {
            return redirect()->back()->with('error', 'No medical records found for this admission.');
        }

        // Return the view with medical records, admission, and patient data
        return view('medical_records.show_inpatient', compact('medicalRecords', 'admission', 'patient')); 
    }
    
    public function printDetailsInpatient(Request $request, Admission $admission) 
    {
        // Fetch medical records for the specific admission
        $medicalRecords = InpatientMedicalRecord::where('admission_id', $admission->id)
            ->with('admission.doctor')
            ->get();

        // Fetch patient data from admission
        $patient = $admission->patient;

        // Check if any medical records were found
        if ($medicalRecords->isEmpty()) {
            return redirect()->back()->with('error', 'No medical records found for this admission.');
        }

        // Return the view with medical records, admission, and patient data
        return view('medical_records.print_inpatient', compact('medicalRecords', 'admission', 'patient')); 
    }

    public function editInpatient(Admission $admission)
    {
        $medicalRecord = InpatientMedicalRecord::where('admission_id', $admission->id)->latest()->first();
        $doctors = Doctor::all();
        $patients = Patient::all();
        $rooms = Room::all();
        return view('medical_records.edit_inpatient', compact('medicalRecord', 'admission', 'patients', 'doctors', 'rooms'));
    }
}
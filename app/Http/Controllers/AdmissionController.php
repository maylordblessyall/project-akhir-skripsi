<?php
namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Patient;
use App\Models\Room;
use App\Models\Doctor;
use App\Models\DoctorCommission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdmissionController extends Controller
{
    public function __construct()
    {
       
    }
    public function index(Request $request)
    {
        // Fetch all rooms
        $rooms = Room::with(['admissions' => function ($query) {
            $query->whereNull('discharge_date')->with('patient');
        }])->get();

        // Fetch admissions for search functionality (optional, if you want to keep table view as an alternative)
        $query = Admission::with('patient', 'doctor', 'room')
                          ->whereNull('discharge_date');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }

        $admissions = $query->latest()->paginate(10);

        return view('admissions.index', compact('rooms', 'admissions'));
    }
    public function create(Request $request)
    {
        $patients = Patient::all();
    
        // Check occupancy status if there's a specific date in the request
        if ($request->has('admission_date')) {
            $rooms = Room::whereDoesntHave('admissions', function ($query) use ($request) {
                $query->whereNull('discharge_date')
                    ->orWhere('discharge_date', '>=', $request->admission_date);
            })->get();
        } else {
            $rooms = Room::all(); 
        }
    
        $roomOptions = $rooms->mapWithKeys(function ($room) {
            return [$room->id => $room->name . (Admission::isRoomOccupied($room->id) ? ' (Occupied)' : '')];
        });
    
        $doctors = Doctor::all(); // Fetch all doctors
    
        return view('admissions.create', compact('patients', 'roomOptions', 'rooms', 'doctors'))->with('admissionModel', new Admission());
    }
    
    public function edit(Admission $admission)
    {
        $patients = Patient::all();
        $rooms = Room::all();
        $doctors = Doctor::all(); // Add doctors
    
        $roomOptions = $rooms->mapWithKeys(function ($room) use ($admission) {
            $isOccupied = Admission::isRoomOccupied($room->id) && $admission->room_id != $room->id;
            return [$room->id => $room->name . ($isOccupied ? ' (Occupied)' : '')];
        });
    
        return view('admissions.edit', compact('admission', 'patients', 'roomOptions', 'rooms', 'doctors'))->with('admissionModel', new Admission());
    }

    public function update(Request $request, Admission $admission)
    {
        // Begin transaction for data integrity
        DB::beginTransaction();
    
        try {
            // Validate the incoming data
            $validatedData = $request->validate([
                'admission_date' => 'required|date',
                'discharge_date' => 'nullable|date|after_or_equal:admission_date',
                'room_id' => [
                    'required',
                    'exists:rooms,id',
                    Rule::unique('admissions', 'room_id')
                        ->ignore($admission->id) // Exclude current admission from unique check
                        ->whereNull('discharge_date'), // Only check against currently occupied rooms
                ],
                'reason' => 'nullable|string',
            ], [
                'room_id.unique' => 'The selected room is currently occupied.',
            ]);
    
            // Update the Admission model with validated data
            $admission->update($validatedData);
    
            // Commit the transaction
            DB::commit();
    
            // Redirect back to the admission list with success message
            return redirect()->route('admissions.index')->with('success', 'Admission updated successfully.');
    
        } catch (ValidationException $e) {
            // Rollback the transaction if validation fails
            DB::rollback();
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Rollback the transaction if any other exception occurs
            DB::rollback();
    
            // Log the error for debugging
            Log::error("Error updating admission: {$e->getMessage()}");
    
            // Return a generic error message to the user
            return back()->with('error', 'An error occurred while updating the admission.');
        }
    }    
    public function store(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $validatedData = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'doctor_id' => 'required|exists:doctors,id',
                'admission_date' => 'required|date',
                'discharge_date' => 'nullable|date|after_or_equal:admission_date',
                'room_id' => [
                    'required',
                    'exists:rooms,id',
                    Rule::unique('admissions', 'room_id')
                        ->whereNull('discharge_date'), // Ensure room is not occupied
                ],
                'reason' => 'nullable|string',
            ], [
                'room_id.unique' => 'The selected room is currently occupied.',
            ]);
    
            $admission = Admission::create($validatedData);
    
            DB::commit();
    
            return redirect()->route('admissions.index')->with('success', 'Admission created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error creating admission: ' . $e->getMessage());
        }
    }
    
    public function destroy(Admission $admission)
    {
        DB::beginTransaction(); 

        try {
            // Additional logic before deletion if needed (e.g., check for related records)
            $admission->delete();

            DB::commit();

            return redirect()->route('admissions.index')->with('success', 'Admission deleted successfully.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error deleting admission: ' . $e->getMessage());
        }
    }
    
    public function getAvailableRooms(Request $request)
    {
        $admissionDate = $request->has('admission_date') ? Carbon::parse($request->input('admission_date')) : null;
    
        $rooms = Room::whereDoesntHave('admissions', function ($query) use ($admissionDate) {
            $query->where(function ($q) use ($admissionDate) {
                $q->whereNull('discharge_date'); 
    
                if ($admissionDate) {
                    $q->orWhere(function ($q2) use ($admissionDate) {
                        $q2->where('admission_date', '<=', $admissionDate)
                           ->where('discharge_date', '>=', $admissionDate);
                    });
                }
            });
        })->get();
    
        $roomsWithStatus = $rooms->map(function ($room) {
            return [
                'id' => $room->id,
                'name' => $room->name,
                'occupied' => $room->isOccupied($room->id) 
            ];
        });
    
        return response()->json($roomsWithStatus);
    }
    
    
    // ...(edit, update, destroy methods - similar to previous examples)
}
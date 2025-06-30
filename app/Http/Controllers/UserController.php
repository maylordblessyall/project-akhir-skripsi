<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'user_type' => 'required|in:admin,doctor,registration_staff,perawat,hospital_manager',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|string|max:50',
        ]);

        Log::info('Validated Data:', $validatedData);

        try {
            DB::beginTransaction();

            $user = User::create([
                'access_level' => $validatedData['user_type'],
                'email' => $validatedData['email'],
                'password_hash' => $validatedData['password'], // Mutator handles hashing
                'username' => $validatedData['name'],
            ]);

            Log::info('Created User', ['user' => $user->toArray()]);

            DB::commit();

            return redirect()->route('admin.dashboard')
                             ->with('success', 'Registration successful. Please log in.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to create user: ' . $e->getMessage(), [
                'data' => $validatedData,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('register')
                             ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])
                             ->withInput();
        }
    }

    public function showDashboard()
    {        

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
    
        if ($user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isDoctor()) {
            return view('doctor.dashboard');
        } elseif ($user->isRegistrationStaff()) {
            return view('registrationstaff.dashboard');
        } elseif ($user->isNurse()) {
            return view('nurse.dashboard');
        } elseif ($user->isHospitalManager()) {
            return view('manager.dashboard');
        }
        return view('dashboard');
    }
    // public function doctorsDashboard()
    // {        
    //     $totalAppointments = Appointment::count();
    //     $totalAdmissions = Admission::count();
    //     $totalPatients = Patient::count();  

    //     return view('doctor.dashboard', compact(
    //         'totalAppointments',
    //         'totalAdmissions',
    //         'totalPatients'
    //     ));
    //     /** @var \App\Models\User|null $user */
    //     $user = Auth::user();
    //     if (!$user) {
    //         return redirect()->route('login');
    //     }
    
    //     if ($user->isAdmin()) {
    //         return view('admin.dashboard');
    //     } elseif ($user->isDoctor()) {
    //         return view('doctor.dashboard');
    //     } elseif ($user->isRegistrationStaff()) {
    //         return view('registrationstaff.dashboard');
    //     } elseif ($user->isNurse()) {
    //         return view('nurse.dashboard');
    //     } elseif ($user->isHospitalManager()) {
    //         return view('manager.dashboard');
    //     }
    //     return view('dashboard');
    // }
    public function nursesDashboard()
    {        
        $totalAppointments = Appointment::count();
        $totalAdmissions = Admission::count();
        $totalPatients = Patient::count();

        return view('nurse.dashboard', compact(
            'totalAppointments',
            'totalAdmissions',
            'totalPatients'
        ));
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
    
        if ($user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isDoctor()) {
            return view('doctor.dashboard');
        } elseif ($user->isRegistrationStaff()) {
            return view('registrationstaff.dashboard');
        } elseif ($user->isNurse()) {
            return view('nurse.dashboard');
        } elseif ($user->isHospitalManager()) {
            return view('manager.dashboard');
        }
        return view('dashboard');
    }
    public function staffsDashboard()
    {      
        $totalAppointments = Appointment::count();
        $totalAdmissions = Admission::count();
        $totalPatients = Patient::count();  

        return view('registrationstaff.dashboard', compact(
            'totalAppointments',
            'totalAdmissions',
            'totalPatients'
        ));
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
    
        if ($user->isAdmin()) {
            return view('admin.dashboard');
        } elseif ($user->isDoctor()) {
            return view('doctor.dashboard');
        } elseif ($user->isRegistrationStaff()) {
            return view('registrationstaff.dashboard');
        } elseif ($user->isNurse()) {
            return view('nurse.dashboard');
        } elseif ($user->isHospitalManager()) {
            return view('manager.dashboard');
        }
        return view('dashboard');
    }
}
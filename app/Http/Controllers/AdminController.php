<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Admission;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    
    public function dashboard()
    {
        $totalAppointments = Appointment::count();
        $totalAdmissions = Admission::count();
        $totalPatients = Patient::count();

        return view('admin.dashboard', compact(
            'totalAppointments',
            'totalAdmissions',
            'totalPatients'
        ));
    }

    public function index()
    {
        $admins = Admin::paginate(10);
        return view('user.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('user.admins.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'unique:admins'],
            'full_name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:admins'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'email', 'unique:admins'],
            'phone_number' => ['required', 'string']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        Admin::create($validatedData);

        return redirect()->route('admins.index')->with('success', 'Admin created successfully!');
    }

    public function edit(Admin $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', Rule::unique('admins')->ignore($admin->id)],
            'full_name' => ['required', 'string'],
            'username' => ['required', 'string', Rule::unique('admins')->ignore($admin->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'phone_number' => ['required', 'string']
        ]);

        if ($validatedData['password']) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $admin->update($validatedData);

        return redirect()->route('admins.index')->with('success', 'Admin updated successfully!');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admins.index')->with('success', 'Admin deleted successfully!');
    }
}
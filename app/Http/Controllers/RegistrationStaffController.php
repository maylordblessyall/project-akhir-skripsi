<?php

namespace App\Http\Controllers;
use App\Models\RegistrationStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class RegistrationStaffController extends Controller
{
    public function index()
    {
        $registrationstaff = RegistrationStaff::all();
        return view('user.registrationstaff.index', compact('registrationstaff')); 
    }


    public function create()
    {
        $registrationstaff = RegistrationStaff::all(); // Add this line
        return view('user.registrationstaff.create', compact('registrationstaff')); // Update the view name
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'unique:registration_staff'],
            'full_name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:registration_staff'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'email', 'unique:registration_staff'],
            'phone_number' => ['required', 'string', 'unique:registration_staff'],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']); // Hash the password

        RegistrationStaff::create($validatedData);

        return redirect()->route('registrationstaff.index')->with('success', 'Registration Staff created successfully');
    }

    public function edit(RegistrationStaff $registrationstaff) // Use route model binding
    {
        return view('user.registrationstaff.edit', compact('registrationstaff'));
    }

    public function update(Request $request, RegistrationStaff $registrationstaff)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', Rule::unique('registration_staff')->ignore($registrationstaff->id)],
            'full_name' => ['required', 'string'],
            'username' => ['required', 'string', Rule::unique('registration_staff')->ignore($registrationstaff->id)],
            // 'password' => ['nullable', 'string', 'min:8'], // Only require if changing password
            'email' => ['required', 'email', Rule::unique('registration_staff')->ignore($registrationstaff->id)],
            'phone_number' => ['required', 'string', Rule::unique('registration_staff')->ignore($registrationstaff->id)],
        ]);

        if ($request->filled('password')) { // Hash only if new password provided
            $validatedData['password'] = Hash::make($request->password);
        }

        $registrationstaff->update($validatedData);

        return redirect()->route('registrationstaff.index')->with('success', 'Registration Staff updated successfully');
    }

    public function destroy(RegistrationStaff $registrationstaff)
    {
        $registrationstaff->delete();
        return redirect()->route('registrationstaff.index')->with('success', 'Registration Staff deleted successfully');
    }
}

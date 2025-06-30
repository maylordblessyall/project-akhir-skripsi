<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function index()
    {
        $doctors = Doctor::all();
        return view('user.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('user.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'specialization' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:doctors,email',
            'phone_number' => 'required|unique:doctors,phone_number',
            'amount' => 'required',
        ]);

        Doctor::create($request->all());

        return redirect()->route('user.doctors.index')->with('success', 'Doctor created successfully');
    }

    public function show(Doctor $doctor)
    {
        return view('user.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('user.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'specialization' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'phone_number' => 'required|unique:doctors,phone_number,' . $doctor->id,
            'amount' => 'required',
        ]);

        $doctor->update($request->all());

        return redirect()->route('user.doctors.index')->with('success', 'Doctor updated successfully');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return redirect()->route('user.doctors.index')->with('success', 'Doctor deleted successfully');
    }
}
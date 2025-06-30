<?php

namespace App\Http\Controllers;

use App\Models\Pharmacist;
use Illuminate\Http\Request;

class PharmacistController extends Controller
{
    public function index()
    {
        $pharmacists = Pharmacist::all();
        return view('pharmacists.index', compact('pharmacists'));
    }

    public function create()
    {
        return view('pharmacists.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:pharmacists,email',
            'phone_number' => 'required|unique:pharmacists,phone_number',
        ]);

        Pharmacist::create($validatedData);

        return redirect()->route('pharmacists.index')->with('success', 'Pharmacist created successfully');
    }

    public function show(Pharmacist $pharmacist)
    {
        return view('pharmacists.show', compact('pharmacist'));
    }

    public function edit(Pharmacist $pharmacist)
    {
        return view('pharmacists.edit', compact('pharmacist'));
    }

    public function update(Request $request, Pharmacist $pharmacist)
    {
        $validatedData = $request->validate([
            'nik' => 'required',
            'full_name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:pharmacists,email,' . $pharmacist->id,
            'phone_number' => 'required|unique:pharmacists,phone_number,' . $pharmacist->id,
        ]);

        $pharmacist->update($validatedData);

        return redirect()->route('pharmacists.index')->with('success', 'Pharmacist updated successfully');
    }

    public function destroy(Pharmacist $pharmacist)
    {
        $pharmacist->delete();

        return redirect()->route('pharmacists.index')->with('success', 'Pharmacist deleted successfully');
    }
}

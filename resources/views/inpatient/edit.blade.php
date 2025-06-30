@extends('inpatient')

@section('title', 'Edit Inpatient')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
        }
        .edit-patient-container {
            max-width: 1000px; /* Increased width for better readability */
            margin: 50px auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #28a745;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #007bff;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            grid-column: span 2; 
            justify-self: center; 
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
        }

        .edit-patient-container form {
            display: grid;
            grid-template-columns: 1fr 1fr; 
            gap: 20px;
        }
        .form-group {
            margin-bottom: 0; 
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
        }

        /* Alert Styles */
        .alert {
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        @media (max-width: 768px) {
            .edit-patient-container {
                padding: 20px;
            }
            .form-group {
                margin-bottom: 20px;
            }
        }
    </style>

    <div class="edit-patient-container">
        <h2>Edit Inpatient</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="table-responsive">
        <form action="{{ route('inpatient.patients.update', $patient->id) }}" method="POST" aria-labelledby="editPatientTitle">
                @csrf
                @method('PUT')
    
                <div class="form-group">
                    <label for="nik">NIK:</label>
                    <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $patient->nik) }}" required>
                </div>
    
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $patient->full_name) }}" required>
                </div>
    
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', Carbon::parse($patient->date_of_birth)->format('Y-m-d')) }}" required>
                </div>
    
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $patient->gender) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $patient->gender) === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address', $patient->address) }}</textarea>
                </div>
    
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $patient->phone_number) }}" required>
                </div>
    
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $patient->email) }}">
                </div>
    
                <div class="form-group">
                    <label for="golongan_darah">Golongan Darah (Blood Type):</label>
                    <select name="golongan_darah" id="golongan_darah" class="form-control">
                        <option value="">Select</option>
                        <option value="A" {{ old('golongan_darah', $patient->golongan_darah) === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah', $patient->golongan_darah) === 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah', $patient->golongan_darah) === 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah', $patient->golongan_darah) === 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
    
                <div class="form-group">
                    <label for="alergi">Alergi (Allergies):</label>
                    <textarea name="alergi" id="alergi" rows="3" class="form-control">{{ old('alergi', $patient->alergi) }}</textarea>
                </div>
    
                <div class="form-group">
                    <label for="riwayat_medis">Riwayat Medis (Medical History):</label>
                    <textarea name="riwayat_medis" id="riwayat_medis" rows="3" class="form-control">{{ old('riwayat_medis', $patient->riwayat_medis) }}</textarea>
                </div>
    
                <div class="form-group">
                    <label for="obat_yang_dikonsumsi">Obat yang Dikonsumsi (Current Medications):</label>
                    <textarea name="obat_yang_dikonsumsi" id="obat_yang_dikonsumsi" rows="3" class="form-control">{{ old('obat_yang_dikonsumsi', $patient->obat_yang_dikonsumsi) }}</textarea>
                </div>
    
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                </div>
            </form>
        </div>
    </div>
@endsection
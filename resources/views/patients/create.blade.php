@extends('layouts')

@section('title')
    Create New Patient
@endsection
<style>
    .patient-form {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .patient-form h1 {
        text-align: center;
        color: #333;
        font-size: 2rem;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 1rem;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0069d9;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-danger ul {
        margin-bottom: 0;
        list-style: none;
        padding-left: 0;
    }
</style>

@section('content')
    <div class="patient-form">
        <h1>Create New Patient</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nik">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="golongan_darah">Golongan Darah (Blood Type):</label>
                <select name="golongan_darah" id="golongan_darah" class="form-control">
                    <option value="">Select</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alergi">Alergi (Allergies):</label>
                <textarea name="alergi" id="alergi" rows="3" class="form-control">{{ old('alergi') }}</textarea>
            </div>
            <div class="form-group">
                <label for="riwayat_medis">Riwayat Medis (Medical History):</label>
                <textarea name="riwayat_medis" id="riwayat_medis" rows="3" class="form-control">{{ old('riwayat_medis') }}</textarea>
            </div>
            <div class="form-group">
                <label for="obat_yang_dikonsumsi">Obat yang Dikonsumsi (Current Medications):</label>
                <textarea name="obat_yang_dikonsumsi" id="obat_yang_dikonsumsi" rows="3" class="form-control">{{ old('obat_yang_dikonsumsi') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Patient</button>
        </form>
    </div>
@endsection
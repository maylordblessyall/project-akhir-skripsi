@extends('layouts')

@section('title', 'Create Medical Record for Patient')

@section('styles')
<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-transform: uppercase;
        font-weight: 600;
        position: relative;
    }

    .card-header::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin-bottom: 15px;
    }

    .card-body strong {
        display: inline-block;
        width: 180px;
        font-weight: 600;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        height: auto;
    }

    .alert {
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .invalid-feedback {
        display: block;
    }

    textarea.form-control {
        min-height: 100px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Create Medical Record for {{ $appointment->patient->full_name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">Appointment Information</div>
        <div class="card-body">
            <p><strong>Appointment ID:</strong> {{ $appointment->id }}</p>
            <p><strong>Patient ID:</strong> {{ $appointment->patient->id }}</p>
            <p><strong>Patient Name:</strong> {{ $appointment->patient->full_name }}</p>
            <p><strong>Doctor Name:</strong> {{ $appointment->doctor->full_name }}</p>
            <p><strong>Appointment Date:</strong> {{ $appointment->date}}</p>
        </div>
    </div>

    <form action="{{ route('medical-records.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">SOAP Notes</div>
            <div class="card-body">
                <input type="hidden" name="id_appointment" value="{{ $appointment->id }}"> 
                <input type="hidden" name="id_patient" value="{{ $appointment->patient->id }}"> 
                <input type="hidden" name="id_doctor" value="{{ $appointment->doctor->id }}"> 
                <input type="hidden" name="full_name" value="{{ $appointment->patient->full_name }}"> 
                <input type="hidden" name="date_recorded" value="{{ $appointment->date}}"> 

                @foreach(['subjective', 'objective', 'assessment', 'plan'] as $field)
                    <div class="form-group">
                        <label for="{{ $field }}">{{ ucfirst($field) }}:</label>
                        <textarea class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" rows="3" required>{{ old($field) }}</textarea>
                        @error($field)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endforeach

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Save SOAP</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
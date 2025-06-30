@extends('inpatient')

@section('title')
    Create Medical Record for Inpatient
@endsection

@section('style')
<style>
    .form-label {
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 0;
    }

    textarea.form-control {
        height: auto;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: all 0.3s ease; /* Changed from background-color to all */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: scale(1.02); /* Adds a slight scale effect on hover for buttons */
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        font-weight: 500;
        border-radius: 0.25rem; /* Rounded corners for alerts */
    }

    .alert-danger ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .container {
        margin-top: 20px;
        max-width: 1140px; /* Limit the container width for better readability on larger screens */
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .col-md-4, .col-md-8 {
            width: 100%;
        }
    }
</style>
@endsection('style')
@section('content')
<div class="container">
    <h2 class="mb-4">Create Medical Record for {{ $admission->patient->full_name }} ({{ $admission->patient->id }})</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('medical_records.storeForInpatient', $admission) }}" method="POST">
        @csrf

        <div class="row g-3">
            {{-- Patient Information (Read-only) --}}
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Patient Information</div>
                    <div class="card-body">
                        <p><strong>ID:</strong> {{ $admission->patient->id }}</p>
                        <p><strong>Name:</strong> {{ $admission->patient->full_name }}</p>
                        <p><strong>ID Docter:</strong> {{ $admission->doctor_id }}</p>
                        <p><strong>Nama Docter:</strong> {{ $admission->doctor->full_name }}</p>
                        <p><strong>NIK:</strong> {{ $admission->patient->nik }}</p>
                        <p><strong>Blood Type:</strong> {{ $admission->patient->golongan_darah }}</p>
                        <p><strong>Allergies:</strong> {{ $admission->patient->alergi }}</p>
                        <p><strong>Medical History:</strong> {{ $admission->patient->riwayat_medis }}</p>
                        <p><strong>Current Medications:</strong> {{ $admission->patient->obat_yang_dikonsumsi }}</p>
                        <p><strong>Admission Date:</strong> {{ $admission->admission_date }}</p>
                        <p><strong>Room Number:</strong> {{ optional($admission->room)->name }}</p>
                    </div>
                </div>
            </div>

            {{-- Medical Record Form --}}
            <div class="col-md-8">
                <input type="hidden" name="patient_id" value="{{ $admission->patient_id }}">

                <div class="mb-3">
                    <label for="date_recorded" class="form-label">Date Recorded:</label>
                    <input type="date" name="date_recorded" id="date_recorded" class="form-control" value="{{ old('date_recorded', now()->format('Y-m-d')) }}" required>
                </div>

                @foreach(['subjective', 'objective', 'assessment', 'plan'] as $field)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label">{{ ucfirst($field) }}:</label>
                        <textarea name="{{ $field }}" id="{{ $field }}" rows="3" class="form-control">{{ old($field) }}</textarea>
                    </div>
                @endforeach

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Create Medical Record</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
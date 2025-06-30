@extends('inpatient')

@section('content')

<style>
    .header {
        border: 1px solid #ddd;
        border-radius: 10px; 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff; 
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin-bottom: 10px;
    }

    .card-body strong {
        display: inline-block;
        width: 150px; 
        font-weight: bold;
    }

    h2 {
        text-align: center; 
        margin-top: 20px;
        margin-bottom: 10px;
    }
    @media print {
    .card {
        page-break-inside: avoid; 
    }

    .d-flex { 
        display: none; 
    }
}
</style>
<div class="container">
    <h2>Medical Records for {{ $patient->full_name }} 
        @if ($medicalRecords->isNotEmpty() && isset($medicalRecords[0]))
        (Admission ID: {{ $medicalRecords[0]->admission->id }})
        @endif
    </h2> 
    
    <h2>Patient Details</h2>
    
        <div class="header">
            <div class="card-header">Patient Information</div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $patient->id }}</p>
                <p><strong>Name:</strong> {{ $patient->full_name }}</p>
                <p><strong>NIK:</strong> {{ $patient->nik }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->date_of_birth }}</p>
                <p><strong>Gender:</strong> {{ $patient->gender }}</p>
                <p><strong>Address:</strong> {{ $patient->address }}</p>
                <p><strong>Phone Number:</strong> {{ $patient->phone_number }}</p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
            </div>
        </div>
        @foreach ($medicalRecords as $record)
        <div class="header">
            <div class="card-header">
                SOAP Notes - Date Recorded: {{ $record->date_recorded }}
                @if($record->admission->doctor)
                    <div>Doctor: {{ $record->admission->doctor->full_name }}</div>
                @endif
            </div>
            <div class="card-body">
                <p><strong>Subjective:</strong> {{ $record->subjective }}</p>
                <p><strong>Objective:</strong> {{ $record->objective }}</p>
                <p><strong>Assessment:</strong> {{ $record->assessment }}</p>
                <p><strong>Plan:</strong> {{ $record->plan }}</p>
            </div>
        </div>
    @endforeach
    
    <!-- Print button and script -->
    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('medical_records.indexInpatient') }}" class="btn btn-primary">Back to Inpatient Medical Records</a>
        <button class="btn btn-secondary" onclick="openPrintWindow()">Print</button> 
    </div>
</div>

<script>
    function openPrintWindow() {
        const printWindow = window.open('{{ route('medical_records.printDetailsInpatient', $medicalRecords[0]->admission->id) }}', '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>

@endsection
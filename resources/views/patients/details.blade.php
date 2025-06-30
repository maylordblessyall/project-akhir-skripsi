@extends('layouts')
@section('title')
Patient Details
@endsection
@section('content')
<style>
    .header {
        border: 1px solid #ddd;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff; /* Primary color background */
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin-bottom: 5px;
    }

    .card-body strong {
        display: inline-block;
        width: 120px; /* Adjust width as needed for alignment */
    }

    h1 {
        margin-bottom: 30px;
        font-size: 2.5em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    h2, h3 {
        color: #343a40;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .list-group-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f8f9fa; /* Subtle background color */
    }

    .list-group-item p {
        margin-bottom: 5px;
    }

    .list-group-item strong {
        display: inline-block;
        width: 150px; /* Adjust width as needed for alignment */
        font-weight: bold;
    }
    .print-container{
        background: white;
        padding: 25px;
    }
</style>

<h2>Patient Details
    
<div class="mt-3 d-flex justify-content-between">
    <button class="btn btn-secondary" onclick="openPrintWindow()">Print</button> 
</div>
</h2>

<div class="container print-container"> 
<div class="header">
    <div class="card-header">
        Patient Information
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> {{ $patient->id }}</p>
        <p><strong>Name:</strong> {{ $patient->full_name }}</p>
        <p><strong>NIK:</strong> {{ $patient->nik }}</p>
        <p><strong>Date of Birth:</strong> {{ date('d-m-Y', strtotime($patient->date_of_birth)) }}</p>
        <p><strong>Gender:</strong> {{ $patient->gender }}</p>
        <p><strong>Address:</strong> {{ $patient->address }}</p>
        <p><strong>Phone Number:</strong> {{ $patient->phone_number }}</p>
        <p><strong>Email:</strong> {{ $patient->email }}</p>
    </div>
</div>

<h3>Medical Records</h3>

@if($medicalRecords->isEmpty())
    <p>No medical records found for this patient.</p>
@else
    <div class="list-group" id="medical-records-list"> {{-- Add an ID for JavaScript reference --}}
        @foreach ($medicalRecords as $record)
        <div class="list-group-item">
            <p><strong>Date Recorded:</strong> {{ $record->date_recorded }}</p>
            <p><strong>ID Appointment:</strong> {{ $record->id_appointment }}</p>
            <p><strong>Subjective:</strong> {{ $record->subjective }}</p>
            <p><strong>Objective:</strong> {{ $record->objective }}</p>
            <p><strong>Assessment:</strong> {{ $record->assessment }}</p>
            <p><strong>Plan:</strong> {{ $record->plan }}</p>
        </div>
        @endforeach
    </div>
@endif

</div>

<script>
    function openPrintWindow() {
        const printWindow = window.open('{{ route('patients.printDetails', $patient->id) }}', '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>

@endsection
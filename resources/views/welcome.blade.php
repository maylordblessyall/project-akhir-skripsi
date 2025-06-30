@extends('layouts')

@section('title')
Appointment Dashboard
@endsection

@section('content')

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #ffffff; /* White background for the main content */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h1 {
        margin-bottom: 30px;
        font-size: 2.5em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    h2 {
        color: #343a40;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    h3 {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #e0e0e0;
        padding: 10px;
        font-size: 14px; /* Slightly larger for better readability */
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, .5);
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch; /* For smoother scrolling on touch devices */
    }

    .table {
        border-collapse: collapse; /* Ensures cells touch each other */
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 15px;
        vertical-align: middle;
        border: none;  /* Removing borders for a cleaner look */
        border-bottom: 1px solid #e0e0e0; /* Subtle bottom border for rows */
    }

    .table th {
        background-color: #3498db;
        color: white;
        font-weight: 600;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    /* Buttons */
    .btn {
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 5px;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #3498db;
        color: #ffffff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-secondary {
        background-color: #7f8c8d;
        color: #ffffff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #bdc3c7;
    }

    /* Pagination */
    .custom-pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: inline-flex;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 2px;
    }

    .pagination .page-link {
        color: #3498db;
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        padding: 8px 12px;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    .pagination .page-item.active .page-link {
        background-color: #3498db;
        color: #ffffff;
        border-color: #3498db;
    }

    .pagination .page-link:hover {
        background-color: #e0e0e0;
        border-color: #d3d3d3;
    }
</style>

<div class="container">
    <h2>Kunjungan</h2>

    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3>
                <a href="{{ route('appointments.create') }}" class="btn btn-primary">Buat Kunjungan</a>
            </h3>
        </div>
        <form action="{{ route('appointments.index') }}" method="GET" class="d-flex align-items-end">
            <div class="form-group me-2">
                <label for="date_from" class="form-label">From:</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request()->input('date_from') }}">
            </div>
            <div class="form-group me-2">
                <label for="date_to" class="form-label">To:</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request()->input('date_to') }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        @if ($appointments->isNotEmpty())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->start_time }}</td>
                        <td>{{ $appointment->end_time }}</td>
                        <td>{{ $appointment->patient->full_name ?? 'N/A' }}</td>
                        <td>{{ $appointment->doctor->full_name ?? 'N/A' }}</td>
                        <td>{{ Str::limit($appointment->notes, 50) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="custom-pagination">
                {{ $appointments->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                No appointments found. Click <a href="{{ route('appointments.create') }}">here</a> to create one.
            </div>
        @endif
    </div>
</div>

@endsection
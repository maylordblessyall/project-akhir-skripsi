@extends('layouts.app')

@section('title', 'Doctor Appointments')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #ffffff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h2 {
        color: #343a40;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
    }

    .table thead th {
        background-color: #007bff;
        color: white;
        font-weight: 600;
        border: none;
    }

    .table td {
        border-top: 1px solid #e0e0e0;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .empty-message {
        text-align: center;
        padding: 20px;
        font-style: italic;
        color: #777;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        list-style: none;
    }

    .pagination .page-item {
        margin: 0 2px;
    }

    .pagination .page-link {
        border: 1px solid #ddd;
        color: #007bff;
        padding: 0.5rem 0.75rem;
        background-color: #fff;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #ddd;
    }
</style>

<div class="container mt-4">
    <h2>Your Appointments</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Date Filter Form -->
    <form method="GET" action="{{ route('doctors.appointments') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="date_from" class="form-label">Date From</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $filters['date_from'] }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">Date To</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $filters['date_to'] }}">
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('doctors.appointments') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    @if ($appointments->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration }}</td>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->doctor->full_name ?? 'N/A' }}</td>
                            <td>{{ $appointment->date->format('Y-m-d') }}</td>
                            <td>{{ $appointment->start_time ? \Carbon\Carbon::parse($appointment->start_time)->format('H:i') : 'N/A' }}</td>
                            <td>{{ $appointment->end_time ? \Carbon\Carbon::parse($appointment->end_time)->format('H:i') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $appointments->links() }}
        </div>
    @else
        <p class="empty-message">No appointments found for the selected dates.</p>
    @endif

    <a href="{{ route('doctors.menu') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
@endsection
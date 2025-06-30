<!-- resources/views/doctors/menu.blade.php -->
@extends('layouts')

@section('title')
    Doctor Dashboard
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
        background: #ffffff;
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

    .btn {
        padding: 6px 10px;
        font-size: 0.875rem;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
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
    @if($access_level === 'doctor')
        <h2>Daftar Kunjungan ({{ \Carbon\Carbon::today()->format('d-m-Y') }})</h2>

        @if($appointments->isEmpty())
            <p class="empty-message">No appointments scheduled for today.</p>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Notes</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->patient->full_name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</td>
                                <td>{{ $appointment->notes ?? 'N/A' }}</td>
                                <td>{{ $appointment->payment_method }}</td>
                                <td>{{ number_format($appointment->amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('medical_records.create', $appointment->id) }}" class="btn btn-primary">Create Medical Record</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="pagination">
                {{ $appointments->links() }}
            </div>
        @endif
    @else
        <p class="empty-message">This dashboard is only for doctors.</p>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
</div>
@endsection
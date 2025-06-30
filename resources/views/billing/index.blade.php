@extends('inpatient')

@section('title')
Billing Dashboard
@endsection

@section('content')
<style>
    .billing-dashboard {
        background-color: #f8f8f8;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .table {
        background-color: #fff;
        border-radius: 8px;
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
        font-weight: 500;
        padding: 12px;
        text-align: center; /* Center-align table headers */
    }

    .table td, .table th {
        vertical-align: middle;
        border-top: none;
        border-bottom: 1px solid #e9ecef;
        text-align: center; /* Center-align table cells */
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-warning {
        background-color: #ffc107;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        padding: 8px 16px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .no-bills {
        text-align: center;
        font-style: italic;
        color: #777;
        margin-top: 30px;
    }

    /* Special styling for Total Bill column */
    .table th.total-bill-header {
        background-color: #0056b3; /* Slightly different shade for the Total Bill header */
        font-weight: 700;
    }

    .table td.total-bill-amount {
        font-weight: 700;
        font-size: 16px;
        color: #28a745; /* Green color to indicate money */
        background-color: rgba(0, 123, 255, 0.05); /* Very light blue background */
    }

</style>

<div class="billing-dashboard">
    <h2>Transaksi</h2>

    @if (count($billings) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Admission ID</th>
                        <th>Patient Name</th>
                        <th>Room</th>
                        <th>Admission Date</th>
                        <th>Discharge Date</th>
                        <th>Days Stayed</th>
                        <th>Room Price/Day</th>
                        <th class="total-bill-header">Total Bill</th> <!-- Add class for special styling -->
                        <th>Payment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($billings as $billing)
                    <tr>
                        <td>{{ $billing['admission']->id }}</td>
                        <td>{{ $billing['admission']->patient->full_name }}</td>
                        <td>{{ $billing['admission']->room->name }}</td>
                        <td>{{ $billing['admission']->admission_date }}</td>
                        <td>{{ $billing['admission']->discharge_date ?? 'N/A' }}</td>
                        <td>{{ $billing['daysStayed'] }}</td>
                        <td>Rp {{ number_format($billing['admission']->room->price, 0, ',', '.') }}</td>
                        <td class="total-bill-amount">Rp {{ number_format($billing['totalBill'], 0, ',', '.') }}</td> <!-- Add class for special styling -->
                        <td>
                            <span class="badge badge-{{ ($billing['paymentStatus'] == 'paid') ? 'success' : 'warning' }}">
                                {{ ($billing['paymentStatus'] == 'paid') ? 'Paid' : 'Pending' }}
                            </span>
                        </td>
                        <td>
                            @if ($billing['paymentStatus'] != 'paid') 
                                <a href="{{ route('billing.selectPaymentMethod', $billing['admission']->id) }}" class="btn btn-primary">Choose Payment Method</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="no-bills">No unpaid bills found.</p> 
    @endif
</div>
@endsection
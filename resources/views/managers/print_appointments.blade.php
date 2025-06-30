<!DOCTYPE html>
<html>
<head>
    <title>Print Appointments</title>
    <style>
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            margin: 30px;
            line-height: 1.6;
            color: #333;
        }
        
        /* Header Styling */
        h2 {
            text-align: center;
            color: #2c3e50;
            padding: 15px 0;
            margin: 0 0 25px;
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Filters Styling */
        .filters {
            margin: 0 auto 30px;
            max-width: 800px;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 0.95rem;
            color: #555;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Table Container */
        .table-responsive {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background: #34495e;
            color: white;
            font-weight: 600;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* Alternating row colors */
        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tbody tr:hover {
            background: #f1f3f5;
            transition: background 0.2s ease;
        }

        /* Responsive adjustments */
        @media print {
            .table-responsive {
                box-shadow: none;
            }
            
            h2 {
                background: none;
                color: #2c3e50;
                box-shadow: none;
            }
            
            .filters {
                box-shadow: none;
            }
            
            .table th {
                background: #eee;
                color: #333;
            }
        }

        @media (max-width: 768px) {
            body {
                margin: 15px;
            }
            
            .table th, .table td {
                padding: 10px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <h2>All Appointments</h2>
    <div class="filters">
        @if ($startDate && $endDate)
            Showing appointments from {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}
        @endif
        @if ($selectedDoctor)
            for doctor: {{ $selectedDoctor->full_name }} ({{ $selectedDoctor->specialization }})
        @endif
        @if ($searchQuery)
            for patient: {{ $patient ? $patient->full_name : $searchQuery }}
        @endif
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Specialization</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->patient->full_name ?? 'N/A' }}</td>
                    <td>{{ $appointment->doctor->full_name ?? 'N/A' }}</td>
                    <td>{{ $appointment->doctor->specialization ?? 'N/A' }}</td>
                    <td>{{ $appointment->date }}</td>
                    <td>{{ $appointment->notes ?? 'N/A' }}</td>
                    <td>{{ $appointment->payment_method ?? 'N/A' }}</td>
                    <td>{{ $appointment->amount ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
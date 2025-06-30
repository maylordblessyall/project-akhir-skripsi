<!DOCTYPE html>
<html>
<head>
    <title>Print Inpatient Medical Records</title>
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #10b981;
            --text-color: #2d3748;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --content-bg: #f5f7fa;
        }

        body {
            font-family: 'Inter', 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            line-height: 1.6;
            color: var(--text-color);
            background: var(--content-bg);
        }

        /* Container */
        .container {
            max-width: 100%;
            margin: 1.5rem auto;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0.5rem 0;
        }

        .header p {
            font-size: 1rem;
            color: #4a5568;
            margin: 0;
        }

        /* Headings */
        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0 0 1.5rem;
            text-align: center;
        }

        /* Filters */
        .filters {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            font-size: 0.95rem;
            text-align: center;
            color: #4a5568;
            line-height: 1.8;
        }

        .filters span {
            margin: 0 0.5rem;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse; /* Changed to collapse for better border handling */
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table th,
        .table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid var(--border-color); /* Added border for all cells */
            vertical-align: top;
            font-size: 0.9rem;
            white-space: normal; /* Ensure text wraps */
            word-wrap: break-word; /* Allow text to wrap */
        }

        /* Explicit column widths */
        .table th:nth-child(1), .table td:nth-child(1) { /* No. */
            width: 5%;
        }
        .table th:nth-child(2), .table td:nth-child(2) { /* Admission ID */
            width: 8%;
        }
        .table th:nth-child(3), .table td:nth-child(3) { /* Patient Name */
            width: 12%;
        }
        .table th:nth-child(4), .table td:nth-child(4) { /* Doctor Name */
            width: 12%;
        }
        .table th:nth-child(5), .table td:nth-child(5) { /* Date Recorded */
            width: 10%;
        }
        .table th:nth-child(6), .table td:nth-child(6) { /* Subjective */
            width: 13%;
        }
        .table th:nth-child(7), .table td:nth-child(7) { /* Objective */
            width: 13%;
        }
        .table th:nth-child(8), .table td:nth-child(8) { /* Assessment */
            width: 13%;
        }
        .table th:nth-child(9), .table td:nth-child(9) { /* Plan */
            width: 14%;
        }

        .table th {
            background: #f9fafb;
            font-weight: 600;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table td {
            color: var(--text-color);
        }

        .table tbody tr:hover {
            background: #f7fafc;
            transition: background 0.2s ease;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #718096;
            font-size: 1.1rem;
            background: #f9fafb;
            border-radius: 8px;
            margin-top: 1.5rem;
        }

        /* Footer for Page Numbering */
        .page-footer {
            text-align: center;
            font-size: 0.8rem;
            color: #718096;
            margin-top: 1rem;
            position: relative;
        }

        /* Print Styles */
        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 1rem;
                margin: 0;
                width: 100%;
            }

            .header {
                border-bottom: 2px solid #2d3748;
            }

            .header h1,
            .header p {
                color: #2d3748;
            }

            h2 {
                color: #2d3748;
                margin-bottom: 1rem;
            }

            .filters {
                box-shadow: none;
                background: none;
                padding: 1rem;
                border: 1px solid #e2e8f0;
            }

            .table-responsive {
                box-shadow: none;
            }

            .table {
                box-shadow: none;
                page-break-inside: avoid;
            }

            .table th,
            .table td {
                border: 1px solid #2d3748;
                color: #2d3748;
                font-size: 8pt; /* Smaller font for print to fit more content */
                padding: 0.5rem;
            }

            .table th {
                background: #e2e8f0;
                color: #2d3748;
            }

            .table tbody tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .empty-state {
                background: none;
                border: 1px solid #e2e8f0;
                padding: 1rem;
            }

            .page-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                border-top: 1px solid #e2e8f0;
                padding: 0.5rem 0;
            }

            .page-footer::before {
                content: "Page " counter(page) " of " counter(pages);
            }

            /* Force landscape orientation */
            @page {
                size: landscape;
                margin: 1cm;
            }
        }

        /* Responsive Design for Preview */
        @media (max-width: 768px) {
            .container {
                margin: 0.5rem;
                padding: 1rem;
            }

            .table th,
            .table td {
                font-size: 0.85rem;
                padding: 0.5rem;
            }

            .filters {
                padding: 1rem;
                font-size: 0.9rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .header p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h1>Hospital Name</h1>
            <p>Inpatient Medical Records Report</p>
            <p>Generated on {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>

        <!-- Title -->
        <h2>Inpatient Medical Records</h2>

        <!-- Filters -->
        <div class="filters">
            @if ($startDate || $endDate || $selectedDoctor || $searchQuery)
                <span>
                    @if ($startDate)
                        From {{ $startDate->format('Y-m-d') }}
                    @endif
                    @if ($endDate)
                        to {{ $endDate->format('Y-m-d') }}
                    @endif
                </span>
                @if ($selectedDoctor)
                    <span>Doctor: {{ $selectedDoctor->full_name }} ({{ $selectedDoctor->specialization }})</span>
                @endif
                @if ($searchQuery)
                    <span>Patient Search: {{ $searchQuery }}</span>
                @endif
            @else
                <span>All Records</span>
            @endif
        </div>

        <!-- Records Table -->
        @if ($inpatientMedicalRecords->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Admission ID</th>
                            <th>Patient Name</th>
                            <th>Doctor Name</th>
                            <th>Date Recorded</th>
                            <th>Subjective</th>
                            <th>Objective</th>
                            <th>Assessment</th>
                            <th>Plan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inpatientMedicalRecords as $index => $record)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $record->admission->id }}</td>
                                <td>{{ $record->admission->patient->full_name ?? 'N/A' }}</td>
                                <td>{{ $record->admission->doctor->full_name ?? 'N/A' }}</td>
                                <td>{{ $record->date_recorded }}</td>
                                <td>{{ $record->subjective ?? 'N/A' }}</td>
                                <td>{{ $record->objective ?? 'N/A' }}</td>
                                <td>{{ $record->assessment ?? 'N/A' }}</td>
                                <td>{{ $record->plan ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                No records found for the selected filters.
            </div>
        @endif

        <!-- Page Footer -->
        <div class="page-footer"></div>
    </div>
</body>
</html>
@extends('inpatient')

@section('title')
Inpatient Medical Records
@endsection

@section('content')
<style>
    /* Root variables to match other layouts */
    :root {
        --primary-color: #3b82f6;
        --secondary-color: #10b981;
        --text-color: #2d3748;
        --border-color: #e2e8f0;
        --card-bg: #ffffff;
        --content-bg: #f5f7fa;
    }

    /* Container */
    .container {
        max-width: 1280px;
        margin: 2rem auto;
        padding: 2rem;
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    /* Headings */
    h2 {
        color: var(--text-color);
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    /* Search Form */
    .search-form {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        align-items: flex-end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #a0aec0;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }

    .btn-action {
        background: transparent;
        color: var(--primary-color);
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    .btn-action:hover {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        transform: none;
    }

    .btn-print {
        background: var(--secondary-color);
        color: #fff;
        margin-left: 1rem;
    }

    .btn-print:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Table */
    .table-responsive {
        overflow-x: auto;
        margin-bottom: 1.5rem;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--card-bg);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .table th {
        background: #f9fafb;
        font-weight: 600;
        color: #4a5568;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table td {
        font-size: 0.95rem;
        color: var(--text-color);
    }

    .table tbody tr:hover {
        background: #f7fafc;
    }

    .table a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .table a:hover {
        color: #2563eb;
        text-decoration: underline;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        padding: 0.5rem 1rem;
        font-size: 0.95rem;
        color: var(--primary-color);
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-color);
        color: #fff;
        border-color: var(--primary-color);
    }

    .pagination .page-item.disabled .page-link {
        color: #a0aec0;
        background: #f7fafc;
        border-color: var(--border-color);
        cursor: not-allowed;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .row {
            grid-template-columns: 1fr;
        }

        .btn-primary, .btn-print {
            width: 100%;
            margin-left: 0;
            margin-top: 0.5rem;
        }

        .table th,
        .table td {
            font-size: 0.9rem;
            padding: 0.75rem;
        }
    }

    /* Animation */
    @-webkit-keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
</style>

<div class="container fade-in">
    <h2>Inpatient Medical Records</h2>

    <form action="{{ route('medical_records.indexInpatient') }}" method="GET" class="search-form">
        <div class="row">
            <div class="form-group">
                <label for="search" class="form-label">Patient Name or ID</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Enter name or ID" value="{{ request('search') }}">
            </div>
            <div class="form-group">
                <label for="doctor_id" class="form-label">Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control">
                    <option value="">All Doctors</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->full_name }} ({{ $doctor->specialization }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('medical_records.printInpatient', request()->query()) }}" class="btn btn-print">Print</a>
            </div>
        </div>
    </form>

    @if ($inpatientMedicalRecords->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        {{-- <th>ID Pasien</th> --}}
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Tanggal Masuk</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $startingIndex = ($inpatientMedicalRecords->currentPage() - 1) * $inpatientMedicalRecords->perPage() + 1;
                    @endphp
                    @foreach ($inpatientMedicalRecords as $index => $medicalRecord)
                        <tr>
                            <td>{{ $startingIndex + $index }}</td>
                            {{-- <td>{{ $medicalRecord->admission->id }}</td> --}}
                            <td>{{ $medicalRecord->admission->patient->full_name }}</td>
                            <td>{{ $medicalRecord->admission->doctor->full_name ?? 'N/A' }}</td>
                            <td>{{ $medicalRecord->admission->admission_date }}</td>
                            <td>
                                <a href="{{ route('medical_records.showDetailsInpatient', $medicalRecord->admission) }}" class="btn btn-action">View All</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination">
            {{ $inpatientMedicalRecords->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="empty-state">
            No records found for the selected filters.
        </div>
    @endif
</div>
@endsection
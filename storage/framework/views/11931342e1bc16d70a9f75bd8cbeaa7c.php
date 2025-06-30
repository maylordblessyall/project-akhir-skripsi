

<?php $__env->startSection('title'); ?>
Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* General Styling */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: #f5f7fa;
        color: #2d3748;
        line-height: 1.6;
        margin: 0;
    }

    .container {
        max-width: 1280px;
        margin: 2rem auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    /* Headings */
    h2 {
        color: #1a202c;
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3b82f6;
    }

    /* Filter Form */
    .filter-form {
        background: #f9fafb;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin: 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        font-size: 0.9rem;
        font-weight: 500;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }

    .form-control {
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .filter-button {
        display: flex;
        justify-content: flex-end;
        margin-top: 1rem;
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
    }

    .btn-primary {
        background-color: #3b82f6;
        border: none;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
    }

    .btn-print {
        background-color: #10b981;
        color: #fff;
    }

    .btn-print:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    /* Cards */
    .totals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
        color: #fff;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
    }

    .card-body {
        padding: 1.5rem;
        text-align: center;
    }

    .card-body h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
        border: none;
    }

    /* Tables */
    .table-responsive {
        overflow-x: auto;
        margin-bottom: 1.5rem;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #edf2f7;
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
        color: #2d3748;
    }

    .table tbody tr:hover {
        background: #f7fafc;
    }

    .table .btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
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
        color: #3b82f6;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }

    .pagination .page-item.active .page-link {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }

    .pagination .page-item.disabled .page-link {
        color: #a0aec0;
        background: #f7fafc;
        border-color: #e2e8f0;
        cursor: not-allowed;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #718096;
        font-size: 1.1rem;
        background: #f9fafb;
        border-radius: 8px;
    }

    .text-danger {
        color: #e53e3e;
        font-weight: 500;
        text-align: center;
        margin: 1rem 0;
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

        .totals-grid {
            grid-template-columns: 1fr;
        }

        .table th,
        .table td {
            font-size: 0.9rem;
            padding: 0.75rem;
        }

        .pagination {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container">
    <h2>Medical Records Dashboard</h2>

    <!-- Filter Form -->
    <form method="GET" action="<?php echo e(route('manager.dashboard')); ?>" class="filter-form">
        <div class="row">
            <div class="form-group">
                <label for="search">Search by Patient ID or Name</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Enter name or ID" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="form-group">
                <label for="doctor_id">Search by Doctor</label>
                <select name="doctor_id" id="doctor_id" class="form-control">
                    <option value="">All Doctors</option>
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($doctor->id); ?>" <?php echo e($doctorId == $doctor->id ? 'selected' : ''); ?>>
                            <?php echo e($doctor->full_name); ?> (<?php echo e($doctor->specialization); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo e(old('start_date', $startDate ? $startDate->format('Y-m-d') : '')); ?>">
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo e(old('end_date', $endDate ? $endDate->format('Y-m-d') : '')); ?>">
            </div>
        </div>
        <div class="filter-button">
            <button type="submit" class="btn btn-primary">Apply Filters</button>
        </div>
    </form>

    <!-- Totals Cards -->
    <div class="totals-grid">
        <div class="card">
            <div class="card-header">Today</div>
            <div class="card-body">
                <h2><?php echo e($totals['totalToday']); ?></h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">This Month</div>
            <div class="card-body">
                <h2><?php echo e($totals['totalThisMonth']); ?></h2>
            </div>
        </div>
        <div class="card">
            <div class="card-header">This Year</div>
            <div class="card-body">
                <h2><?php echo e($totals['totalThisYear']); ?></h2>
            </div>
        </div>
    </div>

    <!-- All Appointments -->
    <?php if($appointments->count() > 0): ?>
        <h2>Appointments</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($appointment->id); ?></td>
                            <td><?php echo e($appointment->patient->full_name ?? 'N/A'); ?></td>
                            <td><?php echo e($appointment->doctor->full_name ?? 'N/A'); ?></td>
                            <td><?php echo e($appointment->doctor->specialization ?? 'N/A'); ?></td>
                            <td><?php echo e($appointment->date); ?></td>
                            <td><?php echo e($appointment->notes ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <a href="<?php echo e(route('manager.print_appointments', request()->query())); ?>" class="btn btn-print" target="_blank">Print Appointments</a>
        <div class="pagination">
            <?php echo e($appointments->appends(request()->except('appointments_page', 'medical_records_page'))->links('pagination::bootstrap-4')); ?>

        </div>
    <?php else: ?>
        <div class="empty-state">
            No appointments found for the selected filters.
        </div>
    <?php endif; ?>

    <!-- All Medical Records -->
    <?php if($medicalRecords->count() > 0): ?>
        <h2>Medical Records</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Date Recorded</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($record->id); ?></td>
                            <td><?php echo e($record->appointment->id ?? 'N/A'); ?></td>
                            <td><?php echo e($record->patient->full_name ?? 'N/A'); ?></td>
                            <td><?php echo e($record->doctor->full_name ?? 'N/A'); ?></td>
                            <td><?php echo e($record->doctor->specialization ?? 'N/A'); ?></td>
                            <td><?php echo e($record->date_recorded); ?></td>
                            <td>
                                <a href="<?php echo e(route('patients.showDetails', $record->id_patient)); ?>" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <a href="<?php echo e(route('manager.print_medical_records', request()->query())); ?>" class="btn btn-print" target="_blank">Print Medical Records</a>
        <div class="pagination">
            <?php echo e($medicalRecords->appends(request()->except('appointments_page', 'medical_records_page'))->links('pagination::bootstrap-4')); ?>

        </div>
    <?php else: ?>
        <div class="empty-state">
            No medical records found for the selected filters.
        </div>
    <?php endif; ?>

    <?php if($searchQuery && !$patient): ?>
        <p class="text-danger">No patient found with that name or ID.</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/managers/index.blade.php ENDPATH**/ ?>
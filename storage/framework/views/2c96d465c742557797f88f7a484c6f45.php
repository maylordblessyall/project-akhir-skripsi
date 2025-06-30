

<?php $__env->startSection('title'); ?>
Medical Record
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
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

    .form-group {
        margin-bottom: 1rem;
    }

    .form-control, .btn {
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .form-control {
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    label {
        font-weight: 600;
        display: block;
        margin-bottom: 0.25rem;
    }

    /* Table Styling */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-top: 2rem;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
        text-align: center;
    }

    .table th {
        background-color: #007bff;
        color: white;
        font-weight: 500;
        border-top: none;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table td a.btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 4px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    /* Pagination Styling */
    .custom-pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-item {
        margin: 0 0.1rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-item .page-link {
        border: 1px solid #ddd;
        color: #007bff;
        padding: 0.5rem 0.75rem;
    }

    .pagination .page-link:hover {
        background-color: #e9ecef;
    }

    .no-records {
        text-align: center;
        margin-top: 2rem;
        font-style: italic;
        color: #6c757d;
    }
</style>

<div class="container">
    <h2>Medical Records</h2>

    <form action="<?php echo e(route('medical_records.index')); ?>" method="GET" class="form-inline justify-content-center mb-4">
        <div class="form-group mr-2 mb-2">
            <input type="text" class="form-control" id="search" name="search" placeholder="Search by ID or Patient Name" value="<?php echo e($filters['search'] ?? ''); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if($records->isNotEmpty()): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Patient</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Appointment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(($records->currentPage() - 1) * $records->perPage() + $loop->iteration); ?></td>
                            <td><?php echo e($record->id_patient); ?></td>
                            <td><?php echo e($record->patient->full_name); ?></td>
                            <td><?php echo e($record->doctor->full_name); ?></td>
                            <td><?php echo e($record->date_recorded); ?></td>
                            <td>
                                <div class="btn-group-vertical" role="group" aria-label="Patient Actions">
                                    <a href="<?php echo e(route('patients.showDetails', $record->id_patient)); ?>" class="btn btn-primary btn-block">
                                        <i class="fa fa-eye" aria-hidden="true"></i> View Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="no-records">No records found matching your search.</p>
    <?php endif; ?>

    <?php if($records->hasPages()): ?>
        <div class="custom-pagination">
            <?php echo e($records->appends(Request::except('page'))->links('pagination::bootstrap-4')); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/medical_records/index.blade.php ENDPATH**/ ?>
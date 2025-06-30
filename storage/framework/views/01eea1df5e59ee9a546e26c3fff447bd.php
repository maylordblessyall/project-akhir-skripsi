

<?php $__env->startSection('title'); ?>
Appointment Dashboard
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
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 5px rgba(52, 152, 219, .5);
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 15px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #e0e0e0;
    }

    .table th {
        background-color: #3498db;
        color: white;
        font-weight: 600;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

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
            <?php if($access_level === 'admin'): ?>
                <h3>
                    <a href="<?php echo e(route('appointments.create')); ?>" class="btn btn-primary">Buat Kunjungan</a>
                </h3>
            <?php else: ?>
                <h3>Appointment Dashboard</h3>
            <?php endif; ?>
        </div>
        <form action="<?php echo e(route('appointments.index')); ?>" method="GET" class="d-flex align-items-end">
            <div class="form-group me-2">
                <label for="date_from" class="form-label">From:</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo e($filters['date_from']); ?>">
            </div>
            <div class="form-group me-2">
                <label for="date_to" class="form-label">To:</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo e($filters['date_to']); ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <?php if($appointments->isNotEmpty()): ?>
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
                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(($appointments->currentPage() - 1) * $appointments->perPage() + $loop->iteration); ?></td>
                        <td><?php echo e($appointment->date); ?></td>
                        <td><?php echo e($appointment->start_time); ?></td>
                        <td><?php echo e($appointment->end_time); ?></td>
                        <td><?php echo e($appointment->patient->full_name ?? 'N/A'); ?></td>
                        <td><?php echo e($appointment->doctor->full_name ?? 'N/A'); ?></td>
                        <td><?php echo e(Str::limit($appointment->notes, 50)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <div class="custom-pagination">
                <?php echo e($appointments->appends(request()->except('page'))->links('pagination::bootstrap-4')); ?>

            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No appointments found. 
                <?php if($access_level === 'admin'): ?>
                    Click <a href="<?php echo e(route('appointments.create')); ?>">here</a> to create one.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/appointments/index.blade.php ENDPATH**/ ?>
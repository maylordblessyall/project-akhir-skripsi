

<?php $__env->startSection('title', 'Inpatient Medical Records'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .medical-records {
        background: linear-gradient(135deg, #ffffff, #f5f7fa);
        border-radius: 12px;
        padding: 30px;
        margin: 20px auto;
        max-width: 1400px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        font-family: 'Inter', sans-serif;
    }

    h2 {
        color: #1a3c6d;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 12px;
    }

    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: #007bff;
        border-radius: 2px;
    }

    .input-group {
        margin-bottom: 25px;
        max-width: 500px;
    }

    .form-control {
        border: 1px solid #e0e4e8;
        border-radius: 8px;
        padding: 12px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        outline: none;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-1px);
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #b02a37;
        transform: translateY(-1px);
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        transform: translateY(-1px);
    }

    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table {
        margin-bottom: 0;
        width: 100%;
    }

    .table thead {
        background: #007bff;
        color: #fff;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .table thead th {
        padding: 16px;
        border: none;
        font-weight: 600;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f6ff;
    }

    .table tbody td {
        padding: 14px;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
        color: #34495e;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #fafafa;
    }

    .pagination {
        margin-top: 30px;
        justify-content: center;
    }

    .page-link {
        border: none;
        color: #007bff;
        margin: 0 5px;
        border-radius: 6px;
        padding: 8px 14px;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background-color: #007bff;
        color: #fff;
    }

    .page-item.active .page-link {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: none;
    }

    @media (max-width: 768px) {
        .medical-records {
            padding: 20px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .input-group {
            max-width: 100%;
        }

        .btn {
            padding: 8px 16px;
        }

        .table thead th,
        .table tbody td {
            padding: 12px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="medical-records">
    <h2>Medical Records</h2>

    
    <form action="<?php echo e(route('inpatient.patients.index')); ?>" method="GET">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by name or NIK" value="<?php echo e(request('search')); ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('inpatient.patients.create')); ?>" class="btn btn-primary mb-4">Add New Patient</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(($patients->currentPage() - 1) * $patients->perPage() + $loop->iteration); ?></td>
                    <td><?php echo e($patient->id); ?></td>
                    <td><?php echo e($patient->nik); ?></td>
                    <td><?php echo e($patient->full_name); ?></td>
                    <td><?php echo e($patient->date_of_birth->format('d M Y')); ?></td>
                    <td><?php echo e($patient->email ?: 'N/A'); ?></td>
                    <td><?php echo e($patient->created_at->format('d M Y')); ?></td>
                    <td>
                        <a href="<?php echo e(route('inpatient.patients.edit', $patient->id)); ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                        <form action="<?php echo e(route('patients.destroy', $patient->id)); ?>" method="POST" style="display: inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center py-4">No patients found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($patients->hasPages()): ?>
        <div class="pagination">
            <?php echo e($patients->appends(request()->except('page'))->links('pagination::bootstrap-5')); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/inpatient/index.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title'); ?>
    Staff List
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .container {
        max-width: 960px;
        margin: 0 auto; /* Center the container */
    }

    h1, h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem; 
        color: #212529;
        border-collapse: separate;
        border-spacing: 0 10px; 
    }

    .table th,
    .table td {
        padding: 15px;
        vertical-align: middle;
        text-align: center; /* Center text within cells */
        border-top: 1px solid #ddd;
    }

    .table th {
        background-color: #007bff; /* Blue background for headers */
        color: white;
        font-weight: 500; 
        border-top: 2px solid #007bff; /* Thicker top border for header */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; /* Light gray for odd rows */
    }

    .table .btn {
        margin: 2px;
        padding: 5px 10px; 
        font-size: 0.8rem; 
    }

    .table .btn-info {
        background-color: #00cc00; 
        border-color: #292b2c;
    }

    .table .btn-danger {
        background-color: #d9534f;
    }
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-item .page-link {
        border: 1px solid #ddd;
        color: #007bff;
    }
</style>
    <h1>Staff</h1>

    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <a href="<?php echo e(route('registrationstaff.create')); ?>" class="btn btn-success">Add New Staff</a>
    <br><br>

    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $registrationstaff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>  
                <tr>
                    <td><?php echo e($staff->id); ?></td>
                    <td><?php echo e($staff->full_name); ?></td>
                    <td><?php echo e($staff->email); ?></td>
                    <td><?php echo e($staff->phone_number); ?></td>
                    <td>
                        <a href="<?php echo e(route('registrationstaff.edit', $staff->id)); ?>" class="btn btn-sm btn-info">Edit</a>

                        <form action="<?php echo e(route('registrationstaff.destroy', $staff->id)); ?>" method="POST" style="display: inline-block">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this staff?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No staff found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/user/registrationstaff/index.blade.php ENDPATH**/ ?>
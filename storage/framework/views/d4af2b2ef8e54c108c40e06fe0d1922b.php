

<?php $__env->startSection('title'); ?>
Patients List
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
    }

    .container {
        max-width: 1200px;
        padding: 20px;
        background: #ffffff; /* White background for the main content */
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

    /* Form Styling */
    .form-group {
        margin-bottom: 20px;
    }

    .input-group {
        border-radius: 5px;
        overflow: hidden;
    }

    .input-group input[type="text"] {
        border: 1px solid #ced4da;
        border-right: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        padding: 10px 15px;
        height: auto;
        transition: border-color 0.15s ease-in-out;
    }

    .input-group input[type="text"]:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    /* Table Styling */
    .table-responsive {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        border-collapse: collapse;
    }

    .table th {
        background-color: #007bff;
        color: white;
        font-weight: 500;
        border: none;
    }

    .table td, .table th {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa;
    }

    .table th, .table td {
        text-align: center;
    }

    /* Action Button Styling */
    .table .btn {
        margin: 2px;
        padding: 6px 12px;
        font-size: 0.875rem;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .table .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
    }

    /* Pagination Styling */
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .pagination .page-item .page-link {
        color: #007bff;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .pagination .page-item .page-link:hover {
        background-color: #007bff;
        color: white;
    }

    /* Alert Styling */
    .alert {
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
</style>

<div class="container">
    <h2>Pasien</h2>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <h3>
        <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-success mb-3">Tambah Pasien Baru</a>
    </h3>

    <form action="<?php echo e(route('patients.index')); ?>" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search by name, NIK, or email" value="<?php echo e($filters['search'] ?? ''); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <?php if($patients->isNotEmpty()): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Email</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($patient->id); ?></td>
                            <td><?php echo e($patient->nik); ?></td>
                            <td><?php echo e($patient->full_name); ?></td>
                            <td><?php echo e($patient->date_of_birth); ?></td>
                            <td><?php echo e($patient->email); ?></td>
                            <td><?php echo e($patient->created_at->format('Y-m-d')); ?></td>
                            <td>
                                <a href="<?php echo e(route('patients.edit', $patient->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                <form action="<?php echo e(route('patients.destroy', $patient->id)); ?>" method="POST" style="display: inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this patient?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center">No patients found.</p>
    <?php endif; ?>
    
    <?php if($patients->hasPages()): ?>
        <div class="pagination">
            <?php echo e($patients->appends(Request::except('page'))->links('pagination::bootstrap-4')); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/patients/index.blade.php ENDPATH**/ ?>
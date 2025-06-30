

<?php $__env->startSection('title'); ?>
Admission Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .admission-dashboard {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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

    .input-group {
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 0;
        border-right: none;
    }

    .input-group .btn {
        border-radius: 0 4px 4px 0;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #218838;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

    .room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, 160px);
        gap: 15px;
        margin-top: 20px;
        justify-content: start;
    }

    .room-box {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        width: 160px;
        height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-sizing: border-box;
    }

    .room-box:hover {
        transform: translateY(-3px);
    }

    .room-box.occupied {
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .room-box.vacant {
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .room-box h5 {
        margin: 0;
        font-size: 1.1rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .room-box p {
        margin: 5px 0;
        font-size: 0.9rem;
        color: #555;
        flex-grow: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .room-box .actions {
        display: flex;
        flex-direction: column; /* Stack buttons vertically */
        gap: 5px; /* Space between buttons */
        margin-top: 5px; /* Small margin to separate from patient name */
    }

    .room-box .btn-sm {
        font-size: 0.65rem; /* Smaller font size for compact buttons */
        padding: 3px 6px; /* Reduced padding */
        line-height: 1.2; /* Tighter line height */
        width: 100%; /* Full width to align buttons */
        text-align: center; /* Center text */
        border-radius: 4px; /* Consistent border radius */
    }

    .room-box .actions form {
        display: block; /* Ensure form takes full width */
        width: 100%; /* Match button width */
    }

    .room-box .actions form button {
        width: 100%; /* Full width for delete button */
    }
</style>

<div class="admission-dashboard">
    <h2>Pasien Rawat Inap</h2>
    

    <a href="<?php echo e(route('admissions.create')); ?>" class="btn btn-primary mb-3">Daftar Pasien Baru</a>

    <div class="room-grid">
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Find the active admission for this room (if any)
                $admission = $room->admissions()->whereNull('discharge_date')->first();
            ?>
            <div class="room-box <?php echo e($admission ? 'occupied' : 'vacant'); ?>">
                <h5><?php echo e($room->name); ?></h5>
                <p>
                    <?php if($admission): ?>
                        <?php echo e($admission->patient->full_name); ?>

                    <?php else: ?>
                        Vacant
                    <?php endif; ?>
                </p>
                <?php if($admission): ?>
                    <div class="actions">
                        <a href="<?php echo e(route('medical_records.createForInpatient', ['admission' => $admission->id])); ?>" class="btn btn-success btn-sm">Add Medical Record</a>
                        <a href="<?php echo e(route('admissions.edit', $admission->id)); ?>" class="btn btn-primary btn-sm">Update</a>
                        <form action="<?php echo e(route('admissions.destroy', $admission->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this admission?')">Delete</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/admissions/index.blade.php ENDPATH**/ ?>
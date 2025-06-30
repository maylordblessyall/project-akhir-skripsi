

<?php $__env->startSection('title'); ?>
    Create Medical Record for Inpatient
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<style>
    .form-label {
        font-weight: bold;
        margin-bottom: 0.25rem;
    }

    .card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 0;
    }

    textarea.form-control {
        height: auto;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: all 0.3s ease; /* Changed from background-color to all */
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        transform: scale(1.02); /* Adds a slight scale effect on hover for buttons */
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        font-weight: 500;
        border-radius: 0.25rem; /* Rounded corners for alerts */
    }

    .alert-danger ul {
        margin-bottom: 0;
        padding-left: 20px;
    }

    .container {
        margin-top: 20px;
        max-width: 1140px; /* Limit the container width for better readability on larger screens */
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .col-md-4, .col-md-8 {
            width: 100%;
        }
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="mb-4">Create Medical Record for <?php echo e($admission->patient->full_name); ?> (<?php echo e($admission->patient->id); ?>)</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('medical_records.storeForInpatient', $admission)); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="row g-3">
            
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header">Patient Information</div>
                    <div class="card-body">
                        <p><strong>ID:</strong> <?php echo e($admission->patient->id); ?></p>
                        <p><strong>Name:</strong> <?php echo e($admission->patient->full_name); ?></p>
                        <p><strong>ID Docter:</strong> <?php echo e($admission->doctor_id); ?></p>
                        <p><strong>Nama Docter:</strong> <?php echo e($admission->doctor->full_name); ?></p>
                        <p><strong>NIK:</strong> <?php echo e($admission->patient->nik); ?></p>
                        <p><strong>Blood Type:</strong> <?php echo e($admission->patient->golongan_darah); ?></p>
                        <p><strong>Allergies:</strong> <?php echo e($admission->patient->alergi); ?></p>
                        <p><strong>Medical History:</strong> <?php echo e($admission->patient->riwayat_medis); ?></p>
                        <p><strong>Current Medications:</strong> <?php echo e($admission->patient->obat_yang_dikonsumsi); ?></p>
                        <p><strong>Admission Date:</strong> <?php echo e($admission->admission_date); ?></p>
                        <p><strong>Room Number:</strong> <?php echo e(optional($admission->room)->name); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="col-md-8">
                <input type="hidden" name="patient_id" value="<?php echo e($admission->patient_id); ?>">

                <div class="mb-3">
                    <label for="date_recorded" class="form-label">Date Recorded:</label>
                    <input type="date" name="date_recorded" id="date_recorded" class="form-control" value="<?php echo e(old('date_recorded', now()->format('Y-m-d'))); ?>" required>
                </div>

                <?php $__currentLoopData = ['subjective', 'objective', 'assessment', 'plan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-3">
                        <label for="<?php echo e($field); ?>" class="form-label"><?php echo e(ucfirst($field)); ?>:</label>
                        <textarea name="<?php echo e($field); ?>" id="<?php echo e($field); ?>" rows="3" class="form-control"><?php echo e(old($field)); ?></textarea>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Create Medical Record</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/medical_records/create_for_inpatient.blade.php ENDPATH**/ ?>
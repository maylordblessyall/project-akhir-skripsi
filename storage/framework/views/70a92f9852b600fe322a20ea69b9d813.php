

<?php $__env->startSection('title', 'Create Medical Record for Patient'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-transform: uppercase;
        font-weight: 600;
        position: relative;
    }

    .card-header::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin-bottom: 15px;
    }

    .card-body strong {
        display: inline-block;
        width: 180px;
        font-weight: 600;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        height: auto;
    }

    .alert {
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s;
        padding: 10px 20px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .invalid-feedback {
        display: block;
    }

    textarea.form-control {
        min-height: 100px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="text-center mb-4">Create Medical Record for <?php echo e($appointment->patient->full_name); ?></h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">Appointment Information</div>
        <div class="card-body">
            <p><strong>Appointment ID:</strong> <?php echo e($appointment->id); ?></p>
            <p><strong>Patient ID:</strong> <?php echo e($appointment->patient->id); ?></p>
            <p><strong>Patient Name:</strong> <?php echo e($appointment->patient->full_name); ?></p>
            <p><strong>Doctor Name:</strong> <?php echo e($appointment->doctor->full_name); ?></p>
            <p><strong>Appointment Date:</strong> <?php echo e($appointment->date); ?></p>
        </div>
    </div>

    <form action="<?php echo e(route('medical-records.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card">
            <div class="card-header">SOAP Notes</div>
            <div class="card-body">
                <input type="hidden" name="id_appointment" value="<?php echo e($appointment->id); ?>"> 
                <input type="hidden" name="id_patient" value="<?php echo e($appointment->patient->id); ?>"> 
                <input type="hidden" name="id_doctor" value="<?php echo e($appointment->doctor->id); ?>"> 
                <input type="hidden" name="full_name" value="<?php echo e($appointment->patient->full_name); ?>"> 
                <input type="hidden" name="date_recorded" value="<?php echo e($appointment->date); ?>"> 

                <?php $__currentLoopData = ['subjective', 'objective', 'assessment', 'plan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="form-group">
                        <label for="<?php echo e($field); ?>"><?php echo e(ucfirst($field)); ?>:</label>
                        <textarea class="form-control <?php $__errorArgs = [$field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>" rows="3" required><?php echo e(old($field)); ?></textarea>
                        <?php $__errorArgs = [$field];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Save SOAP</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/medical_records/create.blade.php ENDPATH**/ ?>
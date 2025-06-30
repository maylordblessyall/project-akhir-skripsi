

<?php $__env->startSection('title', 'Create New Patient'); ?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .inpatient-form {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .inpatient-form h2 {
        text-align: center;
        color: #333;
        font-size: 2rem;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #333;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: #fff;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 1.1em;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-danger ul {
        margin-bottom: 0;
        list-style: none;
        padding-left: 0;
    }
</style>
<?php $__env->startSection('content'); ?>
    <div class="inpatient-form">
        <h2>Create New Inpatient</h2>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('inpatient.patients.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="nik">NIK:</label>
                <input type="text" name="nik" id="nik" class="form-control" value="<?php echo e(old('nik')); ?>" required>
            </div>

            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo e(old('full_name')); ?>" required>
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?php echo e(old('date_of_birth')); ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" class="form-control" rows="3" required><?php echo e(old('address')); ?></textarea>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo e(old('phone_number')); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>">
            </div>
            
            <div class="form-group">
                <label for="golongan_darah">Golongan Darah (Blood Type):</label>
                <select name="golongan_darah" id="golongan_darah" class="form-control">
                    <option value="">Select</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>

            <div class="form-group">
                <label for="alergi">Alergi (Allergies):</label>
                <textarea name="alergi" id="alergi" rows="3" class="form-control"><?php echo e(old('alergi')); ?></textarea>
            </div>

            <div class="form-group">
                <label for="riwayat_medis">Riwayat Medis (Medical History):</label>
                <textarea name="riwayat_medis" id="riwayat_medis" rows="3" class="form-control"><?php echo e(old('riwayat_medis')); ?></textarea>
            </div>

            <div class="form-group">
                <label for="obat_yang_dikonsumsi">Obat yang Dikonsumsi (Current Medications):</label>
                <textarea name="obat_yang_dikonsumsi" id="obat_yang_dikonsumsi" rows="3" class="form-control"><?php echo e(old('obat_yang_dikonsumsi')); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Create Patient</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/inpatient/create.blade.php ENDPATH**/ ?>
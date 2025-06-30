

<?php $__env->startSection('title'); ?>
Edit Admission for <?php echo e($admission->patient->full_name); ?> (ID: <?php echo e($admission->patient->id); ?>)
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .admission-title {
    color: #333;
    font-size: 24px;
    font-weight: bold;
}

.admission-form {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.submit-btn {
    text-align: center;
    margin-top: 20px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    min-width: 150px;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    padding: 10px;
    border-radius: 4px;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="admission-title text-center mb-4">Edit Admission for <?php echo e($admission->patient->full_name); ?> (ID: <?php echo e($admission->patient->id); ?>)</h2>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="admission-form">
        <form action="<?php echo e(route('admissions.update', $admission)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label for="patient_id">Patient:</label>
                <input type="text" class="form-control" value="<?php echo e($admission->patient->full_name); ?> (ID: <?php echo e($admission->patient->id); ?>)" readonly>
            </div>
            
            <div class="form-group">
                <label for="doctor_id">Doctor:</label>
                <input type="text" class="form-control" value="<?php echo e($admission->doctor->full_name); ?> (ID: <?php echo e($admission->doctor_id); ?>)" readonly>
            </div>

            <div class="form-group">
                <label for="admission_date">Admission Date:</label>
                <input type="date" name="admission_date" id="admission_date" class="form-control" value="<?php echo e(old('admission_date', $admission->admission_date)); ?>" required>
            </div>

            <div class="form-group">
                <label for="discharge_date">Discharge Date (Optional):</label>
                <input type="date" name="discharge_date" id="discharge_date" class="form-control" value="<?php echo e(old('discharge_date', optional($admission->discharge_date)->format('Y-m-d'))); ?>">
            </div>

            <div class="form-group">
                <label for="room_id">Room Number:</label>
                <select name="room_id" id="room_id" class="form-control" required>
                    <option value="">Select Room</option>
                    <?php $__currentLoopData = $roomOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roomId => $roomName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($roomId); ?>" <?php echo e(old('room_id', $admission->room_id) == $roomId ? 'selected' : ($admissionModel::isRoomOccupied($roomId) ? 'disabled' : '')); ?>>
                        <?php echo e($roomName); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="reason">Reason for Admission:</label>
                <textarea name="reason" id="reason" rows="5" class="form-control"><?php echo e(old('reason', $admission->reason)); ?></textarea>
            </div>

            <div class="form-group submit-btn">
                <button type="submit" class="btn btn-primary">Update Admission</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const admissionDateInput = document.getElementById('admission_date');
    const roomSelect = document.getElementById('room_id');

    admissionDateInput.addEventListener('change', function () {
        const selectedDate = this.value;

        fetch(`<?php echo e(route('admissions.availableRooms')); ?>?admission_date=${selectedDate}`)
            .then(response => response.json())
            .then(rooms => {
                roomSelect.innerHTML = '<option value="">Select Room</option>';
                rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.text = room.name + (room.occupied ? ' (Occupied)' : '');
                    option.disabled = room.occupied;
                    roomSelect.append(option);
                });
            });
    });
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/admissions/edit.blade.php ENDPATH**/ ?>
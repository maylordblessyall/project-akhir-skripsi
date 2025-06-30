

<?php $__env->startSection('title', 'Admit New Patient'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* General Styles */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    .admission-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    h2 {
        color: #1a3c6d;
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 30px;
        position: relative;
        text-align: left;
        padding-bottom: 12px;
    }

    h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: #007bff;
        border-radius: 2px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        color: #34495e;
    }

    .form-control, select.form-control, textarea.form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e0e4e8;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #34495e;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus, select.form-control:focus, textarea.form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        outline: none;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2334495e' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 30px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Button Styles */
    .btn-primary {
        background: #007bff;
        border: none;
        color: #fff;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }

    /* Alert Styles */
    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .admission-container {
            margin: 20px;
            padding: 20px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .form-control, select.form-control, textarea.form-control {
            font-size: 0.9rem;
            padding: 10px 12px;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="admission-container">
    <h2>Admit New Patient</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admissions.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <select name="patient_id" id="patient_id" class="form-control" required>
                <option value="">Select a Patient</option>
                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($patient->id); ?>" <?php echo e(old('patient_id') == $patient->id ? 'selected' : ''); ?>>
                        <?php echo e($patient->full_name); ?> (ID: <?php echo e($patient->id); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group">
            <label for="admission_date">Admission Date</label>
            <input type="date" name="admission_date" id="admission_date" class="form-control" value="<?php echo e(old('admission_date', today()->toDateString())); ?>" required>
        </div>

        <div class="form-group">
            <label for="room_id">Room</label>
            <select name="room_id" id="room_id" class="form-control" required>
                <option value="">Select a Room</option>
                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($room->id); ?>" <?php echo e($admissionModel->isRoomOccupied($room->id) ? 'disabled' : ''); ?> <?php echo e(old('room_id') == $room->id ? 'selected' : ''); ?>>
                        <?php echo e($room->name); ?> <?php echo e($admissionModel->isRoomOccupied($room->id) ? '(Occupied)' : ''); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group">
            <label for="doctor_id">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-control" required>
                <option value="">Select a Doctor</option>
                <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('doctor_id') == $doctor->id ? 'selected' : ''); ?>>
                        <?php echo e($doctor->full_name); ?> (ID: <?php echo e($doctor->id); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="form-group">
            <label for="reason">Reason for Admission (Optional)</label>
            <textarea name="reason" id="reason" rows="4" class="form-control"><?php echo e(old('reason')); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Admit Patient
        </button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const admissionDateInput = document.getElementById('admission_date');
        const roomSelect = document.getElementById('room_id');
        const form = document.querySelector('form');

        admissionDateInput.addEventListener('change', function () {
            const selectedDate = this.value;
            if (!selectedDate) return;

            // Add loading state
            roomSelect.classList.add('loading');
            roomSelect.disabled = true;

            // Fetch available rooms
            fetch(`<?php echo e(route('admissions.getAvailableRooms')); ?>?admission_date=${selectedDate}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                // Clear existing options except default
                while (roomSelect.options.length > 1) {
                    roomSelect.remove(1);
                }

                // Populate new options
                data.forEach(room => {
                    const option = new Option(
                        room.name + (room.occupied ? ' (Occupied)' : ''),
                        room.id,
                        false,
                        false
                    );
                    option.disabled = room.occupied;
                    roomSelect.add(option);
                });
            })
            .catch(error => {
                console.error('Error fetching rooms:', error);
                alert('Failed to load available rooms. Please try again.');
            })
            .finally(() => {
                // Remove loading state
                roomSelect.classList.remove('loading');
                roomSelect.disabled = false;
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/admissions/create.blade.php ENDPATH**/ ?>
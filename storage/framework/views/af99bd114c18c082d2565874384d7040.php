

<?php $__env->startSection('title'); ?>
    Create New Appointment
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<style>
    /* Global Styles */
    .container {
        max-width: 960px; /* Limit container width */
        margin: 0 auto; /* Center the container */
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

    /* Form Styles */
    .form-group {
        margin-bottom: 15px;
    }

    .form-control,
    .form-select,
    .btn {
        border-radius: 5px; /* Slightly rounded corners */
    }

    label {
        font-weight: bold;
        display: block; /* Place label above input */
        margin-bottom: 5px;
    }

    /* Payment Details Section */
    #payment-details {
        margin-top: 30px;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
    }

    #payment-details p {
        margin-bottom: 10px;
    }
</style>

<div class="container mt-4">
    <h2>New Appointment</h2>

    <form id="appointment-form" action="<?php echo e(route('appointments.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Appointment Time Slot:</label>
                    <div>
                        <input type="radio" name="time_slot" id="time_slot_morning" value="morning" checked>
                        <label for="time_slot_morning">Morning (9:00 AM - 12:00 PM)</label>
                    </div>
                    <div>
                        <input type="radio" name="time_slot" id="time_slot_afternoon" value="afternoon">
                        <label for="time_slot_afternoon">Afternoon (1:00 PM - 4:00 PM)</label>
                    </div>
                </div>
            </div>
        </div>
        <input type="time" name="start_time" id="start_time" hidden required>
        <input type="time" name="end_time" id="end_time" hidden required>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_patient">Patient:</label>
                    <select name="id_patient" id="id_patient" class="form-select" required>
                        <option value="">Select Patient</option>
                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($patient->id); ?>"><?php echo e($patient->full_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="id_doctor">Doctor:</label>
                    <select name="id_doctor" id="id_doctor" class="form-select" required>
                        <option value="">Select Doctor</option>
                        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($doctor->id); ?>" data-amount="<?php echo e($doctor->amount); ?>"><?php echo e($doctor->full_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Notes:</label>
            <textarea name="notes" id="notes" rows="5" class="form-control"></textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">Select Payment Method</option>
                        <option value="qris">QRIS</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" name="amount" id="amount" step="0.01" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary" onclick="confirmPayment()">Confirm Payment</button>
        <button type="submit" class="btn btn-primary" id="submit-button" style="display:none;">Create Appointment</button>
    </form>
    <div id="payment-details" style="display:none;">
        <h3>Confirm Payment Details</h3>
        <p><strong>Date:</strong> <span id="confirm_date"></span></p>
        <p><strong>Time Slot:</strong> <span id="confirm_time_slot"></span></p>
        <p><strong>Patient:</strong> <span id="confirm_patient"></span></p>
        <p><strong>Doctor:</strong> <span id="confirm_doctor"></span></p>
        <p><strong>Payment Method:</strong> <span id="confirm_payment_method"></span></p>
        <p><strong>Amount:</strong> <span id="confirm_amount"></span></p>
        <button type="button" class="btn btn-secondary" onclick="editAppointment()">Edit</button>
        <button type="button" class="btn btn-primary" onclick="finalizeAppointment()">Finalize Appointment</button>
    </div>
    <script>
        const timeSlotRadio = document.getElementsByName('time_slot');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const submitButton = document.getElementById('submit-button');
        const paymentDetails = document.getElementById('payment-details');

        timeSlotRadio.forEach(radio => {
            radio.addEventListener('change', (event) => {
                const selectedSlot = event.target.value;
                if (selectedSlot === 'morning') {
                    startTimeInput.value = '09:00';
                    endTimeInput.value = '12:00';
                } else {
                    startTimeInput.value = '13:00';
                    endTimeInput.value = '16:00';
                }
            });
        });

        const doctorSelect = document.getElementById('id_doctor');
        const amountInput = document.getElementById('amount');

        doctorSelect.addEventListener('change', (event) => {
            const selectedDoctor = event.target.selectedOptions[0];
            const amount = selectedDoctor.getAttribute('data-amount');
            amountInput.value = amount;
        });

        function confirmPayment() {
            document.getElementById('confirm_date').innerText = document.getElementById('date').value;
            document.getElementById('confirm_time_slot').innerText = document.querySelector('input[name="time_slot"]:checked').nextElementSibling.innerText;
            document.getElementById('confirm_patient').innerText = document.getElementById('id_patient').selectedOptions[0].text;
            document.getElementById('confirm_doctor').innerText = document.getElementById('id_doctor').selectedOptions[0].text;
            document.getElementById('confirm_payment_method').innerText = document.getElementById('payment_method').selectedOptions[0].text;
            document.getElementById('confirm_amount').innerText = document.getElementById('amount').value;
            paymentDetails.style.display = 'block';
            submitButton.style.display = 'none';
            document.getElementById('appointment-form').style.display = 'none';
        }

        function editAppointment() {
            paymentDetails.style.display = 'none';
            submitButton.style.display = 'none';
            document.getElementById('appointment-form').style.display = 'block';
        }

        function finalizeAppointment() {
            paymentDetails.style.display = 'none';
            submitButton.style.display = 'block';
            document.getElementById('appointment-form').submit();
        }
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/appointments/create.blade.php ENDPATH**/ ?>
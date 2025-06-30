
<?php $__env->startSection('title'); ?>
Patient Details
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    .header {
        border: 1px solid #ddd;
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff; /* Primary color background */
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin-bottom: 5px;
    }

    .card-body strong {
        display: inline-block;
        width: 120px; /* Adjust width as needed for alignment */
    }

    h1 {
        margin-bottom: 30px;
        font-size: 2.5em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    h2, h3 {
        color: #343a40;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .list-group-item {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 10px;
        border-radius: 5px;
        background-color: #f8f9fa; /* Subtle background color */
    }

    .list-group-item p {
        margin-bottom: 5px;
    }

    .list-group-item strong {
        display: inline-block;
        width: 150px; /* Adjust width as needed for alignment */
        font-weight: bold;
    }
    .print-container{
        background: white;
        padding: 25px;
    }
</style>

<h2>Patient Details
    
<div class="mt-3 d-flex justify-content-between">
    <button class="btn btn-secondary" onclick="openPrintWindow()">Print</button> 
</div>
</h2>

<div class="container print-container"> 
<div class="header">
    <div class="card-header">
        Patient Information
    </div>
    <div class="card-body">
        <p><strong>ID:</strong> <?php echo e($patient->id); ?></p>
        <p><strong>Name:</strong> <?php echo e($patient->full_name); ?></p>
        <p><strong>NIK:</strong> <?php echo e($patient->nik); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo e(date('d-m-Y', strtotime($patient->date_of_birth))); ?></p>
        <p><strong>Gender:</strong> <?php echo e($patient->gender); ?></p>
        <p><strong>Address:</strong> <?php echo e($patient->address); ?></p>
        <p><strong>Phone Number:</strong> <?php echo e($patient->phone_number); ?></p>
        <p><strong>Email:</strong> <?php echo e($patient->email); ?></p>
    </div>
</div>

<h3>Medical Records</h3>

<?php if($medicalRecords->isEmpty()): ?>
    <p>No medical records found for this patient.</p>
<?php else: ?>
    <div class="list-group" id="medical-records-list"> 
        <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="list-group-item">
            <p><strong>Date Recorded:</strong> <?php echo e($record->date_recorded); ?></p>
            <p><strong>ID Appointment:</strong> <?php echo e($record->id_appointment); ?></p>
            <p><strong>Subjective:</strong> <?php echo e($record->subjective); ?></p>
            <p><strong>Objective:</strong> <?php echo e($record->objective); ?></p>
            <p><strong>Assessment:</strong> <?php echo e($record->assessment); ?></p>
            <p><strong>Plan:</strong> <?php echo e($record->plan); ?></p>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

</div>

<script>
    function openPrintWindow() {
        const printWindow = window.open('<?php echo e(route('patients.printDetails', $patient->id)); ?>', '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/patients/details.blade.php ENDPATH**/ ?>
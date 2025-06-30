

<?php $__env->startSection('content'); ?>

<style>
    .header {
        border: 1px solid #ddd;
        border-radius: 10px; 
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff; 
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        text-align: center;
    }

    .card-body {
        padding: 20px;
    }

    .card-body p {
        margin-bottom: 10px;
    }

    .card-body strong {
        display: inline-block;
        width: 150px; 
        font-weight: bold;
    }

    h2 {
        text-align: center; 
        margin-top: 20px;
        margin-bottom: 10px;
    }
    @media print {
    .card {
        page-break-inside: avoid; 
    }

    .d-flex { 
        display: none; 
    }
}
</style>
<div class="container">
    <h2>Medical Records for <?php echo e($patient->full_name); ?> 
        <?php if($medicalRecords->isNotEmpty() && isset($medicalRecords[0])): ?>
        (Admission ID: <?php echo e($medicalRecords[0]->admission->id); ?>)
        <?php endif; ?>
    </h2> 
    
    <h2>Patient Details</h2>
    
        <div class="header">
            <div class="card-header">Patient Information</div>
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo e($patient->id); ?></p>
                <p><strong>Name:</strong> <?php echo e($patient->full_name); ?></p>
                <p><strong>NIK:</strong> <?php echo e($patient->nik); ?></p>
                <p><strong>Date of Birth:</strong> <?php echo e($patient->date_of_birth); ?></p>
                <p><strong>Gender:</strong> <?php echo e($patient->gender); ?></p>
                <p><strong>Address:</strong> <?php echo e($patient->address); ?></p>
                <p><strong>Phone Number:</strong> <?php echo e($patient->phone_number); ?></p>
                <p><strong>Email:</strong> <?php echo e($patient->email); ?></p>
            </div>
        </div>
        <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="header">
            <div class="card-header">
                SOAP Notes - Date Recorded: <?php echo e($record->date_recorded); ?>

                <?php if($record->admission->doctor): ?>
                    <div>Doctor: <?php echo e($record->admission->doctor->full_name); ?></div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <p><strong>Subjective:</strong> <?php echo e($record->subjective); ?></p>
                <p><strong>Objective:</strong> <?php echo e($record->objective); ?></p>
                <p><strong>Assessment:</strong> <?php echo e($record->assessment); ?></p>
                <p><strong>Plan:</strong> <?php echo e($record->plan); ?></p>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <!-- Print button and script -->
    <div class="mt-3 d-flex justify-content-between">
        <a href="<?php echo e(route('medical_records.indexInpatient')); ?>" class="btn btn-primary">Back to Inpatient Medical Records</a>
        <button class="btn btn-secondary" onclick="openPrintWindow()">Print</button> 
    </div>
</div>

<script>
    function openPrintWindow() {
        const printWindow = window.open('<?php echo e(route('medical_records.printDetailsInpatient', $medicalRecords[0]->admission->id)); ?>', '_blank');
        printWindow.onload = function() {
            printWindow.print();
        };
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/medical_records/show_inpatient.blade.php ENDPATH**/ ?>
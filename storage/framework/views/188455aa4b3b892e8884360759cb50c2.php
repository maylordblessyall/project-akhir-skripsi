<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details - Print</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            width: 100%;
            max-width: 800px; 
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2, h3 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        h1 { 
            font-size: 24pt; 
            border-top: 2px solid #4CAF50;
            border-bottom: 2px solid #4CAF50;
            padding: 10px 0;
        }

        h2, h3 {
            font-size: 18pt;
            color: #0056b3;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px; 
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        }

        .card-header {
            background-color: #e9f5f9; 
            color: #333; 
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 15px;
        }

        .card-body p {
            margin-bottom: 5px; 
        }

        .card-body strong {
            display: inline-block;
            width: 150px; 
            font-weight: bold;
        }

        .list-group {
            padding-left: 0;
            margin-bottom: 0;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px; 
        }

      
        @media print {
            body {
                font-size: 11pt; 
                -webkit-print-color-adjust: exact; 
            }

           
            .no-print {
                display: none;
            }

            
            .list-group-item {
                page-break-inside: avoid;
            }

            .medical-records-header {
                page-break-after: avoid; 
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>RUMAH SAKIT ADVENT</h1>
        <h2>Patient Details</h2>

        <div class="card">
            <div class="card-header"> <strong>Patient Information</strong></div>
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

        <h3 class="medical-records-header">Medical Records</h3>

        <?php if($medicalRecords->isEmpty()): ?>
            <p>No medical records found for this patient.</p>
        <?php else: ?>
            <ul class="list-group" id="medical-records-list"> 
                <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <p><strong>Date Recorded:</strong> <?php echo e($record->date_recorded); ?></p>
                    <p><strong>ID Appointment:</strong> <?php echo e($record->id_appointment); ?></p>
                    <p><strong>Subjective:</strong> <?php echo e($record->subjective); ?></p>
                    <p><strong>Objective:</strong> <?php echo e($record->objective); ?></p>
                    <p><strong>Assessment:</strong> <?php echo e($record->assessment); ?></p>
                    <p><strong>Plan:</strong> <?php echo e($record->plan); ?></p>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>

</body>
</html><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/patients/printDetails.blade.php ENDPATH**/ ?>
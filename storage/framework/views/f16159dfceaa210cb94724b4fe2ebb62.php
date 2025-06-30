<!DOCTYPE html>
<html>
<head>
    <title>Print Appointments</title>
    <style>
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            margin: 30px;
            line-height: 1.6;
            color: #333;
        }
        
        /* Header Styling */
        h2 {
            text-align: center;
            color: #2c3e50;
            padding: 15px 0;
            margin: 0 0 25px;
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Filters Styling */
        .filters {
            margin: 0 auto 30px;
            max-width: 800px;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 0.95rem;
            color: #555;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* Table Container */
        .table-responsive {
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Table Styling */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background: #34495e;
            color: white;
            font-weight: 600;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        /* Alternating row colors */
        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tbody tr:hover {
            background: #f1f3f5;
            transition: background 0.2s ease;
        }

        /* Responsive adjustments */
        @media print {
            .table-responsive {
                box-shadow: none;
            }
            
            h2 {
                background: none;
                color: #2c3e50;
                box-shadow: none;
            }
            
            .filters {
                box-shadow: none;
            }
            
            .table th {
                background: #eee;
                color: #333;
            }
        }

        @media (max-width: 768px) {
            body {
                margin: 15px;
            }
            
            .table th, .table td {
                padding: 10px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <h2>All Appointments</h2>
    <div class="filters">
        <?php if($startDate && $endDate): ?>
            Showing appointments from <?php echo e($startDate->format('Y-m-d')); ?> to <?php echo e($endDate->format('Y-m-d')); ?>

        <?php endif; ?>
        <?php if($selectedDoctor): ?>
            for doctor: <?php echo e($selectedDoctor->full_name); ?> (<?php echo e($selectedDoctor->specialization); ?>)
        <?php endif; ?>
        <?php if($searchQuery): ?>
            for patient: <?php echo e($patient ? $patient->full_name : $searchQuery); ?>

        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Specialization</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($appointment->id); ?></td>
                    <td><?php echo e($appointment->patient->full_name ?? 'N/A'); ?></td>
                    <td><?php echo e($appointment->doctor->full_name ?? 'N/A'); ?></td>
                    <td><?php echo e($appointment->doctor->specialization ?? 'N/A'); ?></td>
                    <td><?php echo e($appointment->date); ?></td>
                    <td><?php echo e($appointment->notes ?? 'N/A'); ?></td>
                    <td><?php echo e($appointment->payment_method ?? 'N/A'); ?></td>
                    <td><?php echo e($appointment->amount ?? 'N/A'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="10">No appointments found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/managers/print_appointments.blade.php ENDPATH**/ ?>
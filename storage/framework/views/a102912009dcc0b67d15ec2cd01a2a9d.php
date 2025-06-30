

<?php $__env->startSection('title'); ?>
Select Payment Method
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<h2>Select Payment Method for Admission ID: <?php echo e($admission->id); ?></h2>

<form action="<?php echo e(route('billing.selectPaymentMethod', $admission->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div>
        <label for="cash">Cash:</label>
        <input type="radio" id="cash" name="payment_method" value="cash" required>
    </div>
    <div>
        <label for="e_cash">E-Cash:</label>
        <input type="radio" id="e_cash" name="payment_method" value="e_cash" required>
    </div>
    <div>
        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('inpatient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/billing/selectPaymentMethod.blade.php ENDPATH**/ ?>
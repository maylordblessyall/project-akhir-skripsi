

<?php $__env->startSection('title'); ?>
  Doctors List
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .container {
        max-width: 960px;
        margin: 0 auto; /* Center the container */
    }

    h1, h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem; 
        color: #212529;
        border-collapse: separate;
        border-spacing: 0 10px; 
    }

    .table th,
    .table td {
        padding: 15px;
        vertical-align: middle;
        text-align: center; /* Center text within cells */
        border-top: 1px solid #ddd;
    }

    .table th {
        background-color: #007bff; /* Blue background for headers */
        color: white;
        font-weight: 500; 
        border-top: 2px solid #007bff; /* Thicker top border for header */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; /* Light gray for odd rows */
    }

    .table .btn {
        margin: 2px;
        padding: 5px 10px; 
        font-size: 0.8rem; 
    }

    .table .btn-info {
        background-color: #00cc00; 
        border-color: #292b2c;
    }

    .table .btn-danger {
        background-color: #d9534f;
    }
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-item .page-link {
        border: 1px solid #ddd;
        color: #007bff;
    }
</style>
  <h1>Doctors</h1>

  <?php if(session('success')): ?>
    <div class="alert alert-success" role="alert">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <a href="<?php echo e(route('doctors.create')); ?>" class="btn btn-success">Tambah Dokter</a>
  <br><br>

  <?php if(count($doctors) > 0): ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Specialization</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($doctor->id); ?></td>
            <td><?php echo e($doctor->full_name); ?></td>
            <td><?php echo e($doctor->specialization); ?></td>
            <td><?php echo e($doctor->email); ?></td>
            <td><?php echo e($doctor->phone_number); ?></td>
            <td>
              <a href="<?php echo e(route('doctors.edit', $doctor->id)); ?>" class="btn btn-sm btn-info">Edit</a>
              <form action="<?php echo e(route('doctors.destroy', $doctor->id)); ?>" method="POST" style="display: inline-block">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No doctors found.</p>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH Z:\Laravel 8\rumah_sakit_advent\resources\views/user/doctors/index.blade.php ENDPATH**/ ?>
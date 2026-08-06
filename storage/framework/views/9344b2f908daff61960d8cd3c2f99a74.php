

<?php $__env->startSection('admin_contents'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-key me-2"></i>
            Manage Permissions for: <span class="text-primary"><?php echo e($role->name); ?></span>
        </h5>
        <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?php echo e(route('roles.permissions.update', $role->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="card-body">
            
            <!-- Select All Button -->
            <div class="mb-3">
                <button type="button" class="btn btn-sm btn-primary" id="selectAll">
                    <i class="fas fa-check-double me-1"></i> Select All
                </button>
                <button type="button" class="btn btn-sm btn-secondary" id="deselectAll">
                    <i class="fas fa-times me-1"></i> Deselect All
                </button>
            </div>

            <hr>

            <!-- Permission Groups -->
            <?php $__currentLoopData = $allPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 text-capitalize">
                            <i class="fas fa-shield-alt me-2"></i>
                            <?php echo e($group); ?> Permissions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input 
                                            type="checkbox" 
                                            name="permissions[]" 
                                            value="<?php echo e($permission->name); ?>" 
                                            class="form-check-input permission-checkbox"
                                            id="permission_<?php echo e($permission->id); ?>"
                                            <?php echo e(in_array($permission->name, $rolePermissions) ? 'checked' : ''); ?>

                                        >
                                        <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                            <?php echo e($permission->name); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Permissions
            </button>
        </div>

    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        selectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => checkbox.checked = true);
        });

        deselectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => checkbox.checked = false);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/roles/edit.blade.php ENDPATH**/ ?>
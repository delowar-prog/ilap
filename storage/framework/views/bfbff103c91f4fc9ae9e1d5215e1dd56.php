

<?php $__env->startSection('admin_contents'); ?>
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-map-marker-alt me-2"></i> States Management
                </h6>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('states.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add State
                </a>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search state name..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="country_id" class="form-select form-select-sm">
                        <option value="">All Countries</option>
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($country->id); ?>" <?php echo e(request('country_id') == $country->id ? 'selected' : ''); ?>>
                                <?php echo e($country->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Country</th>
                    <th>State Name</th>
                    <th>State Code</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th width="100" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center"><?php echo e($states->firstItem() + $loop->index); ?></td>
                        <td><?php echo e($state->country->name); ?></td>
                        <td class="fw-semibold"><?php echo e($state->name); ?></td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary"><?php echo e($state->state_code ?? 'N/A'); ?></span></td>
                        <td><?php echo e($state->type ?? 'N/A'); ?></td>
                        <td>
                            <?php if($state->status == 'active'): ?>
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="<?php echo e(route('states.edit', $state->id)); ?>" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="<?php echo e(route('states.destroy', $state->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No State Found</h6>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer py-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    Showing <?php echo e($states->firstItem() ?? 0); ?> - <?php echo e($states->lastItem() ?? 0); ?> of <?php echo e($states->total()); ?>

                </small>
            </div>
            <div class="col-md-6 text-end">
                <?php echo e($states->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/states/index.blade.php ENDPATH**/ ?>


<?php $__env->startSection('admin_contents'); ?>
    <div class="card mb-3">
        <div class="card-header py-2"> <!-- py-2 added for compact header -->
            <div class="row align-items-center">
                <div class="col">
                    <!-- Heading changed to h6 for smaller size -->
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-code-branch me-2"></i>
                        Branch Management
                    </h6>
                </div>

                <div class="col-auto">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Branch Add')): ?>
                        <a href="<?php echo e(route('branches.create')); ?>" class="btn btn-primary btn-sm"> <!-- btn-sm added -->
                            <i class="fas fa-plus me-1"></i> Add Branch
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-body border-bottom py-3"> <!-- py-3 for compact padding -->
            <form method="GET">
                <div class="row g-2"> <!-- g-2 for tighter grid gap -->

                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search branch..."
                            value="<?php echo e(request('search')); ?>">
                    </div>

                    <div class="col-md-2">
                        <select name="country" class="form-select form-select-sm">
                            <option value="">All Countries</option>
                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($country); ?>" <?php echo e(request('country') == $country ? 'selected' : ''); ?>>
                                    <?php echo e($country); ?>

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
                        <select name="per_page" class="form-select form-select-sm">
                            <option value="10" <?php echo e(request('per_page') == '10' ? 'selected' : ''); ?>>10 Rows</option>
                            <option value="25" <?php echo e(request('per_page') == '25' ? 'selected' : ''); ?>>25 Rows</option>
                            <option value="50" <?php echo e(request('per_page') == '50' ? 'selected' : ''); ?>>50 Rows</option>
                            <option value="100" <?php echo e(request('per_page') == '100' ? 'selected' : ''); ?>>100 Rows</option>
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
            <!-- table-sm and inline font-size added for compact data display -->
            <table class="table table-sm table-hover table-bordered align-middle mb-0" style="font-size: 0.85rem;">

                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Branch</th>
                        <th>Code</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Currency</th>
                        <th>Status</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center">
                                <?php echo e($branches->firstItem() + $loop->index); ?>

                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($branch->logo): ?>
                                        <img src="<?php echo e(asset($branch->logo)); ?>" width="32" height="32" class="rounded-circle me-2">
                                    <?php else: ?>
                                        <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            <?php echo e(substr($branch->name, 0, 1)); ?>

                                        </div>
                                    <?php endif; ?>

                                    <div>
                                        <div class="fw-semibold">
                                            <?php echo e($branch->name); ?>

                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <?php echo e($branch->phone ?? 'N/A'); ?>

                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">
                                    <?php echo e($branch->branch_code); ?>

                                </span>
                            </td>

                            <td><?php echo e($branch->country); ?></td>
                            <td><?php echo e($branch->city); ?></td>
                            <td><?php echo e($branch->currency ?? 'N/A'); ?></td>

                            <td class="text-center">
                                <?php if($branch->status == 'active'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.75rem;">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Branch View')): ?>
                                            <a href="<?php echo e(route('branches.show', $branch->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Branch Edit')): ?>
                                            <a href="<?php echo e(route('branches.edit', $branch->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Branch Delete')): ?>
                                            <form action="<?php echo e(route('branches.destroy', $branch->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No Branch Found</h6>
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
                        Showing <?php echo e($branches->firstItem() ?? 0); ?> - <?php echo e($branches->lastItem() ?? 0); ?> of <?php echo e($branches->total()); ?> records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <!-- Pagination will now render correctly if you added Paginator::useBootstrapFive() in AppServiceProvider -->
                    <?php echo e($branches->withQueryString()->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/branch/index.blade.php ENDPATH**/ ?>
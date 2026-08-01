<?php $__env->startSection('admin_contents'); ?>
    <div class="card mb-3">
        <div class="card-header py-2"> <!-- py-2 added for compact header -->
            <div class="row align-items-center">
                <div class="col">
                    <!-- Heading changed to h6 for smaller size -->
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-code-branch me-2"></i>
                        Campus Management
                    </h6>
                </div>

                <div class="col-auto">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campus add')): ?>
                        <a href="<?php echo e(route('campuses.create')); ?>" class="btn btn-primary btn-sm"> <!-- btn-sm added -->
                            <i class="fas fa-plus me-1"></i> Add Campus
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card-body border-bottom py-3"> <!-- py-3 for compact padding -->
            <form method="GET">
                <div class="row g-2"> <!-- g-2 for tighter grid gap -->

                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search campus..."
                            value="<?php echo e(request('search')); ?>">
                    </div>

                    <div class="col-md-2">
                        <select name="country" class="form-select form-select-sm">
                            <option value="">All Countries</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($country); ?>" <?php echo e(request('country') == $country ? 'selected' : ''); ?>>
                                    <?php echo e($country); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
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
                        <th>Campus</th>
                        <th>Code</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Status</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-center">
                                <?php echo e($campuses->firstItem() + $loop->index); ?>

                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($campus->logo): ?>
                                        <img src="<?php echo e(asset($campus->logo)); ?>" width="32" height="32" class="rounded-circle me-2">
                                    <?php else: ?>
                                        <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            <?php echo e(substr($campus->name, 0, 1)); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div>
                                        <div class="fw-semibold">
                                            <?php echo e($campus->name); ?>

                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <?php echo e($campus->phone ?? 'N/A'); ?>

                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">
                                    <?php echo e($campus->campus_code); ?>

                                </span>
                            </td>

                            <td><?php echo e($campus->country); ?></td>
                            <td><?php echo e($campus->city); ?></td>

                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input global-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-url="<?php echo e(route('status.toggle', ['modelType' => 'campus', 'id' => $campus->id])); ?>"
                                           <?php echo e(($campus->status == 1 || $campus->status == 'active') ? 'checked' : ''); ?> 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Campus View')): ?>
                                            <a href="<?php echo e(route('campuses.show', $campus->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Campus Edit')): ?>
                                            <a href="<?php echo e(route('campuses.edit', $campus->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Campus Delete')): ?>
                                            <form action="<?php echo e(route('campuses.destroy', $campus->id)); ?>" method="POST">
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No Branch Found</h6>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer py-2">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Showing <?php echo e($campuses->firstItem() ?? 0); ?> - <?php echo e($campuses->lastItem() ?? 0); ?> of <?php echo e($campuses->total()); ?> records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <!-- Pagination will now render correctly if you added Paginator::useBootstrapFive() in AppServiceProvider -->
                    <?php echo e($campuses->withQueryString()->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\campus\index.blade.php ENDPATH**/ ?>
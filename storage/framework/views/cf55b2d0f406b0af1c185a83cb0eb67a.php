<?php $__env->startSection('admin_contents'); ?>
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-percentage me-2"></i>
                    Commission Management
                </h6>
            </div>
            <div class="col-auto">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('commission add')): ?>
                    <a href="<?php echo e(route('commissions.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Setup Commission
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search agent name or code..." value="<?php echo e(request('search')); ?>">
                </div>

                <div class="col-md-3">
                    <select name="agent_id" class="form-select form-select-sm">
                        <option value="">All Agents</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($agent->id); ?>" <?php echo e(request('agent_id') == $agent->id ? 'selected' : ''); ?>>
                                <?php echo e($agent->name); ?> (<?php echo e($agent->agent_code); ?>)
                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="commission_type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="flat" <?php echo e(request('commission_type') == 'flat' ? 'selected' : ''); ?>>Flat</option>
                        <option value="percentage" <?php echo e(request('commission_type') == 'percentage' ? 'selected' : ''); ?>>Percentage</option>
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
                    <th>Agent</th>
                    <th>Agent Type</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Created</th>
                    <th width="120" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="text-center"><?php echo e($commissions->firstItem() + $loop->index); ?></td>
                        
                        <td>
                            <div class="fw-semibold"><?php echo e($commission->agent->name); ?></div>
                            <small class="text-muted">
                                <i class="fas fa-ticket-alt me-1"></i><?php echo e($commission->agent->agent_code); ?>

                            </small>
                        </td>

                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($commission->agent->agent_type == 'master'): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary">Master</span>
                            <?php else: ?>
                                <span class="badge bg-info bg-opacity-10 text-info">Sub-Agent</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($commission->course): ?>
                                <div class="fw-semibold"><?php echo e($commission->course->name); ?></div>
                                <small class="text-muted">
                                    Fee: <?php echo e($commission->course->currency); ?> <?php echo e(number_format($commission->course->fee, 2)); ?>

                                </small>
                            <?php else: ?>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-globe me-1"></i>All Courses
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($commission->commission_type == 'percentage'): ?>
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="fas fa-percent me-1"></i>Percentage
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="fas fa-money-bill me-1"></i>Flat
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td class="fw-bold text-primary">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($commission->commission_type == 'percentage'): ?>
                                <?php echo e($commission->amount); ?>%
                            <?php else: ?>
                                <?php echo e(number_format($commission->amount, 2)); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td>
                            <span class="badge bg-dark bg-opacity-10 text-dark">
                                <?php echo e($commission->currency); ?>

                            </span>
                        </td>

                        <td>
                            <small class="text-muted">
                                <?php echo e($commission->created_at->diffForHumans()); ?>

                            </small>
                        </td>

                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" 
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('commission edit')): ?>
                                        <a href="<?php echo e(route('commissions.edit', $commission->id)); ?>" class="dropdown-item py-1">
                                            <i class="fas fa-edit me-2 text-warning"></i>Edit
                                        </a>
                                    <?php endif; ?>

                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('commission delete')): ?>
                                        <form action="<?php echo e(route('commissions.destroy', $commission->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item py-1 text-danger"
                                                    onclick="return confirm('Are you sure you want to delete this commission?')">
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
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No Commission Found</h6>
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <div class="card-footer py-2">
        <div class="row align-items-center">
            <div class="col-md-6 text-end">
                <?php echo e($commissions->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\commissions\index.blade.php ENDPATH**/ ?>
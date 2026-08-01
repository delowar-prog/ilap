<?php $__env->startSection('admin_contents'); ?>
    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-university me-2"></i>
                        Institute Management
                    </h6>
                </div>
                <div class="col-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole(['Student', 'student'])): ?>
                    <a href="<?php echo e(route('institutes.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Institute
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="table-responsive" style="overflow: visible;">
            <table class="table table-sm table-hover table-bordered align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Institute</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Status</th>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole(['Student', 'student'])): ?>
                        <th width="90" class="text-center">Action</th>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $institutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-center"><?php echo e($institutes->firstItem() + $loop->index); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($institute->logo): ?>
                                        <img src="<?php echo e(url($institute->logo)); ?>" width="32" height="32" class="rounded-circle me-2" style="object-fit:cover;">
                                    <?php else: ?>
                                        <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            <?php echo e(substr($institute->name, 0, 1)); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div>
                                        <div class="fw-semibold"><?php echo e($institute->name); ?></div>
                                        <small class="text-muted" style="font-size: 0.75rem;"><?php echo e($institute->email ?? 'N/A'); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">
                                    <?php echo e($institute->code ?? 'N/A'); ?>

                                </span>
                            </td>
                            <td><?php echo e($institute->city ? $institute->city . ', ' . $institute->country : $institute->country); ?></td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($institute->status == 'active'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.75rem;">Inactive</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole(['Student', 'student'])): ?>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        <a href="<?php echo e(route('institutes.edit', $institute->id)); ?>" class="dropdown-item py-1">
                                            <i class="fas fa-edit me-2 text-warning"></i>Edit
                                        </a>
                                        <form action="<?php echo e(route('institutes.destroy', $institute->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No Institutes Found</h6>
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
                        Showing <?php echo e($institutes->firstItem() ?? 0); ?> - <?php echo e($institutes->lastItem() ?? 0); ?> of <?php echo e($institutes->total()); ?> records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <?php echo e($institutes->withQueryString()->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\institute\index.blade.php ENDPATH**/ ?>
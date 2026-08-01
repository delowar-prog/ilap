<?php $__env->startSection('admin_contents'); ?>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i>
                        Role Management
                    </h5>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Role Name</th>
                        <th>Created At</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($roles->firstItem() + $loop->index); ?></td>

                            <td>
                                <div class="fw-semibold">
                                    <?php echo e($role->name); ?>

                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($role->name === 'Super Admin'): ?>
                                    <small class="text-danger">
                                        <i class="fas fa-crown me-1"></i>Super Admin
                                    </small>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>



                            <td><?php echo e($role->created_at->format('d M Y')); ?></td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-falcon-default dropdown-toggle" data-bs-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role edit')): ?>
                                            <a href="<?php echo e(route('roles.permissions', $role->id)); ?>" class="dropdown-item">
                                                <i class="fas fa-key me-2"></i>Edit Role
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6>No Role Found</h6>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-md-6">
                    Showing <?php echo e($roles->firstItem() ?? 0); ?> - <?php echo e($roles->lastItem() ?? 0); ?> of <?php echo e($roles->total()); ?> records
                </div>
                <div class="col-md-6 text-end">
                    <?php echo e($roles->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\roles\index.blade.php ENDPATH**/ ?>
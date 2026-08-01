<?php $__env->startPush('css'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('admin_contents'); ?>

    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-users me-2"></i>
                        User Management
                    </h6>
                </div>

                <div class="col-auto">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user add')): ?>
                        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add User
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
                            placeholder="Search name or email..." value="<?php echo e(request('search')); ?>">
                    </div>

                    <div class="col-md-3">
                        <select name="campus_id" class="form-select form-select-sm">
                            <option value="">All Campus</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $campuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($campus->id); ?>"
                                    <?php echo e(request('campus_id') == $campus->id ? 'selected' : ''); ?>>
                                    <?php echo e($campus->name); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="role" class="form-select form-select-sm">
                            <option value="">All Roles</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($role->name); ?>" <?php echo e(request('role') == $role->name ? 'selected' : ''); ?>>
                                    <?php echo e($role->name); ?>

                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive
                            </option>
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
                        <th width="50" class="text-center">ID</th>
                        <th>User Name</th>
                        <th>Campus Code</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Fource Login</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-center"><?php echo e($users->firstItem() + $loop->index); ?></td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold"><?php echo e($user->user_first_name . ' ' . $user->user_last_name); ?></div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.75rem;">
                                    <?php echo e($user->campus->campus_code ?? 'N/A'); ?>

                                </span>
                            </td>

                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <span class="badge bg-info bg-opacity-10 text-info"
                                        style="font-size: 0.75rem;"><?php echo e($roleName); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </td>

                            <td><?php echo e($user->phone ?? 'N/A'); ?></td>

                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input global-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-url="<?php echo e(route('status.toggle', ['modelType' => 'user', 'id' => $user->id])); ?>"
                                           <?php echo e(($user->status == 1 || $user->status == 'active') ? 'checked' : ''); ?> 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>

                            <td class="text-start">
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->canImpersonate() && $user->canBeImpersonated()): ?>
                                    <form action="<?php echo e(route('impersonate', $user->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="btn btn-sm btn-warning" 
                                                data-bs-toggle="tooltip" 
                                                title="Login as User">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>


                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user view')): ?>
                                            <a href="<?php echo e(route('users.show', $user->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit user')): ?>
                                            <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        <?php endif; ?>

                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete user')): ?>
                                            <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item py-1 text-danger"
                                                    onclick="return confirm('Are you sure?')">
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
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No User Found</h6>
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
                        Showing <?php echo e($users->firstItem() ?? 0); ?> - <?php echo e($users->lastItem() ?? 0); ?> of <?php echo e($users->total()); ?>

                        records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <?php echo e($users->withQueryString()->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\users\index.blade.php ENDPATH**/ ?>
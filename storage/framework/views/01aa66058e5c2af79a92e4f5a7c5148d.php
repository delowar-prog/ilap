<?php $__env->startSection('admin_contents'); ?>
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        Permission Management
                    </h5>
                </div>
            </div>
        </div>

        <!-- Add New Permission Form -->
        <div class="card-body border-bottom">
            <form action="<?php echo e(route('permissions.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">
                            Add New Permission <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            placeholder="Enter permission name (e.g., manage users, view reports)"
                            value="<?php echo e(old('name')); ?>"
                            required
                        >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Ex: Branch View, User Add
                        </small>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-1"></i>
                            Add Permission
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Permissions Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Permission Name</th>
                        <th>Group</th>
                        <th>Used In Roles</th>
                        <th>Created At</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($permissions->firstItem() + $loop->index); ?></td>

                            <td>
                                <div class="fw-semibold">
                                    <?php echo e($permission->name); ?>

                                </div>
                            </td>

                            <td>
                                <?php
                                    $group = explode(' ', $permission->name)[1] ?? 'general';
                                ?>
                                <span class="badge bg-secondary text-capitalize">
                                    <?php echo e($group); ?>

                                </span>
                            </td>

                            <td>
                                <?php
                                    $rolesCount = \Spatie\Permission\Models\Role::permission($permission)->count();
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rolesCount > 0): ?>
                                    <span class="badge bg-info">
                                        <?php echo e($rolesCount); ?> <?php echo e(Str::plural('role', $rolesCount)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">Not used</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <td><?php echo e($permission->created_at->format('d M Y')); ?></td>

                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rolesCount == 0): ?>
                                    <form action="<?php echo e(route('permissions.destroy', $permission->id)); ?>" method="POST" 
                                          >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-secondary" disabled title="Cannot delete - in use">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6>No Permission Found</h6>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-md-6">
                    Showing <?php echo e($permissions->firstItem() ?? 0); ?> - <?php echo e($permissions->lastItem() ?? 0); ?> of <?php echo e($permissions->total()); ?> records
                </div>
                <div class="col-md-6 text-end">
                    <?php echo e($permissions->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\permissions\index.blade.php ENDPATH**/ ?>
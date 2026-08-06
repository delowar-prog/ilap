

<?php $__env->startSection('admin_contents'); ?>
    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-user-tie me-2"></i>
                        Agent Management
                    </h6>
                </div>
                <div class="col-auto">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent add')): ?>
                        <a href="<?php echo e(route('agents.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Agent
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
                            placeholder="Search name, email or code..." value="<?php echo e(request('search')); ?>">
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasRole('Super Admin')): ?>
                        <div class="col-md-2">
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
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="col-md-2">
                        <select name="agent_type" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="master" <?php echo e(request('agent_type') == 'master' ? 'selected' : ''); ?>>Master Agent
                            </option>
                            <option value="sub_agent" <?php echo e(request('agent_type') == 'sub_agent' ? 'selected' : ''); ?>>Sub-Agent
                            </option>
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
                        <th>Agent Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Parent Agent</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-center"><?php echo e($agents->firstItem() + $loop->index); ?></td>

                            <td>
                                <span class="badge bg-dark bg-opacity-10 text-dark" style="font-size: 0.75rem;">
                                    <?php echo e($agent->agent_code); ?>

                                </span>
                            </td>

                            <td>
                                <div class="fw-semibold"><?php echo e($agent->full_name); ?></div>
                                <small class="text-muted"><?php echo e($agent->campus->name ?? 'N/A'); ?></small>
                            </td>

                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($agent->agent_type == 'master'): ?>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">Master</span>
                                <?php else: ?>
                                    <span class="badge bg-info bg-opacity-10 text-info">Sub-Agent</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <td>
                                <?php echo e($agent->parentAgent?->full_name ?? 'N/A'); ?>

                            </td>

                            <td><?php echo e($agent->email); ?></td>

                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($agent->status == 'active'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent view')): ?>
                                            <a href="<?php echo e(route('agents.show', $agent->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent edit')): ?>
                                            <a href="<?php echo e(route('agents.edit', $agent->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent delete')): ?>
                                            <form action="<?php echo e(route('agents.destroy', $agent->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item py-1 text-danger"
                                                    onclick="return confirmDeleteAgent('<?php echo e($agent->name); ?>', '<?php echo e($agent->agent_code); ?>')">
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
                                <h6 class="text-muted">No Agent Found</h6>
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
                        Showing <?php echo e($agents->firstItem() ?? 0); ?> - <?php echo e($agents->lastItem() ?? 0); ?> of
                        <?php echo e($agents->total()); ?> records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <?php echo e($agents->withQueryString()->links()); ?>

                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            function confirmDeleteAgent(name, code) {
                return confirm(
                    `⚠️ Are you sure you want to delete this agent?\n\n` +
                    `Name: ${name}\n` +
                    `Promo Code: ${code}\n\n` +
                    `Note: This action cannot be undone. The agent must have no sub-agents, students, or commissions.`
                );
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/agents/index.blade.php ENDPATH**/ ?>
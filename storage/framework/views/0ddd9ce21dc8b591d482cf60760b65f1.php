<?php $__env->startSection('admin_contents'); ?>
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-book me-2"></i> Course Management
                </h6>
            </div>
            <div class="col-auto">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole(['Student', 'student'])): ?>
                <a href="<?php echo e(route('courses.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add Course
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search name, code or institute..." value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-2">
                    <select name="course_type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="ilap" <?php echo e(request('course_type') == 'ilap' ? 'selected' : ''); ?>>iLAP Own</option>
                        <option value="external" <?php echo e(request('course_type') == 'external' ? 'selected' : ''); ?>>External</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        <option value="short" <?php echo e(request('category') == 'short' ? 'selected' : ''); ?>>Short</option>
                        <option value="long" <?php echo e(request('category') == 'long' ? 'selected' : ''); ?>>Long</option>
                        <option value="degree" <?php echo e(request('category') == 'degree' ? 'selected' : ''); ?>>Degree</option>
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

    
    <div class="table-responsive" style="overflow: visible;">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Institute</th>
                    <th>Category</th>
                    <th>Duration</th>
                    <th>Fee</th>
                    <th>Intake</th>
                    <th>Status</th>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole(['Student', 'student'])): ?>
                    <th width="120" class="text-center">Action</th>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td class="text-center"><?php echo e($courses->firstItem() + $loop->index); ?></td>
                        <td>
                            <div class="fw-semibold"><?php echo e($course->name); ?></div>
                            <small class="text-muted">
                                <i class="fas fa-hashtag me-1"></i><?php echo e($course->course_code ?? 'N/A'); ?>

                            </small>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->is_featured): ?>
                                <span class="badge bg-warning text-dark ms-1">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->is_ilap_course): ?>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-home me-1"></i>iLAP Own
                                </span>
                            <?php else: ?>
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-university me-1"></i>External
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->is_ilap_course): ?>
                                <span class="text-muted">iLAP Institute</span>
                            <?php else: ?>
                                <div><?php echo e($course->partner_institute ?? 'N/A'); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->institute_country): ?>
                                    <small class="text-muted">
                                        <i class="fas fa-globe me-1"></i><?php echo e($course->institute_country); ?>

                                    </small>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->category): ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <?php echo e(ucfirst($course->category)); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td><?php echo e($course->duration ?? 'N/A'); ?></td>
                        <td class="fw-bold text-primary">
                            <?php echo e($course->currency); ?> <?php echo e(number_format($course->fee, 2)); ?>

                        </td>
                        <td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($course->intake): ?>
                                <small><?php echo e($course->intake); ?></small>
                            <?php else: ?>
                                <span class="text-muted">N/A</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block m-0">
                                <input class="form-check-input global-status-toggle" 
                                       type="checkbox" 
                                       role="switch" 
                                       data-url="<?php echo e(route('status.toggle', ['modelType' => 'course', 'id' => $course->id])); ?>"
                                       <?php echo e($course->status == 'active' ? 'checked' : ''); ?> 
                                       style="cursor: pointer; width: 2.8em; height: 1.4em;">
                            </div>
                        </td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!auth()->user()->hasRole(['Student', 'student'])): ?>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="<?php echo e(route('courses.edit', $course->id)); ?>" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="<?php echo e(route('courses.destroy', $course->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="dropdown-item py-1 text-danger"
                                                onclick="return confirm('Are you sure?')">
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
                        <td colspan="10" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No Course Found</h6>
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
                    Showing <?php echo e($courses->firstItem() ?? 0); ?> - <?php echo e($courses->lastItem() ?? 0); ?> of <?php echo e($courses->total()); ?>

                </small>
            </div>
            <div class="col-md-6 text-end">
                <?php echo e($courses->withQueryString()->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\courses\index.blade.php ENDPATH**/ ?>
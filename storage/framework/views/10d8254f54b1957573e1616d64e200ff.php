<?php $__env->startSection('title', 'Pre-Assessments'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Pre-Assessments</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.pre.assessments.index', ['status' => 'pending'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'pending' ? 'active' : ''); ?>">
                            <i class="mdi mdi-clock-outline me-1"></i> Pending
                            <span class="badge bg-danger rounded-pill ms-1"><?php echo e($counts['pending']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.pre.assessments.index', ['status' => 'approved'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'approved' ? 'active' : ''); ?>">
                            <i class="mdi mdi-check-circle-outline me-1"></i> Approved
                            <span class="badge bg-success rounded-pill ms-1"><?php echo e($counts['approved']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.pre.assessments.index', ['status' => 'rejected'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'rejected' ? 'active' : ''); ?>">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Rejected
                            <span class="badge bg-warning rounded-pill ms-1"><?php echo e($counts['rejected']); ?></span>
                        </a>
                    </li>
                </ul>


                
                <form method="GET" action="<?php echo e(route('admin.pre.assessments.index')); ?>" class="mb-3">
                    <input type="hidden" name="status" value="<?php echo e($status); ?>">
                    <input type="hidden" name="sort_by" value="<?php echo e($sortBy); ?>">
                    <input type="hidden" name="sort_dir" value="<?php echo e($sortDir); ?>">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_pa" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e($perPage == $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <span class="text-muted" style="font-size:0.82rem;">entries</span>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group" style="width:300px;">
                                <span class="input-group-text bg-white" style="border-right:0;"><i class="fas fa-search text-muted" style="font-size:0.8rem;"></i></span>
                                <input type="text" name="search" class="form-control form-control-sm border-start-0"
                                       placeholder="Search name, email, phone..."
                                       value="<?php echo e($search); ?>" style="box-shadow:none;">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary px-3">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                <a href="<?php echo e(route('admin.pre.assessments.index', ['status' => $status, 'per_page' => $perPage])); ?>"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <?php
                                    function paSort($col, $label, $sortBy, $sortDir, $status, $search, $perPage) {
                                        $dir = ($sortBy === $col && $sortDir === 'asc') ? 'desc' : 'asc';
                                        $icon = $sortBy === $col ? ($sortDir === 'asc' ? '▲' : '▼') : '⇅';
                                        $url = route('admin.pre.assessments.index', compact('status', 'search', 'perPage') + ['sort_by' => $col, 'sort_dir' => $dir]);
                                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} <small>{$icon}</small></a>";
                                    }
                                ?>
                                <th><?php echo paSort('first_name', 'Name', $sortBy, $sortDir, $status, $search, $perPage); ?></th>
                                <th>Campus</th>
                                <th><?php echo paSort('contact_number', 'Phone', $sortBy, $sortDir, $status, $search, $perPage); ?></th>
                                <th>Study Destination</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">
                                            <a href="<?php echo e(route('admin.pre.assessments.show', $assessment->id)); ?>" class="text-body fw-bold">
                                                <?php echo e(trim(($assessment->first_name ?? $assessment->student->first_name).' '.($assessment->surname ?? $assessment->student->surname))); ?>

                                            </a>
                                        </h5>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->student && $assessment->student->campus): ?>
                                            <span class="badge bg-info text-dark"><?php echo e($assessment->student->campus->name); ?></span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td><?php echo e($assessment->contact_number ?? $assessment->student->phone); ?></td>
                                    <td><?php echo e($assessment->study_destination ?? '-'); ?></td>
                                    <td class="text-end">
                                        <a href="<?php echo e(route('admin.pre.assessments.show', $assessment->id)); ?>" 
                                           class="btn btn-sm btn-info" 
                                           data-bs-toggle="tooltip" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->assessment_status === 'approved'): ?>
                                            <form action="<?php echo e(route('admin.pre.assessments.send_to_pre_enrolment', $assessment->id)); ?>" method="POST" class="d-inline-block ms-1">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-primary" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Send to Pre-Enrolment"
                                                        onclick="return confirm('Send this student to Pre-Enrolment?');">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->assessment_status === 'rejected'): ?>
                                            <form action="<?php echo e(route('admin.pre.assessments.revert_to_pending', $assessment->id)); ?>" method="POST" class="d-inline-block ms-1">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-warning" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Move to Pending"
                                                        onclick="return confirm('Move this application back to Pending?');">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.pre.assessments.destroy', $assessment->id)); ?>" method="POST" class="d-inline-block ms-1">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Assessment"
                                                        onclick="return confirm('Are you sure you want to delete this pre-assessment?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                        No assessments found.
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing <?php echo e($assessments->firstItem() ?? 0); ?>–<?php echo e($assessments->lastItem() ?? 0); ?> of <?php echo e($assessments->total()); ?> records
                    </small>
                    <?php echo e($assessments->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views/backend/pre_assessment/index.blade.php ENDPATH**/ ?>
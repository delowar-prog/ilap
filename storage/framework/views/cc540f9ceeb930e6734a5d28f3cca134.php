<?php $__env->startSection('title', 'Enrolled Students'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-users text-primary me-2"></i> Enrolled Students</h5>
            </div>
            
            <div class="card-body">
                
                <form method="GET" action="<?php echo e(route('admin.students.enrolled')); ?>" class="mb-3">
                    <input type="hidden" name="sort_by" value="<?php echo e($sortBy); ?>">
                    <input type="hidden" name="sort_dir" value="<?php echo e($sortDir); ?>">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_en" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
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
                                       placeholder="Search name, email, phone, ID..."
                                       value="<?php echo e($search); ?>" style="box-shadow:none;">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary px-3">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                <a href="<?php echo e(route('admin.students.enrolled', ['per_page' => $perPage])); ?>"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="min-height: 350px;">
                    <table class="table table-hover align-middle mb-0 custom-table">
                        <thead class="table-light">
                            <tr>
                                <?php
                                    function enSort($col, $label, $sortBy, $sortDir, $search, $perPage) {
                                        $dir = ($sortBy === $col && $sortDir === 'asc') ? 'desc' : 'asc';
                                        $icon = $sortBy === $col ? ($sortDir === 'asc' ? '▲' : '▼') : '⇅';
                                        $url = route('admin.students.enrolled', compact('search', 'perPage') + ['sort_by' => $col, 'sort_dir' => $dir]);
                                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} <small>{$icon}</small></a>";
                                    }
                                ?>
                                <th>#</th>
                                <th><?php echo enSort('student_id', 'Student ID', $sortBy, $sortDir, $search, $perPage); ?></th>
                                <th><?php echo enSort('first_name', 'Name', $sortBy, $sortDir, $search, $perPage); ?></th>
                                <th>Campus</th>
                                <th><?php echo enSort('phone', 'Phone', $sortBy, $sortDir, $search, $perPage); ?></th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($loop->iteration + $students->firstItem() - 1); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($student->student_id); ?></span></td>
                                <td>
                                    <strong><?php echo e(trim($student->first_name.' '.$student->surname)); ?></strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->nationality): ?>
                                    <br><small class="text-muted"><?php echo e($student->nationality); ?></small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->campus): ?>
                                        <span class="badge bg-info text-dark"><?php echo e($student->campus->name); ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><?php echo e($student->phone ?? '-'); ?></td>
                                <td>
                                    <span class="badge bg-success">Enrolled</span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" data-bs-boundary="window">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="<?php echo e(route('admin.students.show', $student->id)); ?>" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-info"></i>View Profile
                                            </a>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->applications->isEmpty()): ?>
                                                <a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>" class="dropdown-item py-1">
                                                    <i class="fas fa-file-invoice-dollar me-2 text-success"></i>Manage Course & Fees
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>No enrolled students found.
                                </td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing <?php echo e($students->firstItem() ?? 0); ?>–<?php echo e($students->lastItem() ?? 0); ?> of <?php echo e($students->total()); ?> records
                    </small>
                    <?php echo e($students->withQueryString()->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\admin\students\enrolled.blade.php ENDPATH**/ ?>
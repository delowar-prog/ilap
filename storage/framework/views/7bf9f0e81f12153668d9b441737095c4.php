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

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Study Destination</th>
                                <th>Submitted At</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $assessments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assessment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">
                                            <a href="<?php echo e(route('admin.pre.assessments.show', $assessment->id)); ?>" class="text-body">
                                                <?php echo e($assessment->full_name ?? $assessment->student->first_name); ?>

                                            </a>
                                        </h5>
                                    </td>
                                    <td><?php echo e($assessment->student->email ?? '-'); ?></td>
                                    <td><?php echo e($assessment->contact_number ?? $assessment->student->phone); ?></td>
                                    <td><?php echo e($assessment->study_destination ?? '-'); ?></td>
                                    <td><?php echo e($assessment->updated_at->format('d M Y, h:i A')); ?></td>
                                    <td class="text-end">
                                        <a href="<?php echo e(route('admin.pre.assessments.show', $assessment->id)); ?>" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">No assessments found.</td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    <?php echo e($assessments->appends(['status' => $status])->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/pre_assessment/index.blade.php ENDPATH**/ ?>
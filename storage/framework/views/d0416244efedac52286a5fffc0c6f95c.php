<?php $__env->startSection('title', 'Student Dashboard'); ?>

<?php $__env->startPush('css'); ?>
<style>
    .dashboard-header {
        background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%);
        border-radius: 16px;
        padding: 30px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(26, 159, 212, 0.15);
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
        height: 100%;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 16px;
    }
    .bg-light-primary { background: rgba(44, 62, 122, 0.1); color: #2c3e7a; }
    .bg-light-success { background: rgba(39, 174, 96, 0.1); color: #27ae60; }
    .bg-light-info { background: rgba(26, 159, 212, 0.1); color: #1a9fd4; }
    
    .completion-bar-bg {
        height: 8px;
        background: rgba(255,255,255,0.2);
        border-radius: 4px;
        margin-top: 12px;
    }
    .completion-bar-fill {
        height: 100%;
        background: #fff;
        border-radius: 4px;
        transition: width 0.5s ease-in-out;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row">
    <!-- Welcome Header -->
    <div class="col-12">
        <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="text-white mb-2 fw-bold">Welcome back, <?php echo e($student->first_name); ?>! 👋</h2>
                <p class="mb-0 opacity-75">Student ID: <?php echo e($student->student_id); ?> &bull; <?php echo e($student->email); ?></p>
            </div>
            <div style="min-width: 250px;">
                <div class="d-flex justify-content-between mb-1">
                    <span class="font-14 fw-semibold">Profile Completion</span>
                    <span class="font-14 fw-bold"><?php echo e($completionPercent); ?>%</span>
                </div>
                <div class="completion-bar-bg">
                    <div class="completion-bar-fill" style="width: <?php echo e($completionPercent); ?>%;"></div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completionPercent < 100): ?>
                    <div class="text-end mt-2">
                        <a href="<?php echo e(route('student.profile')); ?>" class="btn btn-sm btn-light fw-bold text-dark" style="color: #2c3e7a !important;">Complete Profile</a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-light-primary">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h5 class="text-muted font-14 mb-1">Pre-Assessment Status</h5>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$preAssessment->isSubmitted()): ?>
                <h3 class="mb-0 text-dark fw-bold">Not Submitted</h3>
                <a href="<?php echo e(route('pre.assessment.show')); ?>" class="btn btn-primary btn-sm mt-3 w-100">Submit Now</a>
            <?php elseif($preAssessment->isPending()): ?>
                <h3 class="mb-0 text-warning fw-bold">Under Review</h3>
                <a href="<?php echo e(route('pre.assessment.index')); ?>" class="btn btn-outline-warning btn-sm mt-3 w-100">View Status</a>
            <?php elseif($preAssessment->isApproved()): ?>
                <h3 class="mb-0 text-success fw-bold">Approved</h3>
                <a href="<?php echo e(route('pre.assessment.index')); ?>" class="btn btn-outline-success btn-sm mt-3 w-100">View Status</a>
            <?php elseif($preAssessment->isRejected()): ?>
                <h3 class="mb-0 text-danger fw-bold">Rejected</h3>
                <a href="<?php echo e(route('pre.assessment.index')); ?>" class="btn btn-outline-danger btn-sm mt-3 w-100">View Status</a>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-light-info">
                <i class="fas fa-file-upload"></i>
            </div>
            <h5 class="text-muted font-14 mb-1">Uploaded Documents</h5>
            <h3 class="mb-0 text-dark fw-bold"><?php echo e($documents->count()); ?></h3>
            <a href="<?php echo e(route('student.profile')); ?>#nav-5" class="btn btn-outline-info btn-sm mt-3 w-100">Manage Documents</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-light-success">
                <i class="fas fa-university"></i>
            </div>
            <h5 class="text-muted font-14 mb-1">University Applications</h5>
            <h3 class="mb-0 text-dark fw-bold">0</h3>
            <button class="btn btn-outline-secondary btn-sm mt-3 w-100" disabled>Coming Soon</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-bell text-warning me-2"></i> Recent Updates</h5>
            </div>
            <div class="card-body">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($preAssessment->isApproved()): ?>
                    <div class="alert alert-success border-0 mb-0">
                        <i class="mdi mdi-check-circle-outline me-1"></i> Your Pre-Assessment was approved! Your profile has been auto-populated with your details.
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">No recent updates.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/student/student_dashbord.blade.php ENDPATH**/ ?>
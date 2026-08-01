<?php $__env->startSection('title', 'Student Profile'); ?>

<?php $__env->startPush('css'); ?>
<style>
.profile-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 2rem;
}
.profile-header {
    background: linear-gradient(135deg, #1b2a47 0%, #2c3e7a 100%);
    color: #fff;
    padding: 2.5rem;
    position: relative;
}
.profile-avatar-container {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.profile-avatar {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.2);
    object-fit: cover;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #fff;
}
.profile-header-info h2 {
    margin: 0 0 0.2rem;
    font-weight: 700;
    color: #fff;
}
.profile-header-info p {
    margin: 0;
    opacity: 0.8;
}
.profile-edit-btn {
    position: absolute;
    top: 2rem;
    right: 2.5rem;
}
.info-section {
    padding: 2rem;
    border-bottom: 1px solid #edf2f9;
}
.info-section:last-child {
    border-bottom: none;
}
.info-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e7a;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}
.info-item label {
    display: block;
    font-size: 0.85rem;
    color: #95aac9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}
.info-item span {
    display: block;
    font-weight: 500;
    color: #344050;
    font-size: 1rem;
}
.table-custom th {
    background: #f8f9fa;
    color: #5e6e82;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row">
    <div class="col-12">
        <div class="profile-card">
            
            <!-- Header Section -->
            <div class="profile-header">
                <a href="<?php echo e(route('admin.students.index')); ?>" class="btn btn-light btn-sm profile-edit-btn shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students
                </a>
                <div class="profile-avatar-container">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->profile_picture): ?>
                        <img src="<?php echo e(asset($student->profile_picture)); ?>" alt="Profile" class="profile-avatar">
                    <?php else: ?>
                        <div class="profile-avatar">
                            <?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->surname,0,1))); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="profile-header-info">
                        <h2><?php echo e(ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname))); ?></h2>
                        <p><i class="fas fa-id-badge me-1"></i> <?php echo e($student->student_id); ?> &nbsp;|&nbsp; <i class="fas fa-envelope me-1"></i> <?php echo e($student->email); ?></p>
                        <div class="mt-2 text-white-50 small">Profile Completion: <strong class="text-white"><?php echo e($completionPercent); ?>%</strong></div>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($student->enrolment_status, ['enrolled', 'approved'])): ?>
            <div class="action-bar border-bottom p-3 bg-light d-flex gap-2 align-items-center flex-wrap">
                <a href="<?php echo e(route('admin.students.profile.pdf', $student->id)); ?>" class="btn btn-primary btn-sm rounded-pill shadow-sm px-3">
                    <i class="fas fa-file-pdf me-1"></i> Profile PDF
                </a>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#generateLetterModal">
                    <i class="fas fa-envelope-open-text me-1"></i> Generate Letter
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Generate Invoice
                </button>
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Chatting', text: 'Chatting option is coming soon!', icon: 'info'})">
                    <i class="fas fa-comments me-1"></i> Chatting
                </a>
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Email', text: 'Email communication option is coming soon!', icon: 'info'})">
                    <i class="fas fa-envelope me-1"></i> Email
                </a>
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Support', text: 'Support ticket/queries option is coming soon!', icon: 'info'})">
                    <i class="fas fa-headset me-1"></i> Support
                </a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Referral Info (Only visible to the owner and enrolled students) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::id() == $student->user_id && $student->enrolment_status === 'enrolled'): ?>
            <div class="info-section bg-light" style="border-bottom: 2px solid #e1e8f1;">
                <div class="info-section-title"><i class="fas fa-bullhorn text-primary"></i> Invite Friends</div>
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <p class="text-muted mb-2">Share this invite link for new registrations.</p>
                        <div class="input-group mb-3 shadow-sm">
                            <span class="input-group-text bg-white"><i class="fas fa-link text-primary"></i></span>
                            <input type="text" class="form-control bg-white" id="inviteLinkInput" value="<?php echo e(url('/register/' . ($student->user_id ?? ''))); ?>" readonly>
                            <button class="btn btn-primary" type="button" onclick="copyInviteLink()"><i class="fas fa-copy"></i> Copy</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="info-grid" style="grid-template-columns: 1fr 1fr;">
                            <div class="info-item">
                                <label>Your Promo Code</label>
                                <span class="badge bg-success" style="font-size: 1rem; padding: 8px 12px;"><?php echo e($student->user->referral_code ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Your Campus Code</label>
                                <span class="badge bg-info text-dark" style="font-size: 1rem; padding: 8px 12px;"><?php echo e($student->campus ? $student->campus->campus_code : 'N/A'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Enrolment Details -->
            <?php
                $canAssignCourse = ($student->preAssessment && $student->preAssessment->assessment_status === 'approved' && $student->enrolment_status !== 'pending');
                $application = $student->applications()->with(['course', 'additionalCosts', 'installments'])->first();
            ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application): ?>
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="border-left: 5px solid #2c3e7a !important;">
                <div class="card-body p-4">
                    <!-- Top Header Section -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4">
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle text-white me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%) !important; box-shadow: 0 4px 10px rgba(44, 62, 122, 0.3);">
                                <i class="fas fa-graduation-cap fa-lg"></i>
                            </div>
                            <div>
                                <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">Enrolled Program</span>
                                <h4 class="mb-0 fw-bold text-dark mt-1" style="font-size: 1.35rem; line-height: 1.2;"><?php echo e($application->course->name); ?></h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge px-3 py-2 rounded-pill font-13 fw-bold" style="background-color: rgba(44, 62, 122, 0.1); color: #2c3e7a; border: 1px solid rgba(44, 62, 122, 0.2); font-size: 0.9rem;">
                                <i class="fas fa-barcode me-1"></i> <?php echo e($application->course->course_code); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->preAssessment && $student->preAssessment->assessment_status === 'approved'): ?>
                                <a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>" class="btn btn-sm btn-primary py-2 px-3 rounded-pill shadow-sm">
                                    <i class="fas fa-edit me-1"></i> Edit Enrolment
                                </a>
                            <?php else: ?>
                                <button type="button" class="btn btn-sm btn-secondary py-2 px-3 rounded-pill shadow-sm" disabled title="Approve Pre-Enrolment first">
                                    <i class="fas fa-lock me-1"></i> Edit Enrolment (Pending Approval)
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Course Attributes Grid -->
                    <div class="row g-4 mb-4">
                        <!-- Partner Institute -->
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-primary me-3" style="width: 42px; height: 42px; background-color: rgba(44, 62, 122, 0.1);">
                                    <i class="fas fa-university fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Partner Institute</small>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;"><?php echo e($application->course->partner_institute); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Study Method -->
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-success me-3" style="width: 42px; height: 42px; background-color: rgba(40, 167, 69, 0.1);">
                                    <i class="fas fa-book-reader fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Study Method</small>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;"><?php echo e($application->course->study_method); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-warning me-3" style="width: 42px; height: 42px; background-color: rgba(255, 193, 7, 0.1);">
                                    <i class="fas fa-clock fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Duration</small>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;"><?php echo e(is_numeric($application->course->duration) ? $application->course->duration . ' Years' : $application->course->duration); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tuition Fee -->
                        <div class="col-md-6 col-lg-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 d-flex align-items-center justify-content-center text-danger me-3" style="width: 42px; height: 42px; background-color: rgba(220, 53, 69, 0.1);">
                                    <i class="fas fa-wallet fa-lg"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Tuition Fee</small>
                                    <span class="fw-bold text-dark" style="font-size: 0.95rem;"><?php echo e(number_format($application->total_fee, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Schedule & Summary Row -->
                    <div class="row g-4 pt-3 border-top">
                        <!-- Payment Installments -->
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-muted text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;"><i class="fas fa-calendar-alt text-primary me-2"></i> Payment Installments Schedule</h6>
                                <button type="button" id="generateInvoiceSelectedBtn" class="btn btn-sm btn-outline-success rounded-pill px-3 d-none" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal" onclick="prepareInvoiceModal()">
                                    <i class="fas fa-file-invoice me-1"></i> Generate Invoice (<span id="selectedItemCount">0</span> selected)
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle" style="font-size: 0.85rem;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:36px;"><input type="checkbox" id="selectAllInstallments" class="form-check-input" title="Select All Installments"></th>
                                            <th>Installment</th>
                                            <th>Due Date</th>
                                            <th class="text-end">Amount</th>
                                            <th class="text-end">Paid</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $application->installments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input installment-checkbox" value="<?php echo e($inst->id); ?>" onchange="updateSelectedCount()"></td>
                                                <td class="fw-semibold text-muted">
                                                    Installment <?php echo e($inst->installment_number); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inst->is_invoiced): ?>
                                                        <span class="badge bg-info ms-1" title="Invoiced on <?php echo e($inst->invoiced_at?->format('d M Y H:i')); ?>"><i class="fas fa-file-invoice me-1"></i>Invoiced</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                                <td><?php echo e($inst->due_date ? $inst->due_date->format('d M, Y') : '-'); ?></td>
                                                <td class="text-end fw-bold"><?php echo e(number_format($inst->amount, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></td>
                                                <td class="text-end text-success"><?php echo e(number_format($inst->paid_amount, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></td>
                                                <td class="text-center">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inst->status === 'paid'): ?>
                                                        <span class="badge bg-success">Paid</span>
                                                    <?php elseif($inst->status === 'partially_paid'): ?>
                                                        <span class="badge bg-info text-dark">Partially Paid</span>
                                                    <?php else: ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inst->due_date && $inst->due_date->isPast()): ?>
                                                            <span class="badge bg-danger">Overdue</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inst->status !== 'paid'): ?>
                                                        <button type="button" 
                                                                class="btn btn-xs btn-outline-success record-payment-btn" 
                                                                data-id="<?php echo e($inst->id); ?>" 
                                                                data-inst="<?php echo e($inst->installment_number); ?>" 
                                                                data-due="<?php echo e($inst->due_date ? $inst->due_date->format('d M, Y') : '-'); ?>" 
                                                                data-amount="<?php echo e($inst->amount); ?>" 
                                                                data-paid="<?php echo e($inst->paid_amount); ?>" 
                                                                data-currency="<?php echo e($application->course->currency ?? 'GBP'); ?>"
                                                                data-bs-toggle="tooltip" 
                                                                title="Record Payment">
                                                            <i class="fas fa-coins"></i>
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-success"><i class="fas fa-check-circle"></i></span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Fees Summary -->
                        <div class="col-lg-4">
                            <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 0.5px;"><i class="fas fa-receipt text-primary me-2"></i> Fees Summary</h6>
                            <div class="p-3 border rounded bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                    <span class="text-dark fw-bold">Grand Total Fee</span>
                                    <span class="text-primary fw-bold fs-5"><?php echo e(number_format($application->total_fee, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 font-13">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" class="form-check-input fee-summary-checkbox" value="base_fee" onchange="updateSelectedCount()" title="Include Base Course Fee in invoice">
                                        <span class="text-muted">Base Course Fee</span>
                                    </div>
                                    <span class="fw-semibold text-dark"><?php echo e(number_format($application->course->fee, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($application->scholarship_amount ?? 0) > 0): ?>
                                <div class="d-flex justify-content-between align-items-center mb-1 font-13">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" class="form-check-input fee-summary-checkbox" value="scholarship" onchange="updateSelectedCount()" title="Include Scholarship in invoice">
                                        <span class="text-success"><i class="fas fa-gift me-1"></i> Scholarship</span>
                                    </div>
                                    <span class="fw-bold text-success">-<?php echo e(number_format($application->scholarship_amount, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1 font-13">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" class="form-check-input fee-summary-checkbox" value="net_course_fee" onchange="updateSelectedCount()" title="Include Net Course Fee in invoice">
                                        <span class="text-muted">Course Fee</span>
                                    </div>
                                    <span class="fw-semibold text-primary"><?php echo e(number_format($application->net_course_fee ?? ($application->course->fee - $application->scholarship_amount), 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="d-flex justify-content-between mb-2 font-13">
                                    <span class="text-muted">Additional Costs Total</span>
                                    <span class="fw-semibold text-dark"><?php echo e(number_format($application->additionalCosts->sum('amount'), 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between mb-1 font-13">
                                    <span class="text-muted">Total Paid</span>
                                    <span class="fw-semibold text-success"><?php echo e(number_format($application->paid_amount, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                                <div class="d-flex justify-content-between font-13">
                                    <span class="text-muted">Balance Due</span>
                                    <span class="fw-semibold text-danger"><?php echo e(number_format(max(0, $application->total_fee - $application->paid_amount), 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Costs Row (Outside Installments) -->
                    <div class="row g-4 pt-3 border-top mt-2">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="text-muted text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-tags text-primary me-2"></i> Additional Costs (One-time Full Payments)
                                </h6>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAssignCourse): ?>
                                    <a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>" class="btn btn-xs btn-outline-primary">
                                        <i class="fas fa-plus me-1"></i> Add / Edit Additional Costs
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->additionalCosts->count() > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 0.85rem;">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:36px;"><input type="checkbox" id="selectAllCosts" class="form-check-input" title="Select All Additional Costs"></th>
                                                <th>Cost Item / Description</th>
                                                <th class="text-end">Amount</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $application->additionalCosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                <tr>
                                                    <td><input type="checkbox" class="form-check-input cost-checkbox" value="<?php echo e($cost->id); ?>" onchange="updateSelectedCount()"></td>
                                                    <td class="fw-semibold text-dark">
                                                        <i class="fas fa-tag text-secondary me-2"></i> <?php echo e($cost->cost_name); ?>

                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cost->is_invoiced): ?>
                                                            <span class="badge bg-info ms-1" title="Invoiced on <?php echo e($cost->invoiced_at?->format('d M Y H:i')); ?>"><i class="fas fa-file-invoice me-1"></i>Invoiced</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="text-end fw-bold text-primary"><?php echo e(number_format($cost->amount, 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></td>
                                                    <td class="text-center">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cost->status === 'paid'): ?>
                                                            <span class="badge bg-success">Paid</span>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cost->paid_at): ?>
                                                                <small class="d-block text-muted" style="font-size: 10px;"><?php echo e($cost->paid_at->format('d M, Y')); ?></small>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        <?php else: ?>
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cost->status !== 'paid'): ?>
                                                            <button type="button" 
                                                                    class="btn btn-xs btn-outline-success record-cost-payment-btn" 
                                                                    data-id="<?php echo e($cost->id); ?>" 
                                                                    data-name="<?php echo e($cost->cost_name); ?>" 
                                                                    data-amount="<?php echo e($cost->amount); ?>" 
                                                                    data-currency="<?php echo e($application->course->currency ?? 'GBP'); ?>"
                                                                    data-bs-toggle="tooltip" 
                                                                    title="Record Full Payment">
                                                                <i class="fas fa-coins me-1"></i> Record Payment
                                                            </button>
                                                        <?php else: ?>
                                                            <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <th class="text-end">Total Additional Costs:</th>
                                                <th class="text-end text-primary fw-bold"><?php echo e(number_format($application->additionalCosts->sum('amount'), 2)); ?> <?php echo e($application->course->currency ?? 'GBP'); ?></th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-light border py-2 px-3 small text-muted mb-0">
                                    <i class="fas fa-info-circle me-1"></i> No additional costs assigned for this enrolment. Click <strong><a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>">Manage Enrolment & Fees</a></strong> to add items.
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Personal Info -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-user-circle"></i> Personal Information</div>
                <div class="info-grid">
                    <div class="info-item"><label>First Name</label><span><?php echo e($student->first_name ?? $preAssessment->first_name); ?></span></div>
                    <div class="info-item"><label>Middle Name</label><span><?php echo e($student->middle_name ?? $preAssessment->middle_name ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Last Name (Surname)</label><span><?php echo e($student->surname ?? $preAssessment->surname); ?></span></div>
                    <div class="info-item">
                        <label>Preferred Institute</label>
                        <span>
                            <span class="badge bg-primary">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->institute): ?>
                                    <?php echo e($student->institute->name); ?>

                                <?php elseif($preAssessment->institute_name): ?>
                                    <?php echo e($preAssessment->institute_name); ?>

                                <?php else: ?>
                                    N/A
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <span>
                            <?php
                                $dobVal = $student->dob ?? $preAssessment->dob;
                            ?>
                            <?php echo e($dobVal ? ($dobVal instanceof \DateTimeInterface ? $dobVal->format('d M Y') : date('d M Y', strtotime($dobVal))) : 'N/A'); ?>

                        </span>
                    </div>
                    <div class="info-item"><label>Gender</label><span><?php echo e($student->gender ?? $preAssessment->gender ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Country of Nationality</label><span><?php echo e($student->nationality ?? $preAssessment->nationality ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Country of Birth</label><span><?php echo e($student->country_of_birth ?? $preAssessment->country ?? 'N/A'); ?></span></div>
                    <div class="info-item">
                        <label>Country of Residence</label>
                        <span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->country): ?>
                                <?php echo e($student->country->name); ?>

                            <?php elseif($preAssessment->country): ?>
                                <?php echo e($preAssessment->country); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item"><label>Phone</label><span><?php echo e($student->phone ?? $preAssessment->contact_number ?? 'N/A'); ?></span></div>
                    <div class="info-item">
                        <label>WhatsApp Status</label>
                        <span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->has_whatsapp): ?>
                                <span class="badge bg-success"><i class="fab fa-whatsapp me-1"></i> Available on <?php echo e($student->phone); ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Not Marked</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Address Info -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-map-marker-alt"></i> Contact & Address</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Permanent Address</h6>
                        <div class="info-grid" style="grid-template-columns: 1fr;">
                            <div class="info-item"><label>Address</label><span><?php echo e($student->permanent_address ?? $preAssessment->contact_address ?? 'N/A'); ?></span></div>
                            <div class="info-item">
                                <label>City & Postcode</label>
                                <span>
                                    <?php
                                        $permAddr = trim(($student->permanent_city ?? '').' '.($student->permanent_postcode ?? ''));
                                        $preAddr = implode(', ', array_filter([$preAssessment->city, $preAssessment->state, $preAssessment->postal_code]));
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($permAddr !== ''): ?>
                                        <?php echo e($permAddr); ?>

                                    <?php elseif($preAddr !== ''): ?>
                                        <?php echo e($preAddr); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                            <div class="info-item"><label>Country</label><span><?php echo e($student->permanent_country ?? $preAssessment->country ?? 'N/A'); ?></span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Current Address</h6>
                        <div class="info-grid" style="grid-template-columns: 1fr;">
                            <div class="info-item"><label>Address</label><span><?php echo e($student->current_address ?? $preAssessment->contact_address ?? 'N/A'); ?></span></div>
                            <div class="info-item">
                                <label>City & Postcode</label>
                                <span>
                                    <?php
                                        $currAddr = trim(($student->current_city ?? '').' '.($student->current_postcode ?? ''));
                                        $preAddr = implode(', ', array_filter([$preAssessment->city, $preAssessment->state, $preAssessment->postal_code]));
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currAddr !== ''): ?>
                                        <?php echo e($currAddr); ?>

                                    <?php elseif($preAddr !== ''): ?>
                                        <?php echo e($preAddr); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                            <div class="info-item"><label>Country</label><span><?php echo e($student->current_country ?? $preAssessment->country ?? 'N/A'); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passport & Travel Info -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-passport"></i> Passport & Travel History</div>
                <div class="info-grid mb-4">
                    <div class="info-item"><label>Name in Passport</label><span><?php echo e($student->name_in_passport ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Passport Number</label><span><?php echo e($student->passport_number ?? $preAssessment->passport_number ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Issue Date</label><span><?php echo e($student->passport_issue_date ? $student->passport_issue_date->format('d M Y') : 'N/A'); ?></span></div>
                    <div class="info-item"><label>Expiry Date</label><span><?php echo e($student->passport_expiry_date ? $student->passport_expiry_date->format('d M Y') : 'N/A'); ?></span></div>
                    <div class="info-item"><label>Issue Location</label><span><?php echo e($student->passport_issue_location ?? 'N/A'); ?></span></div>
                </div>
                
                <?php
                    $travelHistory = $student->travel_history ?? $preAssessment->travel_history ?? [];
                    $immigrationHistory = $student->immigration_history ?? $preAssessment->immigration_history ?? [];
                    $visaRefusals = $student->visa_refusals ?? $preAssessment->visa_refusals ?? [];
                    $takenTbTest = $student->taken_tb_test ?? 'N/A';
                ?>
                <h6 class="text-muted text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">Travel & Immigration History</h6>
                <div class="row g-3">
                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Permission to remain in past 10 years:</strong> 
                            <span class="badge <?php echo e(($travelHistory['has_history'] ?? '') === 'yes' ? 'bg-primary' : 'bg-secondary'); ?>">
                                <?php echo e(strtoupper($travelHistory['has_history'] ?? 'No')); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($travelHistory['has_history'] ?? '') === 'yes'): ?>
                                <?php
                                    $tEntries = $travelHistory['entries'] ?? [];
                                    if (empty($tEntries) && (!empty($travelHistory['country']) || !empty($travelHistory['arrival_date']))) {
                                        $tEntries = [$travelHistory];
                                    }
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $tEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="mt-2 ps-3 border-start border-3 border-primary mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($tEntries) > 1): ?><div class="fw-bold text-primary mb-1 font-12">Travel Entry #<?php echo e($idx + 1); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="row g-2">
                                            <div class="col-md-6"><strong>Country:</strong> <?php echo e($tEntry['country'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Visa Type:</strong> <?php echo e($tEntry['visa_type'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Purpose:</strong> <?php echo e($tEntry['purpose_of_visit'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Arrival Date:</strong> <?php echo e($tEntry['arrival_date'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Departure Date:</strong> <?php echo e($tEntry['departure_date'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Visa Validity:</strong> <?php echo e($tEntry['visa_start_date'] ?? 'N/A'); ?> to <?php echo e($tEntry['visa_expiry_date'] ?? 'N/A'); ?></div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Needs visa for:</strong> 
                            <?php
                                $immCountries = $immigrationHistory['countries'] ?? [];
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($immCountries) || in_array('None', $immCountries)): ?>
                                <span class="badge bg-secondary">None</span>
                            <?php else: ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $immCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <span class="badge bg-success me-1"><?php echo e($country); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Refused visa/asylum/deported:</strong> 
                            <span class="badge <?php echo e(($visaRefusals['has_refusal'] ?? '') === 'yes' ? 'bg-danger' : 'bg-secondary'); ?>">
                                <?php echo e(strtoupper($visaRefusals['has_refusal'] ?? 'No')); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($visaRefusals['has_refusal'] ?? '') === 'yes'): ?>
                                <?php
                                    $rEntries = $visaRefusals['entries'] ?? [];
                                    if (empty($rEntries) && (!empty($visaRefusals['country']) || !empty($visaRefusals['refusal_type']))) {
                                        $rEntries = [$visaRefusals];
                                    }
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $rEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="mt-2 ps-3 border-start border-3 border-danger mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($rEntries) > 1): ?><div class="fw-bold text-danger mb-1 font-12">Refusal Entry #<?php echo e($idx + 1); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="row g-2">
                                            <div class="col-md-6"><strong>Country:</strong> <?php echo e($rEntry['country'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Visa Type:</strong> <?php echo e($rEntry['visa_type'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Refusal Type:</strong> <?php echo e($rEntry['refusal_type'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Date of Refusal:</strong> <?php echo e($rEntry['refusal_date'] ?? 'N/A'); ?></div>
                                            <div class="col-md-12"><strong>Details/Reason:</strong> <?php echo e($rEntry['details'] ?? 'N/A'); ?></div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>TB Test Details:</strong> <?php echo e($takenTbTest); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Academics -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-graduation-cap"></i> Academic History</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($academics->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm table-custom mb-0 border">
                        <thead>
                            <tr>
                                <th>Education Level</th>
                                <th>Institution</th>
                                <th>Course</th>
                                <th>Start - End Date</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $academics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($aca->education_level); ?></td>
                                <td>
                                    <?php echo e($aca->institution_name); ?><br>
                                    <small class="text-muted">
                                        <?php echo e(array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country]) ? implode(', ', array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country])) : 'N/A'); ?>

                                    </small>
                                </td>
                                <td><?php echo e($aca->course_name); ?></td>
                                <td><?php echo e($aca->start_date ? $aca->start_date->format('M Y') : 'N/A'); ?> to <?php echo e($aca->end_date ? $aca->end_date->format('M Y') : 'N/A'); ?></td>
                                <td>
                                    <span class="badge bg-success">
                                        <?php echo e($aca->result_type == 'Others' ? $aca->other_result_type : $aca->result_type); ?>: <?php echo e($aca->result_percentage); ?><?php echo e($aca->result_out_of ? ' / ' . $aca->result_out_of : ''); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No academic history provided.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- English Test -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-language"></i> English Language Proficiency</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($englishTests->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-sm table-custom mb-0 border">
                        <thead>
                            <tr>
                                <th>Test Type</th>
                                <th>Test Date</th>
                                <th>Overall Score</th>
                                <th>Scores (L, R, W, S)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $englishTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($test->test_type); ?></td>
                                <td><?php echo e($test->test_date); ?></td>
                                <td><span class="badge bg-primary fs--1"><?php echo e($test->overall_score); ?></span></td>
                                <td>L: <?php echo e($test->listening_score); ?>, R: <?php echo e($test->reading_score); ?>, W: <?php echo e($test->writing_score); ?>, S: <?php echo e($test->speaking_score); ?></td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No English tests recorded.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Referees -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-users"></i> References</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referees->count() > 0): ?>
                <div class="row g-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $referees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="col-md-6">
                        <div class="card shadow-none border h-100">
                            <div class="card-body p-3">
                                <h6 class="mb-1"><?php echo e($ref->name); ?> <small class="text-muted fw-normal">(<?php echo e($ref->type); ?>)</small></h6>
                                <p class="mb-1 small"><i class="fas fa-briefcase text-muted me-1"></i> <?php echo e($ref->designation); ?>, <?php echo e($ref->company_name); ?></p>
                                <p class="mb-1 small"><i class="fas fa-envelope text-muted me-1"></i> <?php echo e($ref->email); ?></p>
                                <p class="mb-0 small"><i class="fas fa-phone text-muted me-1"></i> <?php echo e($ref->phone); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No referees provided.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <!-- Student Uploaded Documents -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-file-upload text-success"></i> Student Uploaded Documents</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($documents) && $documents->count() > 0): ?>
                <div class="row g-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded border shadow-sm h-100">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-pdf text-danger fs-4"></i>
                                <div>
                                    <div class="fw-bold text-dark small"><?php echo e($doc->document_type); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc->title): ?>
                                        <div class="text-muted small" style="font-size: 11px;"><?php echo e($doc->title); ?></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="text-muted" style="font-size: 10px;">Uploaded: <?php echo e($doc->created_at->format('d M, Y')); ?></div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(Storage::url($doc->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                <a href="<?php echo e(Storage::url($doc->file_path)); ?>" download class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fas fa-download me-1"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No documents uploaded by the student yet.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Generated Letters History Section -->
            <div class="info-section">
                <div class="info-section-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history text-primary me-2"></i> Generated Letters History</span>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#generateLetterModal">
                        <i class="fas fa-plus me-1"></i> Generate New Letter
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($letterHistory) && $letterHistory->count() > 0): ?>
                <div class="table-responsive mt-2">
                    <table class="table table-hover table-striped align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Letter Title</th>
                                <th>Type</th>
                                <th>Generated By</th>
                                <th>Date & Time</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $letterHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($idx + 1); ?></td>
                                <td><strong><?php echo e($item->letter_title); ?></strong></td>
                                <td><span class="badge bg-secondary text-uppercase"><?php echo e($item->file_type); ?></span></td>
                                <td><?php echo e($item->generator->name ?? 'System Admin'); ?></td>
                                <td><?php echo e($item->created_at->format('d M, Y h:i A')); ?></td>
                                <td class="text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->sent_to_student): ?>
                                        <span class="badge bg-success rounded-pill"><i class="fas fa-check me-1"></i> Sent</span>
                                        <div class="text-muted" style="font-size:10px;"><?php echo e($item->sent_at?->format('d M, Y')); ?></div>
                                    <?php else: ?>
                                        <span class="badge bg-light text-secondary border">Not Sent</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.students.letters.preview', $item->id)); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Preview Letter">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </a>
                                    <a href="<?php echo e(route('admin.students.letters.download', $item->id)); ?>" class="btn btn-sm btn-outline-success" title="Download Letter">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$item->sent_to_student): ?>
                                    <form action="<?php echo e(route('admin.students.letters.send', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-success" title="Send to Student">
                                            <i class="fas fa-paper-plane me-1"></i> Send
                                        </button>
                                    </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <form action="<?php echo e(route('admin.students.letters.delete', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn-confirm" data-text="You want to delete this generated letter history!" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0 py-2">No letters generated yet for this student.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Course Enrolment & Fee Installments Section -->
            <?php
                $canAssignCourse = ($student->preAssessment && $student->preAssessment->assessment_status === 'approved' && $student->enrolment_status !== 'pending');
            ?>
            <div class="info-section mt-4">
                <div class="info-section-title d-flex justify-content-between align-items-center mb-3">
                    <span><i class="fas fa-file-invoice-dollar text-primary me-2"></i> Course Enrolment & Fee Installments</span>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAssignCourse): ?>
                        <a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            <i class="fas fa-edit me-1"></i> Manage Enrolment & Fees
                        </a>
                    <?php else: ?>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled title="Approve Pre-Enrolment first to assign course">
                            <i class="fas fa-lock me-1"></i> Manage Enrolment & Fees (Pending Approval)
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($application) && $application->course): ?>
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 11px;">Assigned Course</small>
                            <span class="fw-bold text-dark fs-6"><?php echo e($application->course->name); ?></span>
                            <small class="d-block text-muted">[<?php echo e($application->course->course_code); ?>]</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 11px;">Total Fee Calculation</small>
                            <span class="fw-bold text-primary fs-6"><?php echo e($application->course->currency ?? 'GBP'); ?> <?php echo e(number_format($application->total_fee, 2)); ?></span>
                            <small class="d-block text-muted">Base: <?php echo e(number_format($application->course->fee, 2)); ?> | Additional: <?php echo e(number_format($application->additionalCosts->sum('amount'), 2)); ?></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-light rounded border">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 11px;">Payment Progress</small>
                            <span class="fw-bold text-success fs-6">Paid: <?php echo e($application->course->currency ?? 'GBP'); ?> <?php echo e(number_format($application->paid_amount, 2)); ?></span>
                            <?php $remainingDue = max(0, $application->total_fee - $application->paid_amount); ?>
                            <small class="d-block text-danger fw-bold">Due: <?php echo e($application->course->currency ?? 'GBP'); ?> <?php echo e(number_format($remainingDue, 2)); ?></small>
                        </div>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->installments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Installment</th>
                                <th>Due Date</th>
                                <th>Scheduled Amount</th>
                                <th>Paid Amount</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $application->installments->sortBy('installment_number'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td>
                                    <strong class="text-dark">
                                        <?php echo e($inst->installment_number == 1 ? '1st Installment' : ('Installment #' . $inst->installment_number)); ?>

                                    </strong>
                                </td>
                                <td><?php echo e($inst->due_date ? $inst->due_date->format('d M, Y') : 'N/A'); ?></td>
                                <td class="fw-bold"><?php echo e($application->course->currency ?? 'GBP'); ?> <?php echo e(number_format($inst->amount, 2)); ?></td>
                                <td class="text-success fw-bold"><?php echo e($application->course->currency ?? 'GBP'); ?> <?php echo e(number_format($inst->paid_amount, 2)); ?></td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inst->status === 'paid'): ?>
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                    <?php elseif($inst->status === 'partially_paid'): ?>
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Partially Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="fas fa-exclamation-circle me-1"></i> Due</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inst->status !== 'paid'): ?>
                                    <button type="button" class="btn btn-xs btn-outline-success record-payment-btn me-1"
                                            data-id="<?php echo e($inst->id); ?>"
                                            data-inst="<?php echo e($inst->installment_number); ?>"
                                            data-due="<?php echo e($inst->due_date ? $inst->due_date->format('d M, Y') : 'N/A'); ?>"
                                            data-amount="<?php echo e($inst->amount); ?>"
                                            data-paid="<?php echo e($inst->paid_amount); ?>"
                                            data-currency="<?php echo e($application->course->currency ?? 'GBP'); ?>">
                                        <i class="fas fa-hand-holding-usd me-1"></i> Record Payment
                                    </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <button type="button" class="btn btn-xs btn-primary" onclick="openInvoiceModalForInstallment(<?php echo e($inst->id); ?>)">
                                        <i class="fas fa-file-invoice me-1"></i> Generate Invoice / Receipt
                                    </button>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php else: ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($canAssignCourse): ?>
                        <div class="alert alert-info mb-0 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fas fa-info-circle me-2"></i> No course or fee schedule has been assigned to this student yet.
                            </div>
                            <a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i> Assign Course & Fee
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0 d-flex align-items-center justify-content-between">
                            <div>
                                <i class="fas fa-exclamation-triangle me-2"></i> Pre-Enrolment / Pre-Assessment is currently <strong>Pending</strong>. Course & fees can only be assigned after approving the Pre-Enrolment.
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->enrolment_status === 'pending'): ?>
                                <button type="button" class="btn btn-sm btn-success btn-approve-enrol" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>">
                                    <i class="fas fa-check me-1"></i> Approve Pre-Enrolment
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Generated Invoices History Section -->
            <div class="info-section mt-4">
                <div class="info-section-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history text-success me-2"></i> Generated Invoices History</span>
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal">
                        <i class="fas fa-plus me-1"></i> Generate New Invoice
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($invoiceHistory) && $invoiceHistory->count() > 0): ?>
                <div class="table-responsive mt-2">
                    <table class="table table-hover table-striped align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Invoice Title</th>
                                <th>Type</th>
                                <th>Generated By</th>
                                <th>Date & Time</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $invoiceHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($idx + 1); ?></td>
                                <td><strong><?php echo e($item->invoice_title); ?></strong></td>
                                <td><span class="badge bg-secondary text-uppercase"><?php echo e($item->file_type); ?></span></td>
                                <td><?php echo e($item->generator->name ?? 'System Admin'); ?></td>
                                <td><?php echo e($item->created_at->format('d M, Y h:i A')); ?></td>
                                <td class="text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->sent_to_student): ?>
                                        <span class="badge bg-success rounded-pill"><i class="fas fa-check me-1"></i> Sent</span>
                                        <div class="text-muted" style="font-size:10px;"><?php echo e($item->sent_at?->format('d M, Y')); ?></div>
                                    <?php else: ?>
                                        <span class="badge bg-light text-secondary border">Not Sent</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('admin.students.invoices.preview', $item->id)); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Preview Invoice">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </a>
                                    <a href="<?php echo e(route('admin.students.invoices.download', $item->id)); ?>" class="btn btn-sm btn-outline-success" title="Download Invoice">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$item->sent_to_student): ?>
                                    <form action="<?php echo e(route('admin.students.invoices.send', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-success" title="Send to Student">
                                            <i class="fas fa-paper-plane me-1"></i> Send
                                        </button>
                                    </form>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <form action="<?php echo e(route('admin.students.invoices.delete', $item->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn-confirm" data-text="You want to delete this generated invoice history!" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0 py-2">No invoices generated yet for this student.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- ==================== Generate Letter Modal ==================== -->
<div class="modal fade" id="generateLetterModal" tabindex="-1" aria-labelledby="generateLetterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form action="<?php echo e(route('admin.students.letters.generate', $student->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="letter_action" id="letter_action_input" value="download">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fw-bold text-white" id="generateLetterModalLabel">
                <i class="fas fa-envelope-open-text me-2"></i> Generate Letter for <?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>

            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4">
             <!-- Mode Switch -->
             <div class="card bg-light border-0 mb-4 p-3">
                 <label class="form-label fw-bold me-3">Choose Generation Method:</label>
                 <div class="d-flex gap-4">
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="generation_type" id="gen_type_template" value="template" checked onclick="toggleGenMode('template')">
                         <label class="form-check-label fw-semibold" for="gen_type_template">
                            <i class="fas fa-list-alt text-primary me-1"></i> Select Built-in Template
                         </label>
                     </div>
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="generation_type" id="gen_type_file" value="file_upload" onclick="toggleGenMode('file')">
                         <label class="form-check-label fw-semibold" for="gen_type_file">
                            <i class="fas fa-cloud-upload-alt text-success me-1"></i> Upload File (DOCX / PDF / Image)
                         </label>
                     </div>
                 </div>
             </div>

             <!-- Template Block -->
             <div id="block_template">
                 <div class="mb-3">
                     <label class="form-label fw-bold">Select Template <span class="text-danger">*</span></label>
                     <select name="letter_template_id" id="modal_template_id" class="form-select form-select-lg" onchange="fetchTemplatePreview(this.value)">
                         <option value="">-- Choose a Letter Template --</option>
                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($letterTemplates)): ?>
                             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $letterTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tpl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                 <option value="<?php echo e($tpl->id); ?>"><?php echo e($tpl->title); ?> (<?php echo e(strtoupper($tpl->type)); ?>)</option>
                             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                         <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                     </select>
                 </div>

                 <!-- Live Preview Box -->
                 <div id="preview_container" class="d-none">
                     <div class="d-flex justify-content-between align-items-center mb-2">
                         <label class="form-label fw-bold text-success mb-0"><i class="fas fa-eye me-1"></i> Live Preview (Editable before generating):</label>
                         <span class="badge bg-success bg-opacity-10 text-success small">Auto-filled with student data</span>
                     </div>
                     <div class="border rounded shadow-sm bg-white">
                         <textarea name="custom_content" id="modal_custom_content" class="form-control"></textarea>
                     </div>
                 </div>
             </div>

             <!-- File Upload Block -->
             <div id="block_file" class="d-none">
                 <div class="mb-3">
                     <label class="form-label fw-bold">Upload Custom Letter File (.docx, .pdf, .jpg, .png)</label>
                     <input type="file" name="uploaded_file" class="form-control form-control-lg" accept=".docx,.pdf,.jpg,.jpeg,.png">
                     <div class="form-text mt-2">
                        <i class="fas fa-info-circle text-info"></i> For <strong>Microsoft Word (.docx)</strong> templates, include placeholders such as <code>${student_name}</code>, <code>${passport_number}</code>, <code>${today_date}</code> inside your doc file to auto-populate student data.
                     </div>
                 </div>
             </div>

          </div>

          <div class="modal-footer bg-light d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Close
            </button>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary rounded-pill px-4" onclick="document.getElementById('letter_action_input').value='download'">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4" onclick="document.getElementById('letter_action_input').value='send'">
                    <i class="fas fa-paper-plane me-1"></i> Send to Student
                </button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- Floating Sticky Bar for Invoice Generation -->
<div id="floatingInvoiceBar" class="position-fixed bottom-0 start-50 translate-middle-x mb-4 shadow-lg p-3 bg-dark text-white rounded-pill d-none" style="z-index: 1050; border: 2px solid #28a745; transition: all 0.3s ease;">
    <div class="d-flex align-items-center gap-3 px-2">
        <span><i class="fas fa-check-circle text-success fs-5"></i> <strong><span id="floatingSelectedItemCount">0</span> item(s) selected</strong> for invoice</span>
        <button type="button" class="btn btn-success rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal" onclick="prepareInvoiceModal()">
            <i class="fas fa-magic me-1"></i> Make Invoice Now
        </button>
        <button type="button" class="btn btn-sm btn-outline-light rounded-circle" title="Clear selection" onclick="clearAllInvoiceSelections()">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- ==================== Generate Invoice Modal ==================== -->
<div class="modal fade" id="generateInvoiceModal" tabindex="-1" aria-labelledby="generateInvoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form action="<?php echo e(route('admin.students.invoices.generate', $student->id)); ?>" method="POST" enctype="multipart/form-data" id="generateInvoiceForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="invoice_action" id="invoice_action_input" value="download">
        <input type="hidden" name="generation_type" id="generation_type_input" value="template">
        <div id="hidden_installment_ids_container"></div>
        <div id="hidden_cost_ids_container"></div>
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-success text-white py-3">
            <h5 class="modal-title fw-bold text-white mb-0" id="generateInvoiceModalLabel">
                <i class="fas fa-file-invoice-dollar me-2"></i> Make Invoice for <?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>

            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4">
             <!-- Selected Items Summary Banner -->
             <div id="selectedItemsIndicator" class="d-none alert alert-success border-0 py-3 px-3 mb-3 rounded-3 shadow-sm">
                 <div class="d-flex align-items-center">
                     <i class="fas fa-check-circle me-2 fs-5 text-success"></i>
                     <div>
                         <strong class="text-success"><span id="selectedItemsCount">0</span> Fee Item(s) Selected:</strong>
                         <span id="selectedItemsDesc" class="ms-1 text-dark fw-semibold"></span>
                     </div>
                 </div>
             </div>

             <!-- Template Choice (Primary Flow) -->
             <div class="mb-4">
                 <label class="form-label fw-bold fs-6 text-dark mb-1"><i class="fas fa-file-alt text-primary me-1"></i> Step 1: Choose Invoice Template <span class="text-danger">*</span></label>
                 <select name="invoice_template_id" id="modal_invoice_template_id" class="form-select form-select-lg border-primary shadow-sm" onchange="fetchInvoiceTemplatePreview(this.value)" required>
                      <option value="">-- Click to Select Invoice Template --</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($invoiceTemplates)): ?>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $invoiceTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tpl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                              <option value="<?php echo e($tpl->id); ?>"><?php echo e($tpl->title); ?> (<?php echo e(strtoupper($tpl->type)); ?>)</option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                 </select>
                 <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Selecting a template will automatically build the invoice with student details and selected items.</small>
             </div>

             <!-- Live Preview Box -->
             <div id="inv_preview_container" class="d-none mb-3">
                 <div class="d-flex justify-content-between align-items-center mb-2">
                      <label class="form-label fw-bold text-success mb-0"><i class="fas fa-eye me-1"></i> Step 2: Live Invoice Preview (Editable if needed):</label>
                      <span class="badge bg-success bg-opacity-10 text-success px-2 py-1"><i class="fas fa-magic me-1"></i> Auto-populated</span>
                 </div>
                 <div class="border rounded-3 shadow-sm bg-white p-1">
                      <textarea name="custom_content" id="modal_invoice_custom_content" class="form-control"></textarea>
                 </div>
             </div>

             <!-- Optional File Upload Toggle -->
             <div class="border-top pt-3 mt-3">
                 <a class="text-muted small text-decoration-none" data-bs-toggle="collapse" href="#inv_file_upload_collapse" role="button" aria-expanded="false">
                     <i class="fas fa-paperclip me-1"></i> Need to upload a custom DOCX/PDF file instead? Click here
                 </a>
                 <div class="collapse mt-2" id="inv_file_upload_collapse">
                     <div class="card card-body bg-light border-0">
                         <label class="form-label fw-bold">Upload Custom File (.docx, .pdf, .jpg, .png)</label>
                         <input type="file" name="uploaded_file" class="form-control" accept=".docx,.pdf,.jpg,.jpeg,.png" onchange="document.getElementById('generation_type_input').value = this.value ? 'file_upload' : 'template'">
                     </div>
                 </div>
             </div>

          </div>

          <div class="modal-footer bg-light py-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Cancel
            </button>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-outline-success rounded-pill px-4 fw-semibold" onclick="document.getElementById('invoice_action_input').value='download'">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" onclick="document.getElementById('invoice_action_input').value='send'">
                    <i class="fas fa-paper-plane me-1"></i> Send to Student
                </button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<script>
function toggleGenMode(mode) {
    if (mode === 'template') {
        document.getElementById('block_template').classList.remove('d-none');
        document.getElementById('block_file').classList.add('d-none');
    } else {
        document.getElementById('block_template').classList.add('d-none');
        document.getElementById('block_file').classList.remove('d-none');
    }
}

function fetchTemplatePreview(templateId) {
    if (!templateId) {
        document.getElementById('preview_container').classList.add('d-none');
        return;
    }

    const url = "<?php echo e(route('admin.students.letters.preview_modal', $student->id)); ?>?template_id=" + templateId;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('preview_container').classList.remove('d-none');
                // Set content into Summernote editor
                $('#modal_custom_content').summernote('code', data.content);
            }
        })
        .catch(err => console.error('Error fetching preview:', err));
}

function toggleInvGenMode(mode) {
    if (mode === 'template') {
        document.getElementById('inv_block_template').classList.remove('d-none');
        document.getElementById('inv_block_file').classList.add('d-none');
    } else {
        document.getElementById('inv_block_template').classList.add('d-none');
        document.getElementById('inv_block_file').classList.remove('d-none');
    }
}

// ---- Checkbox / Selected Items Logic ----
function updateSelectedCount() {
    const installmentBoxes = document.querySelectorAll('.installment-checkbox:checked');
    const costBoxes        = document.querySelectorAll('.cost-checkbox:checked');
    const summaryBoxes     = document.querySelectorAll('.fee-summary-checkbox:checked');
    const total = installmentBoxes.length + costBoxes.length + summaryBoxes.length;

    if (document.getElementById('selectedItemCount')) {
        document.getElementById('selectedItemCount').textContent = total;
    }
    if (document.getElementById('floatingSelectedItemCount')) {
        document.getElementById('floatingSelectedItemCount').textContent = total;
    }

    const btn = document.getElementById('generateInvoiceSelectedBtn');
    const floatBar = document.getElementById('floatingInvoiceBar');

    if (total > 0) {
        if (btn) btn.classList.remove('d-none');
        if (floatBar) floatBar.classList.remove('d-none');
    } else {
        if (btn) btn.classList.add('d-none');
        if (floatBar) floatBar.classList.add('d-none');
    }
}

function clearAllInvoiceSelections() {
    document.querySelectorAll('.installment-checkbox, .cost-checkbox, .fee-summary-checkbox, #selectAllInstallments, #selectAllCosts').forEach(cb => cb.checked = false);
    updateSelectedCount();
}

function prepareInvoiceModal() {
    const installmentBoxes = document.querySelectorAll('.installment-checkbox:checked');
    const costBoxes        = document.querySelectorAll('.cost-checkbox:checked');
    const summaryBoxes     = document.querySelectorAll('.fee-summary-checkbox:checked');

    // Clear existing hidden inputs
    document.getElementById('hidden_installment_ids_container').innerHTML = '';
    document.getElementById('hidden_cost_ids_container').innerHTML = '';

    let installmentDescParts = [];
    installmentBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'installment_ids[]';
        input.value = cb.value;
        document.getElementById('hidden_installment_ids_container').appendChild(input);
        const row = cb.closest('tr');
        if (row) {
            const label = row.querySelector('td:nth-child(2)');
            if (label) installmentDescParts.push(label.textContent.trim().replace(/\s+/g, ' ').split('\n')[0]);
        }
    });

    let costDescParts = [];
    costBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'additional_cost_ids[]';
        input.value = cb.value;
        document.getElementById('hidden_cost_ids_container').appendChild(input);
        const row = cb.closest('tr');
        if (row) {
            const label = row.querySelector('td:nth-child(2)');
            if (label) costDescParts.push(label.textContent.trim().replace(/\s+/g, ' ').split('\n')[0]);
        }
    });

    let summaryDescParts = [];
    summaryBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'fee_summary_items[]';
        input.value = cb.value;
        document.getElementById('hidden_cost_ids_container').appendChild(input);
        const titleMap = {
            'base_fee': 'Base Course Fee',
            'scholarship': 'Scholarship',
            'net_course_fee': 'Course Fee'
        };
        if (titleMap[cb.value]) summaryDescParts.push(titleMap[cb.value]);
    });

    const total = installmentBoxes.length + costBoxes.length + summaryBoxes.length;
    const indicator = document.getElementById('selectedItemsIndicator');
    const descEl    = document.getElementById('selectedItemsDesc');
    document.getElementById('selectedItemsCount').textContent = total;
    const allDesc = [...installmentDescParts, ...costDescParts, ...summaryDescParts].join(', ');
    descEl.textContent = allDesc ? '(' + allDesc + ')' : '';

    if (total > 0) {
        indicator.classList.remove('d-none');
    } else {
        indicator.classList.add('d-none');
    }
}

// Select All Installments
const selectAllInstallments = document.getElementById('selectAllInstallments');
if (selectAllInstallments) {
    selectAllInstallments.addEventListener('change', function() {
        document.querySelectorAll('.installment-checkbox').forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });
}

// Select All Costs
const selectAllCosts = document.getElementById('selectAllCosts');
if (selectAllCosts) {
    selectAllCosts.addEventListener('change', function() {
        document.querySelectorAll('.cost-checkbox').forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });
}

function fetchInvoiceTemplatePreview(templateId) {
    if (!templateId) {
        document.getElementById('inv_preview_container').classList.add('d-none');
        return;
    }

    let params = new URLSearchParams();
    params.append('template_id', templateId);

    document.querySelectorAll('.installment-checkbox:checked').forEach(cb => {
        params.append('installment_ids[]', cb.value);
    });

    document.querySelectorAll('.cost-checkbox:checked').forEach(cb => {
        params.append('additional_cost_ids[]', cb.value);
    });

    document.querySelectorAll('.fee-summary-checkbox:checked').forEach(cb => {
        params.append('fee_summary_items[]', cb.value);
    });

    const url = "<?php echo e(route('admin.students.invoices.preview_modal', $student->id)); ?>?" + params.toString();
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('inv_preview_container').classList.remove('d-none');
                // Set content into Summernote editor
                $('#modal_invoice_custom_content').summernote('code', data.content);
            }
        })
        .catch(err => console.error('Error fetching invoice preview:', err));
}

function openInvoiceModalForInstallment(installmentId) {
    if (document.getElementById('modal_invoice_installment_id')) {
        document.getElementById('modal_invoice_installment_id').value = installmentId;
    }
    var modal = new bootstrap.Modal(document.getElementById('generateInvoiceModal'));
    modal.show();
    if (document.getElementById('modal_invoice_template_id').value) {
        fetchInvoiceTemplatePreview(document.getElementById('modal_invoice_template_id').value);
    }
}
</script>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    $('#modal_custom_content').summernote({
        height: 380,
        placeholder: 'Template preview will appear here after selecting a template above...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'hr']],
            ['view', ['codeview']],
        ]
    });

    $('#modal_invoice_custom_content').summernote({
        height: 380,
        placeholder: 'Template preview will appear here after selecting a template above...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'hr']],
            ['view', ['codeview']],
        ]
    });

    // Make sure Summernote content is synced before form submit
    $('form').on('submit', function() {
        if ($('#modal_custom_content').length && $('#modal_custom_content').data('summernote')) {
            $('#modal_custom_content').val($('#modal_custom_content').summernote('code'));
        }
        if ($('#modal_invoice_custom_content').length && $('#modal_invoice_custom_content').data('summernote')) {
            $('#modal_invoice_custom_content').val($('#modal_invoice_custom_content').summernote('code'));
        }
    });

    // Record Payment Modal logic
    $(document).on('click', '.record-payment-btn', function() {
        const id = $(this).data('id');
        const number = $(this).data('inst');
        const due = $(this).data('due');
        const amount = parseFloat($(this).data('amount'));
        const paid = parseFloat($(this).data('paid'));
        const currency = $(this).data('currency');
        const remaining = amount - paid;

        $('#modal_installment_title').text(`Installment ${number}`);
        $('#modal_due_date').text(due);
        $('#modal_amount_display').text(`${amount.toFixed(2)} ${currency}`);
        $('#modal_paid_display').text(`${paid.toFixed(2)} ${currency}`);
        $('.currency-label').text(currency);
        
        $('#amount_paid_input').val(remaining.toFixed(2));
        
        // Update form action url dynamically
        $('#recordPaymentForm').attr('action', `/admin/installments/${id}/record-payment`);
        
        $('#recordPaymentModal').modal('show');
    });

    $(document).on('click', '.record-cost-payment-btn', function() {
        const costId = $(this).data('id');
        const costName = $(this).data('name');
        const amount = parseFloat($(this).data('amount')).toFixed(2);
        const currency = $(this).data('currency');

        $('#modal_cost_name').val(costName);
        $('#modal_cost_amount').val(amount + ' ' + currency);

        const actionUrl = "<?php echo e(url('/admin/additional-costs')); ?>/" + costId + "/record-payment";
        $('#recordCostPaymentForm').attr('action', actionUrl);

        $('#recordCostPaymentModal').modal('show');
    });
});
</script>
<?php $__env->stopPush(); ?>

<!-- Record Payment Modal -->
<div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-labelledby="recordPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="recordPaymentModalLabel"><i class="fas fa-coins me-2"></i> Record Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="recordPaymentForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <span class="text-muted d-block text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Installment Details</span>
                        <h5 class="fw-bold text-dark mb-1" id="modal_installment_title">Installment 1</h5>
                        <small class="text-muted">Due date: <span id="modal_due_date">N/A</span></small>
                    </div>
                    <hr class="my-3">
                    <div class="row mb-3 font-13">
                        <div class="col-6">
                            <small class="text-muted d-block">Installment Fee</small>
                            <span class="fw-bold text-dark" id="modal_amount_display">0.00</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Already Paid</small>
                            <span class="fw-bold text-success" id="modal_paid_display">0.00</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Amount to Pay (<span class="currency-label">GBP</span>) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text currency-label">GBP</span>
                            <input type="number" name="amount_paid" id="amount_paid_input" class="form-control" step="0.01" min="0.01" readonly required>
                        </div>
                        <small class="text-muted mt-1 d-block">The installment amount will be paid in full.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save me-1"></i> Save Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Record Additional Cost Payment Modal -->
<div class="modal fade" id="recordCostPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="POST" id="recordCostPaymentForm">
            <?php echo csrf_field(); ?>
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-hand-holding-usd me-2"></i> Record Additional Cost Payment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3 text-muted small"><i class="fas fa-info-circle me-1"></i> Additional cost payments are paid in full (one-time payment, no installments).</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cost Item / Description</label>
                        <input type="text" id="modal_cost_name" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Payment Amount</label>
                        <input type="text" id="modal_cost_amount" class="form-control bg-light fw-bold text-success" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Online Payment">Online Payment</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Transaction Reference / TXN ID (Optional)</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="Enter Reference No. or TXN ID">
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check-circle me-1"></i> Confirm Full Payment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\admin\students\show.blade.php ENDPATH**/ ?>
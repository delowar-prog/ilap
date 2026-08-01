<?php $__env->startSection('title', 'Manage Enrolment & Fees'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="container-fluid px-0">
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 text-primary fw-semibold">
                <i class="fas fa-file-invoice-dollar me-2"></i> Manage Enrolment & Fees: <?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>

            </h5>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.students.show', $student->id)); ?>" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-file-invoice me-1"></i> Student Profile & Invoices
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->enrolment_status === 'enrolled'): ?>
                    <a href="<?php echo e(route('admin.students.enrolled')); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('admin.students.index', ['status' => 'approved'])); ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        <div class="card-body p-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-1"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <h6 class="alert-heading fw-bold mb-1"><i class="fas fa-exclamation-circle me-1"></i> Please fix the following errors before saving:</h6>
                    <ul class="mb-0 ps-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><?php echo e($error); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('admin.students.enrolment.save', $student->id)); ?>" method="POST" id="enrolmentForm" novalidate>
                <?php echo csrf_field(); ?>

                <!-- Step 1: Course Assignment -->
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            1. Select Course & Base Fee
                        </h6>
                        <hr class="mt-1 mb-3">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Assign Course <span class="text-danger">*</span></label>
                        <select name="course_id" id="course_id" class="form-select select2-init">
                            <option value="">Select Course</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <option value="<?php echo e($course->id); ?>" 
                                    <?php echo e((old('course_id', $application->course_id ?? '')) == $course->id ? 'selected' : ''); ?>>
                                    [<?php echo e($course->course_code); ?>] <?php echo e($course->name); ?> (<?php echo e($course->partner_institute); ?>)
                                </option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Base Course Fee</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold" id="currency_symbol">
                                <?php echo e($application->course->currency ?? 'GBP'); ?>

                            </span>
                            <input type="text" id="course_fee_display" class="form-control bg-light" readonly value="0.00">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-medium text-success"><i class="fas fa-gift me-1"></i> Scholarship Amount</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold currency-label">
                                <?php echo e($application->course->currency ?? 'GBP'); ?>

                            </span>
                            <input type="number" name="scholarship_amount" id="scholarship_amount" class="form-control fw-bold text-success" step="0.01" min="0" value="<?php echo e(old('scholarship_amount', $application->scholarship_amount ?? 0)); ?>" placeholder="0.00">
                        </div>
                        <small class="text-muted">Net Course Fee (Total after Scholarship): <strong class="text-primary" id="net_course_fee_display">0.00</strong></small>
                    </div>
                </div>

                <!-- Step 2: Installments Scheduling (Course Base Fee Only) -->
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            2. Payment Setup & Installments Schedule (Net Course Fee)
                        </h6>
                        <hr class="mt-1 mb-3">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Setup Type <span class="text-danger">*</span></label>
                        <select id="payment_setup_type" class="form-select form-select-sm" required>
                            <option value="full_due">Full Due (Pay Course Fee via Custom Installments)</option>
                            <option value="full_paid">Full Payment (Pay Course Fee in Full Upfront)</option>
                            <option value="partial_upfront">Partial Upfront + Custom Installments</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-none" id="upfront_amount_container">
                        <label class="form-label fw-bold">Upfront Payment Amount (<span class="currency-label">GBP</span>) <span class="text-danger">*</span></label>
                        <input type="number" id="upfront_amount" class="form-control form-control-sm" step="0.01" min="0.01" value="0.00">
                    </div>
                    
                    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Configure payment installments schedule for Net Course Fee below:</span>
                        <button type="button" class="btn btn-xs btn-outline-primary" id="add_installment_btn">
                            <i class="fas fa-plus me-1"></i> Add Installment
                        </button>
                    </div>

                    <div class="col-12">
                        <div class="alert alert-warning py-2 px-3 d-none mb-3 shadow-none border-0 align-items-center gap-2" id="installment_validation_warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span id="installment_warning_text">Installment total must match the Net Course Fee!</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle" id="installments_table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%;">Installment No.</th>
                                        <th style="width: 25%;">Amount</th>
                                        <th style="width: 20%;">Due Date</th>
                                        <th style="width: 15%;">Status</th>
                                        <th style="width: 20%;">Paid Amount</th>
                                        <th style="width: 5%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="installments_tbody">
                                    <!-- Dynamic Rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Additional Costs (Outside Installments) -->
                <div class="row mb-4">
                    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-muted fw-semibold mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                                3. Additional Costs (Outside Installments - One-time Full Payment)
                            </h6>
                            <small class="text-muted">Fees here will NOT be included in installments and must be paid in full separately.</small>
                        </div>
                        <button type="button" class="btn btn-xs btn-outline-primary" id="add_cost_btn">
                            <i class="fas fa-plus me-1"></i> Add Additional Cost Item
                        </button>
                    </div>

                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle" id="additional_costs_table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50%;">Cost Item / Description</th>
                                        <th style="width: 40%;">Amount</th>
                                        <th style="width: 10%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="additional_costs_tbody">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(old('additional_costs', $application->additionalCosts ?? [])): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = old('additional_costs', $application->additionalCosts ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $cost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <?php
                                                $costName = is_array($cost) ? ($cost['cost_name'] ?? '') : $cost->cost_name;
                                                $amount = is_array($cost) ? ($cost['amount'] ?? 0) : $cost->amount;
                                            ?>
                                            <tr>
                                                <td>
                                                    <select name="additional_costs[<?php echo e($index); ?>][cost_name]" class="form-select form-select-sm" required>
                                                        <option value="">Select Cost Type</option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $costTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                            <option value="<?php echo e($type); ?>" <?php echo e($costName == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="additional_costs[<?php echo e($index); ?>][amount]" class="form-control form-control-sm cost-amount" step="0.01" min="0" required value="<?php echo e(number_format($amount, 2, '.', '')); ?>">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-xs btn-danger remove-row-btn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Grand Total Display Box -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                            <div class="text-muted fw-semibold">Total Fee Calculation Summary</div>
                            <div class="d-flex align-items-center gap-4">
                                <div class="text-end">
                                    <small class="text-muted d-block">Base Fee</small>
                                    <span class="fw-bold" id="base_fee_summary_display">0.00</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-success d-block">Scholarship</small>
                                    <span class="fw-bold text-success" id="scholarship_summary_display">-0.00</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Course Fee</small>
                                    <span class="fw-bold text-primary" id="net_fee_summary_display">0.00</span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Additional Costs</small>
                                    <span class="fw-bold" id="additional_cost_total_display">0.00</span>
                                </div>
                                <div class="text-end">
                                    <h5 class="text-primary fw-bold mb-0">
                                        Grand Total: <span id="grand_total_display">0.00</span> <span class="currency-label">GBP</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2" id="submitFormBtn">
                            <i class="fas fa-save me-1"></i> Save Enrolment Details
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        display: flex !important;
        align-items: center !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: normal !important;
        padding-left: 12px !important;
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        position: absolute !important;
        right: 8px !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const courses = <?php echo $coursesJson; ?>;
    const costTypes = <?php echo json_encode($costTypes); ?>;
    const existingInstallments = <?php echo isset($application) ? $application->installments->map(function($inst) {
        return [
            'amount' => (float)$inst->amount,
            'due_date' => $inst->due_date ? $inst->due_date->format('Y-m-d') : '',
            'status' => $inst->status,
            'paid_amount' => (float)$inst->paid_amount,
        ];
    })->toJson() : '[]'; ?>;

    $(document).ready(function() {
        $('.select2-init').select2({
            placeholder: "Select a course...",
            allowClear: true,
            width: '100%'
        });

        // Dynamic element index counters
        let costCount = $('#additional_costs_tbody tr').length;
        let instCount = 0;

        // Auto-update base fee and currency symbol when course changes
        $('#course_id').on('change', function() {
            const courseId = $(this).val();
            if (courseId && courses[courseId]) {
                const courseData = courses[courseId];
                $('#course_fee_display').val(parseFloat(courseData.fee).toFixed(2));
                $('#currency_symbol').text(courseData.currency);
                $('.currency-label').text(courseData.currency);
            } else {
                $('#course_fee_display').val('0.00');
            }
            calculateTotals();
            if ($('#payment_setup_type').val() === 'full_paid') {
                renderInstallments();
            }
        });

        // Trigger calculation on scholarship amount change
        $('#scholarship_amount').on('input', function() {
            calculateTotals();
            if ($('#payment_setup_type').val() === 'full_paid') {
                renderInstallments();
            }
        });

        // Dynamic rows generation for Additional Costs
        $('#add_cost_btn').on('click', function() {
            let selectOptionsHtml = '<option value="">Select Cost Type</option>';
            costTypes.forEach(type => {
                selectOptionsHtml += `<option value="${type}">${type}</option>`;
            });

            const newRow = `
                <tr>
                    <td>
                        <select name="additional_costs[${costCount}][cost_name]" class="form-select form-select-sm" required>
                            ${selectOptionsHtml}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="additional_costs[${costCount}][amount]" class="form-control form-control-sm cost-amount" step="0.01" min="0" required value="0.00">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs btn-danger remove-row-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#additional_costs_tbody').append(newRow);
            costCount++;
            calculateTotals();
        });

        // Dynamic rows generation for Installments
        $('#add_installment_btn').on('click', function() {
            $('#installments_tbody').append(createInstallmentRowHtml(instCount, '', '', 'pending', 0.00));
            instCount++;
            updateInstallmentLabels();
            calculateTotals();
        });

        // Setup Type Detection and Init
        let initialSetupType = 'full_due';
        let initialUpfrontVal = 0;

        if (existingInstallments.length === 1 && existingInstallments[0].status === 'paid') {
            initialSetupType = 'full_paid';
        } else if (existingInstallments.length > 1 && existingInstallments[0].status === 'paid') {
            initialSetupType = 'partial_upfront';
            initialUpfrontVal = existingInstallments[0].amount;
        }

        $('#payment_setup_type').val(initialSetupType);
        if (initialSetupType === 'partial_upfront') {
            $('#upfront_amount_container').removeClass('d-none');
            $('#upfront_amount').val(initialUpfrontVal.toFixed(2));
        }

        // Render Installments dynamically based on Selected Payment Setup Type
        function renderInstallments() {
            const setupType = $('#payment_setup_type').val();
            const tbody = $('#installments_tbody');
            tbody.empty();
            instCount = 0;

            const baseFee = parseFloat($('#course_fee_display').val()) || 0;
            const scholarship = parseFloat($('#scholarship_amount').val()) || 0;
            const netCourseFee = Math.max(0, baseFee - scholarship);

            if (setupType === 'full_paid') {
                $('#add_installment_btn').addClass('d-none');
                $('#upfront_amount_container').addClass('d-none');
                
                const today = new Date().toISOString().split('T')[0];
                const row = `
                    <tr>
                        <td class="fw-semibold ps-3 py-2 text-muted inst-label">
                            Full Payment
                        </td>
                        <td>
                            <input type="number" name="installments[0][amount]" class="form-control form-control-sm installment-amount" step="0.01" value="${netCourseFee.toFixed(2)}" readonly>
                        </td>
                        <td>
                            <input type="date" name="installments[0][due_date]" class="form-control form-control-sm" value="${today}">
                        </td>
                        <td>
                            <input type="hidden" name="installments[0][status]" value="paid">
                            <span class="badge bg-success">Fully Paid</span>
                        </td>
                        <td>
                            <input type="number" name="installments[0][paid_amount]" class="form-control form-control-sm installment-paid" value="${netCourseFee.toFixed(2)}" readonly>
                        </td>
                        <td class="text-center text-muted">-</td>
                    </tr>
                `;
                tbody.append(row);
                instCount = 1;
            } 
            else if (setupType === 'partial_upfront') {
                $('#add_installment_btn').removeClass('d-none');
                $('#upfront_amount_container').removeClass('d-none');

                const upfrontAmount = parseFloat($('#upfront_amount').val()) || 0;
                const today = new Date().toISOString().split('T')[0];

                const upfrontRow = `
                    <tr>
                        <td class="fw-semibold ps-3 py-2 text-muted inst-label">
                            Upfront Payment
                        </td>
                        <td>
                            <input type="number" name="installments[0][amount]" class="form-control form-control-sm installment-amount" step="0.01" value="${upfrontAmount.toFixed(2)}" readonly>
                        </td>
                        <td>
                            <input type="date" name="installments[0][due_date]" class="form-control form-control-sm" value="${today}">
                        </td>
                        <td>
                            <input type="hidden" name="installments[0][status]" value="paid">
                            <span class="badge bg-success">Fully Paid</span>
                        </td>
                        <td>
                            <input type="number" name="installments[0][paid_amount]" class="form-control form-control-sm installment-paid" value="${upfrontAmount.toFixed(2)}" readonly>
                        </td>
                        <td class="text-center text-muted">-</td>
                    </tr>
                `;
                tbody.append(upfrontRow);
                instCount = 1;

                if (existingInstallments.length > 1 && setupType === initialSetupType) {
                    existingInstallments.slice(1).forEach((inst) => {
                        tbody.append(createInstallmentRowHtml(instCount, inst.amount, inst.due_date, inst.status, inst.paid_amount));
                        instCount++;
                    });
                } else {
                    tbody.append(createInstallmentRowHtml(instCount, '', '', 'pending', 0.00));
                    instCount++;
                }
            } 
            else { // full_due
                $('#add_installment_btn').removeClass('d-none');
                $('#upfront_amount_container').addClass('d-none');

                if (existingInstallments.length > 0 && setupType === initialSetupType) {
                    existingInstallments.forEach((inst) => {
                        tbody.append(createInstallmentRowHtml(instCount, inst.amount, inst.due_date, inst.status, inst.paid_amount));
                        instCount++;
                    });
                } else {
                    tbody.append(createInstallmentRowHtml(instCount, '', '', 'pending', 0.00));
                    instCount++;
                }
            }

            updateInstallmentLabels();
            calculateTotals();
        }

        function createInstallmentRowHtml(index, amount, dueDate, status, paidAmount) {
            const amountVal = (amount !== undefined && amount !== null && amount !== '') ? parseFloat(amount).toFixed(2) : '';
            return `
                <tr>
                    <td class="fw-semibold ps-3 py-2 text-muted inst-label">
                        Installment
                    </td>
                    <td>
                        <input type="number" name="installments[${index}][amount]" class="form-control form-control-sm installment-amount" step="0.01" min="0.01" value="${amountVal}" placeholder="Enter amount">
                    </td>
                    <td>
                        <input type="date" name="installments[${index}][due_date]" class="form-control form-control-sm" value="${dueDate || ''}">
                    </td>
                    <td>
                        <select name="installments[${index}][status]" class="form-select form-select-sm installment-status">
                            <option value="pending" ${status === 'pending' ? 'selected' : ''}>Due (Pending)</option>
                            <option value="partially_paid" ${status === 'partially_paid' ? 'selected' : ''}>Partially Paid</option>
                            <option value="paid" ${status === 'paid' ? 'selected' : ''}>Fully Paid</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="installments[${index}][paid_amount]" class="form-control form-control-sm installment-paid" step="0.01" min="0" value="${parseFloat(paidAmount || 0).toFixed(2)}" ${status !== 'partially_paid' ? 'readonly' : ''}>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-xs btn-danger remove-row-btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
        }

        // Toggle paid amount field and values depending on status dropdown selection
        $(document).on('change', '.installment-status', function() {
            const row = $(this).closest('tr');
            const status = $(this).val();
            const amountInput = row.find('.installment-amount');
            const paidInput = row.find('.installment-paid');
            const amountVal = parseFloat(amountInput.val()) || 0;

            if (status === 'paid') {
                paidInput.val(amountVal.toFixed(2)).prop('readonly', true);
            } else if (status === 'pending') {
                paidInput.val('0.00').prop('readonly', true);
            } else {
                paidInput.val('0.00').prop('readonly', false).focus();
            }
            calculateTotals();
        });

        // Keep paid amount updated if amount is modified and status is paid
        $(document).on('input', '.installment-amount', function() {
            const row = $(this).closest('tr');
            const status = row.find('.installment-status').val();
            const amountVal = parseFloat($(this).val()) || 0;
            const paidInput = row.find('.installment-paid');

            if (status === 'paid') {
                paidInput.val(amountVal.toFixed(2));
            }
        });

        // Event listeners for Payment Setup type selections
        $('#payment_setup_type').on('change', function() {
            renderInstallments();
        });

        $('#upfront_amount').on('input', function() {
            const val = parseFloat($(this).val()) || 0;
            const tbody = $('#installments_tbody');
            tbody.find('tr:first-child .installment-amount').val(val.toFixed(2));
            tbody.find('tr:first-child .installment-paid').val(val.toFixed(2));
            calculateTotals();
        });

        // Handling row removals for both tables
        $(document).on('click', '.remove-row-btn', function() {
            $(this).closest('tr').remove();
            updateInstallmentLabels();
            calculateTotals();
        });

        // Trigger updates when cost values or installment values are modified
        $(document).on('input', '.cost-amount, .installment-amount, .installment-paid', function() {
            calculateTotals();
        });

        // Form Submit Handler (Custom Validation & Re-indexing)
        $('#enrolmentForm').on('submit', function(e) {
            let isValid = true;
            let firstErrorEl = null;

            // 1. Validate course_id
            const courseId = $('#course_id').val();
            if (!courseId) {
                isValid = false;
                $('.select2-selection').css('border', '1px solid #dc3545');
                if (!firstErrorEl) firstErrorEl = $('.select2-selection');
            } else {
                $('.select2-selection').css('border', '');
            }

            // 2. Validate additional costs
            $('#additional_costs_tbody tr').each(function() {
                const costSelect = $(this).find('select');
                if (costSelect.length && !costSelect.val()) {
                    isValid = false;
                    costSelect.addClass('is-invalid');
                    if (!firstErrorEl) firstErrorEl = costSelect;
                } else {
                    costSelect.removeClass('is-invalid');
                }
            });

            // 3. Validate installments
            $('#installments_tbody tr').each(function() {
                const amtInput = $(this).find('.installment-amount');
                const dateInput = $(this).find('input[type="date"]');

                if (amtInput.length && (parseFloat(amtInput.val()) || 0) <= 0) {
                    isValid = false;
                    amtInput.addClass('is-invalid');
                    if (!firstErrorEl) firstErrorEl = amtInput;
                } else {
                    amtInput.removeClass('is-invalid');
                }

                if (dateInput.length && !dateInput.val()) {
                    isValid = false;
                    dateInput.addClass('is-invalid');
                    if (!firstErrorEl) firstErrorEl = dateInput;
                } else {
                    dateInput.removeClass('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                if (firstErrorEl) {
                    $('html, body').animate({
                        scrollTop: firstErrorEl.offset().top - 150
                    }, 300);
                }
                if (typeof toastr !== 'undefined') {
                    toastr.error('Please select a course and fill in all required fields.');
                }
                return false;
            }

            // Re-index additional costs inputs
            $('#additional_costs_tbody tr').each(function(idx) {
                $(this).find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace(/additional_costs\[\d+\]/, `additional_costs[${idx}]`));
                    }
                });
            });

            // Re-index installments inputs
            $('#installments_tbody tr').each(function(idx) {
                $(this).find('select, input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace(/installments\[\d+\]/, `installments[${idx}]`));
                    }
                });
            });

            return true;
        });

        // Perform calculation updates and grand validation in real-time
        function calculateTotals() {
            // Calculate base fee & scholarship
            const baseFee = parseFloat($('#course_fee_display').val()) || 0;
            const scholarship = parseFloat($('#scholarship_amount').val()) || 0;
            const netCourseFee = Math.max(0, baseFee - scholarship);

            $('#net_course_fee_display').text(netCourseFee.toFixed(2));
            $('#base_fee_summary_display').text(baseFee.toFixed(2));
            $('#scholarship_summary_display').text('-' + scholarship.toFixed(2));
            $('#net_fee_summary_display').text(netCourseFee.toFixed(2));

            // Calculate additional costs total
            let additionalCostsTotal = 0;
            $('.cost-amount').each(function() {
                additionalCostsTotal += parseFloat($(this).val()) || 0;
            });
            $('#additional_cost_total_display').text(additionalCostsTotal.toFixed(2));

            // Calculate Grand Total
            const grandTotal = netCourseFee + additionalCostsTotal;
            $('#grand_total_display').text(grandTotal.toFixed(2));

            // Force update upfront row value if setup type is Full Paid
            const setupType = $('#payment_setup_type').val();
            if (setupType === 'full_paid') {
                const tbody = $('#installments_tbody');
                tbody.find('tr:first-child .installment-amount').val(netCourseFee.toFixed(2));
                tbody.find('tr:first-child .installment-paid').val(netCourseFee.toFixed(2));
            }

            // Calculate installments sum
            let installmentsTotal = 0;
            $('.installment-amount').each(function() {
                installmentsTotal += parseFloat($(this).val()) || 0;
            });
            $('#installments_total_display').text(installmentsTotal.toFixed(2));

            // Informational check against netCourseFee (does not block form submission)
            const errorWarning = $('#installment_validation_warning');
            if (Math.abs(installmentsTotal - netCourseFee) > 0.01) {
                errorWarning.removeClass('d-none').addClass('d-flex');
                $('#installment_warning_text').html(`<strong>Note:</strong> Total payment installments amount (<strong>${installmentsTotal.toFixed(2)}</strong>) differs from Net Course Fee (<strong>${netCourseFee.toFixed(2)}</strong>).`);
            } else {
                errorWarning.removeClass('d-flex').addClass('d-none');
            }
        }

        // Keep installment sequential numbers up to date when rows are modified/deleted
        function updateInstallmentLabels() {
            $('#installments_tbody tr').each(function(index) {
                const isFirstRow = (index === 0);
                const setupType = $('#payment_setup_type').val();
                let labelText = `Installment ${index + 1}`;
                if (isFirstRow) {
                    if (setupType === 'full_paid') {
                        labelText = 'Full Payment';
                    } else if (setupType === 'partial_upfront') {
                        labelText = 'Upfront Payment';
                    }
                }
                $(this).find('.inst-label').text(labelText);
            });
        }

        // Initial trigger to render installments on load
        if ($('#course_id').val()) {
            const courseId = $('#course_id').val();
            if (courses[courseId]) {
                $('#course_fee_display').val(parseFloat(courses[courseId].fee).toFixed(2));
                $('#currency_symbol').text(courses[courseId].currency);
                $('.currency-label').text(courses[courseId].currency);
            }
        }
        renderInstallments();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\admin\students\manage_enrolment.blade.php ENDPATH**/ ?>
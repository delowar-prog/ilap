@extends('layouts.backend_master')

@section('title', 'Manage Enrolment & Fees')

@section('admin_contents')
<div class="container-fluid px-0">
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 text-primary fw-semibold">
                <i class="fas fa-file-invoice-dollar me-2"></i> Manage Enrolment & Fees: {{ $student->first_name }} {{ $student->surname }}
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-outline-info">
                    <i class="fas fa-file-invoice me-1"></i> Student Profile & Invoices
                </a>
                @if($student->enrolment_status === 'enrolled')
                    <a href="{{ route('admin.students.enrolled') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                @else
                    <a href="{{ route('admin.students.index', ['status' => 'approved']) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <h6 class="alert-heading fw-bold mb-1"><i class="fas fa-exclamation-circle me-1"></i> Please fix the following errors before saving:</h6>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.students.enrolment.save', $student->id) }}" method="POST" id="enrolmentForm" novalidate>
                @csrf

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
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                    {{ (old('course_id', $application->course_id ?? '')) == $course->id ? 'selected' : '' }}>
                                    [{{ $course->course_code }}] {{ $course->name }} ({{ $course->partner_institute }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Base Course Fee</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold" id="currency_symbol">
                                {{ $application->course->currency ?? 'GBP' }}
                            </span>
                            <input type="text" id="course_fee_display" class="form-control bg-light" readonly value="0.00">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-medium text-success"><i class="fas fa-gift me-1"></i> Scholarship Amount</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold currency-label">
                                {{ $application->course->currency ?? 'GBP' }}
                            </span>
                            <input type="number" name="scholarship_amount" id="scholarship_amount" class="form-control fw-bold text-success" step="0.01" min="0" value="{{ old('scholarship_amount', $application->scholarship_amount ?? 0) }}" placeholder="0.00">
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
                                        <th style="width: 35%;">Note / Remarks</th>
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
                                        <th style="width: 40%;">Cost Item / Description</th>
                                        <th style="width: 25%;">Amount</th>
                                        <th style="width: 30%;">Note / Remarks</th>
                                        <th style="width: 5%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="additional_costs_tbody">
                                    @if(old('additional_costs', $application->additionalCosts ?? []))
                                        @foreach(old('additional_costs', $application->additionalCosts ?? []) as $index => $cost)
                                            @php
                                                $costName = is_array($cost) ? ($cost['cost_name'] ?? '') : $cost->cost_name;
                                                $amount = is_array($cost) ? ($cost['amount'] ?? 0) : $cost->amount;
                                                $costNote = is_array($cost) ? ($cost['note'] ?? '') : ($cost->note ?? '');
                                            @endphp
                                            <tr>
                                                <td>
                                                    <select name="additional_costs[{{ $index }}][cost_name]" class="form-select form-select-sm" required>
                                                        <option value="">Select Cost Type</option>
                                                        @foreach($costTypes as $type)
                                                            <option value="{{ $type }}" {{ $costName == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="additional_costs[{{ $index }}][amount]" class="form-control form-control-sm cost-amount" step="0.01" min="0" required value="{{ number_format($amount, 2, '.', '') }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="additional_costs[{{ $index }}][note]" class="form-control form-control-sm" placeholder="Optional note / remarks..." value="{{ $costNote }}">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-xs btn-danger remove-row-btn">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
@endsection

@push('css')
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
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    const courses = {!! $coursesJson !!};
    const costTypes = {!! json_encode($costTypes) !!};
    const existingInstallments = {!! isset($application) ? $application->installments->map(function($inst) {
        return [
            'amount' => (float)$inst->amount,
            'due_date' => $inst->due_date ? $inst->due_date->format('Y-m-d') : '',
            'status' => $inst->status,
            'paid_amount' => (float)$inst->paid_amount,
            'note' => $inst->note ?? '',
        ];
    })->toJson() : '[]' !!};

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
                    <td>
                        <input type="text" name="additional_costs[${costCount}][note]" class="form-control form-control-sm" placeholder="Optional note / remarks..." value="">
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

        // Dynamic rows generation for Installments (Auto-calculates remaining unallocated balance)
        $('#add_installment_btn').on('click', function() {
            const baseFee = parseFloat($('#course_fee_display').val()) || 0;
            const scholarship = parseFloat($('#scholarship_amount').val()) || 0;
            const netCourseFee = Math.max(0, baseFee - scholarship);

            let allocatedTotal = 0;
            $('.installment-amount').each(function() {
                allocatedTotal += parseFloat($(this).val()) || 0;
            });

            const remaining = Math.max(0, netCourseFee - allocatedTotal);
            const autoAmount = remaining > 0 ? remaining.toFixed(2) : '';

            $('#installments_tbody').append(createInstallmentRowHtml(instCount, autoAmount, '', 'pending', 0.00, ''));
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
                            <input type="text" name="installments[0][note]" class="form-control form-control-sm" placeholder="Optional note / remarks..." value="Full upfront course fee payment">
                            <input type="hidden" name="installments[0][status]" value="paid">
                            <input type="hidden" name="installments[0][paid_amount]" class="installment-paid" value="${netCourseFee.toFixed(2)}">
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
                            <input type="text" name="installments[0][note]" class="form-control form-control-sm" placeholder="Optional note / remarks..." value="Partial upfront payment">
                            <input type="hidden" name="installments[0][status]" value="paid">
                            <input type="hidden" name="installments[0][paid_amount]" class="installment-paid" value="${upfrontAmount.toFixed(2)}">
                        </td>
                        <td class="text-center text-muted">-</td>
                    </tr>
                `;
                tbody.append(upfrontRow);
                instCount = 1;

                if (existingInstallments.length > 1 && setupType === initialSetupType) {
                    existingInstallments.slice(1).forEach((inst) => {
                        tbody.append(createInstallmentRowHtml(instCount, inst.amount, inst.due_date, inst.status, inst.paid_amount, inst.note));
                        instCount++;
                    });
                } else {
                    const remainingForUpfront = Math.max(0, netCourseFee - upfrontAmount);
                    const initUpfrontAmt = remainingForUpfront > 0 ? remainingForUpfront.toFixed(2) : '';
                    tbody.append(createInstallmentRowHtml(instCount, initUpfrontAmt, '', 'pending', 0.00, ''));
                    instCount++;
                }
            } 
            else { // full_due
                $('#add_installment_btn').removeClass('d-none');
                $('#upfront_amount_container').addClass('d-none');

                if (existingInstallments.length > 0 && setupType === initialSetupType) {
                    existingInstallments.forEach((inst) => {
                        tbody.append(createInstallmentRowHtml(instCount, inst.amount, inst.due_date, inst.status, inst.paid_amount, inst.note));
                        instCount++;
                    });
                } else {
                    const initAmt = netCourseFee > 0 ? netCourseFee.toFixed(2) : '';
                    tbody.append(createInstallmentRowHtml(instCount, initAmt, '', 'pending', 0.00, ''));
                    instCount++;
                }
            }

            updateInstallmentLabels();
            calculateTotals();
        }

        function createInstallmentRowHtml(index, amount, dueDate, status, paidAmount, note) {
            const amountVal = (amount !== undefined && amount !== null && amount !== '') ? parseFloat(amount).toFixed(2) : '';
            const noteVal = note || '';
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
                        <input type="text" name="installments[${index}][note]" class="form-control form-control-sm" placeholder="Optional note / remarks..." value="${noteVal}">
                        <input type="hidden" name="installments[${index}][status]" value="${status || 'pending'}">
                        <input type="hidden" name="installments[${index}][paid_amount]" class="installment-paid" value="${parseFloat(paidAmount || 0).toFixed(2)}">
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

        function getCurrencySymbolJS(code) {
            code = (code || 'GBP').toUpperCase().trim();
            const symbols = {
                'USD': '$',
                'GBP': '£',
                'EUR': '€',
                'BDT': '৳',
                'INR': '₹',
                'CAD': 'CA$',
                'AUD': 'A$',
                'MYR': 'RM',
                'SGD': 'S$',
                'AED': 'AED',
                'SAR': 'SAR'
            };
            return symbols[code] || '$';
        }

        function formatCurrencyJS(amount, code) {
            code = (code || 'GBP').toUpperCase().trim();
            const symbol = getCurrencySymbolJS(code);
            const num = parseFloat(amount) || 0;
            const formatted = Math.abs(num).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const prefix = num < 0 ? '-' : '';
            return `${prefix}${code} ${symbol} ${formatted}`;
        }

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

            // Informational check against netCourseFee & Remaining Unallocated Due Banner
            const errorWarning = $('#installment_validation_warning');
            const diff = netCourseFee - installmentsTotal;
            const currency = $('#currency_symbol').text() || 'GBP';

            if (Math.abs(diff) <= 0.01) {
                errorWarning.removeClass('d-none alert-info alert-warning alert-danger').addClass('d-flex alert-success');
                $('#installment_warning_text').html(`<i class="fas fa-check-circle me-1"></i> <strong>Full Fee Allocated:</strong> Total scheduled installments (<strong>${formatCurrencyJS(installmentsTotal, currency)}</strong>) matches Net Course Fee.`);
            } else if (diff > 0.01) {
                const remaining = diff;
                errorWarning.removeClass('d-none alert-success alert-danger alert-warning').addClass('d-flex alert-info');
                $('#installment_warning_text').html(`<i class="fas fa-info-circle me-1"></i> <strong>Remaining Unallocated Balance: ${formatCurrencyJS(remaining, currency)}</strong> (Net Fee: ${formatCurrencyJS(netCourseFee, currency)} | Allocated: ${formatCurrencyJS(installmentsTotal, currency)}). Click <strong>'Add Installment'</strong> to auto-fill the remaining <strong>${formatCurrencyJS(remaining, currency)}</strong>.`);
            } else {
                const excess = Math.abs(diff);
                errorWarning.removeClass('d-none alert-success alert-info alert-danger').addClass('d-flex alert-warning');
                $('#installment_warning_text').html(`<i class="fas fa-exclamation-triangle me-1"></i> <strong>Over-Allocated:</strong> Total scheduled installments (<strong>${formatCurrencyJS(installmentsTotal, currency)}</strong>) exceeds Net Course Fee by <strong>${formatCurrencyJS(excess, currency)}</strong>.`);
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
@endpush

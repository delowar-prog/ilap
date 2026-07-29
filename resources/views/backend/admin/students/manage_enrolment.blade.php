@extends('layouts.backend_master')

@section('title', 'Manage Enrolment & Fees')

@section('admin_contents')
<div class="container-fluid px-0">
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 text-primary fw-semibold">
                <i class="fas fa-file-invoice-dollar me-2"></i> Manage Enrolment & Fees: {{ $student->first_name }} {{ $student->surname }}
            </h5>
            <a href="{{ route('admin.students.index', ['status' => 'approved']) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.students.enrolment.save', $student->id) }}" method="POST" id="enrolmentForm">
                @csrf

                <!-- Step 1: Course Assignment -->
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            1. Select Course & Base Fee
                        </h6>
                        <hr class="mt-1 mb-3">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-medium">Assign Course <span class="text-danger">*</span></label>
                        <select name="course_id" id="course_id" class="form-select select2-init" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                    {{ (old('course_id', $application->course_id ?? '')) == $course->id ? 'selected' : '' }}>
                                    [{{ $course->course_code }}] {{ $course->name }} ({{ $course->partner_institute }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Base Course Fee</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold" id="currency_symbol">
                                {{ $application->course->currency ?? 'GBP' }}
                            </span>
                            <input type="text" id="course_fee_display" class="form-control bg-light" readonly value="0.00">
                        </div>
                    </div>
                </div>

                <!-- Step 2: Additional Costs -->
                <div class="row mb-4">
                    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            2. Additional Costs
                        </h6>
                        <button type="button" class="btn btn-xs btn-outline-primary" id="add_cost_btn">
                            <i class="fas fa-plus me-1"></i> Add Cost
                        </button>
                    </div>
                    <div class="col-12">
                        <hr class="mt-0 mb-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle" id="additional_costs_table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 55%;">Cost Item / Type</th>
                                        <th style="width: 35%;">Amount</th>
                                        <th style="width: 10%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="additional_costs_tbody">
                                    @php
                                        $oldCosts = old('additional_costs', $application->additionalCosts ?? []);
                                    @endphp
                                    @forelse($oldCosts as $index => $cost)
                                        <tr>
                                            <td>
                                                <select name="additional_costs[{{ $index }}][cost_name]" class="form-select form-select-sm" required>
                                                    <option value="">Select Cost Type</option>
                                                    @foreach($costTypes as $type)
                                                        <option value="{{ $type }}" {{ ($cost['cost_name'] ?? $cost->cost_name) == $type ? 'selected' : '' }}>
                                                            {{ $type }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="additional_costs[{{ $index }}][amount]" class="form-control form-control-sm cost-amount" step="0.01" min="0" required value="{{ $cost['amount'] ?? $cost->amount }}">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-danger remove-row-btn">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <!-- Will load empty state via JS if no saved records -->
                                    @endforelse
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
                                    <small class="text-muted d-block">Additional Cost Total</small>
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

                <!-- Step 3: Installments Scheduling -->
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <h6 class="text-uppercase text-muted fw-semibold mb-0" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                            3. Payment Setup & Installments Schedule
                        </h6>
                        <hr class="mt-1 mb-3">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Setup Type <span class="text-danger">*</span></label>
                        <select id="payment_setup_type" class="form-select form-select-sm" required>
                            <option value="full_due">Full Due (Pay via Custom Installments)</option>
                            <option value="full_paid">Full Payment (Paid in Full Upfront)</option>
                            <option value="partial_upfront">Partial Upfront + Custom Installments</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-none" id="upfront_amount_container">
                        <label class="form-label fw-bold">Upfront Payment Amount (<span class="currency-label">GBP</span>) <span class="text-danger">*</span></label>
                        <input type="number" id="upfront_amount" class="form-control form-control-sm" step="0.01" min="0.01" value="0.00">
                    </div>
                    
                    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Configure payment installments schedule below:</span>
                        <button type="button" class="btn btn-xs btn-outline-primary" id="add_installment_btn">
                            <i class="fas fa-plus me-1"></i> Add Installment
                        </button>
                    </div>

                    <div class="col-12">
                        <div class="alert alert-warning py-2 px-3 d-none mb-3 shadow-none border-0 align-items-center gap-2" id="installment_validation_warning" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span id="installment_warning_text">Installment total must match the Grand Total!</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle" id="installments_table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%;">Installment No.</th>
                                        <th style="width: 25%;">Amount</th>
                                        <th style="width: 25%;">Due Date</th>
                                        <th style="width: 20%;">Payment Status</th>
                                        <th style="width: 15%;">Paid Amount</th>
                                        <th style="width: 10%;" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="installments_tbody">
                                    <!-- Dynamic rows loaded via Javascript -->
                                </tbody>
                            </table>
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
            $('#installments_tbody').append(createInstallmentRowHtml(instCount, 0.00, '', 'pending', 0.00));
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
            let additionalCostsTotal = 0;
            $('.cost-amount').each(function() {
                additionalCostsTotal += parseFloat($(this).val()) || 0;
            });
            const grandTotal = baseFee + additionalCostsTotal;

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
                            <input type="number" name="installments[0][amount]" class="form-control form-control-sm installment-amount" step="0.01" value="${grandTotal.toFixed(2)}" readonly required>
                        </td>
                        <td>
                            <input type="date" name="installments[0][due_date]" class="form-control form-control-sm" value="${today}" readonly required>
                        </td>
                        <td>
                            <input type="hidden" name="installments[0][status]" value="paid">
                            <span class="badge bg-success">Fully Paid</span>
                        </td>
                        <td>
                            <input type="number" name="installments[0][paid_amount]" class="form-control form-control-sm installment-paid" value="${grandTotal.toFixed(2)}" readonly required>
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
                            <input type="number" name="installments[0][amount]" class="form-control form-control-sm installment-amount" step="0.01" value="${upfrontAmount.toFixed(2)}" readonly required>
                        </td>
                        <td>
                            <input type="date" name="installments[0][due_date]" class="form-control form-control-sm" value="${today}" readonly required>
                        </td>
                        <td>
                            <input type="hidden" name="installments[0][status]" value="paid">
                            <span class="badge bg-success">Fully Paid</span>
                        </td>
                        <td>
                            <input type="number" name="installments[0][paid_amount]" class="form-control form-control-sm installment-paid" value="${upfrontAmount.toFixed(2)}" readonly required>
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
                    tbody.append(createInstallmentRowHtml(instCount, 0.00, '', 'pending', 0.00));
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
                    tbody.append(createInstallmentRowHtml(instCount, 0.00, '', 'pending', 0.00));
                    instCount++;
                }
            }

            updateInstallmentLabels();
            calculateTotals();
        }

        function createInstallmentRowHtml(index, amount, dueDate, status, paidAmount) {
            return `
                <tr>
                    <td class="fw-semibold ps-3 py-2 text-muted inst-label">
                        Installment
                    </td>
                    <td>
                        <input type="number" name="installments[${index}][amount]" class="form-control form-control-sm installment-amount" step="0.01" min="0.01" required value="${parseFloat(amount).toFixed(2)}">
                    </td>
                    <td>
                        <input type="date" name="installments[${index}][due_date]" class="form-control form-control-sm" required value="${dueDate}">
                    </td>
                    <td>
                        <select name="installments[${index}][status]" class="form-select form-select-sm installment-status" required>
                            <option value="pending" ${status === 'pending' ? 'selected' : ''}>Due (Pending)</option>
                            <option value="partially_paid" ${status === 'partially_paid' ? 'selected' : ''}>Partially Paid</option>
                            <option value="paid" ${status === 'paid' ? 'selected' : ''}>Fully Paid</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="installments[${index}][paid_amount]" class="form-control form-control-sm installment-paid" step="0.01" min="0" required value="${parseFloat(paidAmount).toFixed(2)}" ${status !== 'partially_paid' ? 'readonly' : ''}>
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

        // Perform calculation updates and grand validation in real-time
        function calculateTotals() {
            // Calculate base fee
            const baseFee = parseFloat($('#course_fee_display').val()) || 0;

            // Calculate additional costs total
            let additionalCostsTotal = 0;
            $('.cost-amount').each(function() {
                additionalCostsTotal += parseFloat($(this).val()) || 0;
            });
            $('#additional_cost_total_display').text(additionalCostsTotal.toFixed(2));

            // Calculate Grand Total
            const grandTotal = baseFee + additionalCostsTotal;
            $('#grand_total_display').text(grandTotal.toFixed(2));

            // Force update upfront row value if setup type is Full Paid
            const setupType = $('#payment_setup_type').val();
            if (setupType === 'full_paid') {
                const tbody = $('#installments_tbody');
                tbody.find('tr:first-child .installment-amount').val(grandTotal.toFixed(2));
                tbody.find('tr:first-child .installment-paid').val(grandTotal.toFixed(2));
            }

            // Calculate installments sum
            let installmentsTotal = 0;
            $('.installment-amount').each(function() {
                installmentsTotal += parseFloat($(this).val()) || 0;
            });

            // Perform matching check
            const errorWarning = $('#installment_validation_warning');
            if (installmentsTotal.toFixed(2) !== grandTotal.toFixed(2)) {
                errorWarning.removeClass('d-none').addClass('d-flex');
                $('#installment_warning_text').html(`<strong>Validation Warning:</strong> Total payment installments amount (<strong>${installmentsTotal.toFixed(2)}</strong>) does not match the Grand Total (<strong>${grandTotal.toFixed(2)}</strong>). Please adjust installments.`);
                $('#submitFormBtn').prop('disabled', true);
            } else {
                errorWarning.removeClass('d-flex').addClass('d-none');
                $('#submitFormBtn').prop('disabled', false);
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

        // Initialize: Trigger detection and render initial state
        $('#course_id').trigger('change');
        renderInstallments();
    });
</script>
@endpush

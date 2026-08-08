@extends('layouts.backend_master')
@section('title', $student->enrolment_status === 'enrolled' ? 'Student Dashboard' : 'Applicant Dashboard')

@push('css')
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
@endpush

@section('admin_contents')
<div class="row">
    <!-- Welcome Header -->
    <div class="col-12">
        <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                @php $isStudent = ($student->enrolment_status === 'enrolled'); @endphp
                <h2 class="text-white mb-2 fw-bold">Welcome back, {{ ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname)) }}! 👋</h2>
                <p class="mb-0 opacity-75">{{ $isStudent ? 'Student ID' : 'Applicant ID' }}: {{ $student->student_id }} &bull; {{ $student->email }}</p>
            </div>
            <div style="min-width: 250px;">
                <div class="d-flex justify-content-between mb-1">
                    <span class="font-14 fw-semibold">Profile Completion</span>
                    <span class="font-14 fw-bold">{{ $completionPercent }}%</span>
                </div>
                <div class="completion-bar-bg">
                    <div class="completion-bar-fill" style="width: {{ $completionPercent }}%;"></div>
                </div>
                @if($completionPercent < 100)
                    <div class="text-end mt-2">
                        <a href="{{ route('student.profile') }}" class="btn btn-sm btn-light fw-bold text-dark" style="color: #2c3e7a !important;">Complete Profile</a>
                    </div>
                @endif
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
            @if(!$preAssessment->isSubmitted())
                <h3 class="mb-0 text-dark fw-bold">Not Submitted</h3>
                <a href="{{ route('pre.assessment.show') }}" class="btn btn-primary btn-sm mt-3 w-100">Submit Now</a>
            @elseif($preAssessment->isPending())
                <h3 class="mb-0 text-warning fw-bold">Under Review</h3>
                <a href="{{ route('pre.assessment.index') }}" class="btn btn-outline-warning btn-sm mt-3 w-100">View Status</a>
            @elseif($preAssessment->isApproved())
                <h3 class="mb-0 text-success fw-bold">Approved</h3>
                <a href="{{ route('pre.assessment.index') }}" class="btn btn-outline-success btn-sm mt-3 w-100">View Status</a>
            @elseif($preAssessment->isRejected())
                <h3 class="mb-0 text-danger fw-bold">Rejected</h3>
                <a href="{{ route('pre.assessment.index') }}" class="btn btn-outline-danger btn-sm mt-3 w-100">View Status</a>
            @endif
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-light-info">
                <i class="fas fa-file-upload"></i>
            </div>
            <h5 class="text-muted font-14 mb-1">Uploaded Documents</h5>
            <h3 class="mb-0 text-dark fw-bold">{{ $documents->count() }}</h3>
            <a href="{{ route('student.profile') }}#nav-5" class="btn btn-outline-info btn-sm mt-3 w-100">Manage Documents</a>
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

@if($application)
<div class="row mb-4">
    <!-- Enrolled Course Information -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="border-left: 5px solid #2c3e7a !important;">
            <div class="card-body p-4">
                <!-- Top Header Section -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%) !important; box-shadow: 0 4px 10px rgba(44, 62, 122, 0.3);">
                            <i class="fas fa-graduation-cap fa-lg"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">Enrolled Program</span>
                            <h4 class="mb-0 fw-bold text-dark mt-1" style="font-size: 1.35rem; line-height: 1.2;">{{ $application->course->name }}</h4>
                        </div>
                    </div>
                    <div>
                        <span class="badge px-3 py-2 rounded-pill font-13 fw-bold" style="background-color: rgba(44, 62, 122, 0.1); color: #2c3e7a; border: 1px solid rgba(44, 62, 122, 0.2); font-size: 0.9rem;">
                            <i class="fas fa-barcode me-1"></i> {{ $application->course->course_code }}
                        </span>
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
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $application->course->partner_institute }}</span>
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
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $application->course->study_method }}</span>
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
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ is_numeric($application->course->duration) ? $application->course->duration . ' Years' : $application->course->duration }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Base Tuition Fee -->
                    <div class="col-md-6 col-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-danger me-3" style="width: 42px; height: 42px; background-color: rgba(220, 53, 69, 0.1);">
                                <i class="fas fa-wallet fa-lg"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Tuition Fee</small>
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ format_currency($application->total_fee, $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fees Summary Line (Row 2 - Single Horizontal Line) -->
                <div class="pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <!-- Grand Total Fee -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-primary me-2" style="width: 36px; height: 36px; background-color: rgba(44, 62, 122, 0.1);">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Grand Total Fee</small>
                                <span class="fw-bold text-primary" style="font-size: 0.9rem;">{{ format_currency($application->total_fee, $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>

                        <!-- Base Course Fee -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-secondary me-2" style="width: 36px; height: 36px; background-color: rgba(108, 117, 125, 0.1);">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Base Fee</small>
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ format_currency($application->course->fee, $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>

                        @if(($application->scholarship_amount ?? 0) > 0)
                        <!-- Scholarship -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-success me-2" style="width: 36px; height: 36px; background-color: rgba(40, 167, 69, 0.1);">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div>
                                <small class="text-success d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Scholarship</small>
                                <span class="fw-bold text-success" style="font-size: 0.9rem;">{{ format_currency(-$application->scholarship_amount, $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>

                        <!-- Net Course Fee -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-primary me-2" style="width: 36px; height: 36px; background-color: rgba(13, 110, 253, 0.1);">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Course Fee</small>
                                <span class="fw-bold text-primary" style="font-size: 0.9rem;">{{ format_currency($application->net_course_fee ?? ($application->course->fee - $application->scholarship_amount), $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Additional Costs Total -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-info me-2" style="width: 36px; height: 36px; background-color: rgba(23, 162, 184, 0.1);">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Add. Costs</small>
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ format_currency($application->additionalCosts->sum('amount'), $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>

                        <!-- Total Paid -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-success me-2" style="width: 36px; height: 36px; background-color: rgba(40, 167, 69, 0.15);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Paid</small>
                                <span class="fw-bold text-success" style="font-size: 0.9rem;">{{ format_currency($application->paid_amount, $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>

                        <!-- Balance Due -->
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center text-danger me-2" style="width: 36px; height: 36px; background-color: rgba(220, 53, 69, 0.1);">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Balance Due</small>
                                <span class="fw-bold text-danger" style="font-size: 0.9rem;">{{ format_currency(max(0, $application->total_fee - $application->paid_amount), $application->course->currency ?? 'GBP') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <!-- Payment Installments -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-alt text-primary me-2"></i> Payment Installments Schedule</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No.</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Paid Amount</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->installments as $inst)
                                <tr>
                                    <td class="ps-4 fw-semibold text-muted">
                                        Installment {{ $inst->installment_number }}
                                        @if($inst->is_invoiced)
                                            <span class="badge bg-info ms-1" title="Invoiced on {{ $inst->invoiced_at?->format('d M Y H:i') }}"><i class="fas fa-check"></i></span>
                                        @endif
                                        @if($inst->note)
                                            <div class="small text-secondary fw-normal mt-1"><i class="fas fa-info-circle me-1 text-muted"></i>{{ $inst->note }}</div>
                                        @endif
                                    </td>
                                    <td>{{ $inst->due_date ? $inst->due_date->format('d M, Y') : '-' }}</td>
                                    <td class="fw-bold">{{ format_currency($inst->amount, $application->course->currency ?? 'GBP') }}</td>
                                    <td>{{ format_currency($inst->paid_amount, $application->course->currency ?? 'GBP') }}</td>
                                    <td class="text-center">
                                        @if($inst->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($inst->status === 'partially_paid')
                                            <span class="badge bg-info text-dark">Partially Paid</span>
                                        @elseif($inst->status === 'refunded')
                                            <span class="badge bg-danger"><i class="fas fa-undo me-1"></i> Refunded</span>
                                        @elseif($inst->status === 'partially_refunded')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-undo me-1"></i> Partially Refunded</span>
                                        @else
                                            @if($inst->due_date && $inst->due_date->isPast())
                                                <span class="badge bg-danger">Overdue</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@if($application->additionalCosts->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-tags text-primary me-2"></i> Additional Costs (One-time Full Payments)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Cost Item / Description</th>
                                <th>Amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($application->additionalCosts as $cost)
                                <tr>
                                    <td class="ps-4 fw-semibold text-dark">
                                        {{ $cost->cost_name }}
                                        @if($cost->is_invoiced)
                                            <span class="badge bg-info ms-1" title="Invoiced on {{ $cost->invoiced_at?->format('d M Y H:i') }}"><i class="fas fa-check"></i></span>
                                        @endif
                                        @if($cost->note)
                                            <div class="small text-secondary fw-normal mt-1"><i class="fas fa-info-circle me-1 text-muted"></i>{{ $cost->note }}</div>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-primary">{{ format_currency($cost->amount, $application->course->currency ?? 'GBP') }}</td>
                                    <td class="text-center">
                                        @if($cost->status === 'paid')
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                        @elseif($cost->status === 'refunded')
                                            <span class="badge bg-danger"><i class="fas fa-undo me-1"></i> Refunded</span>
                                        @elseif($cost->status === 'partially_refunded')
                                            <span class="badge bg-warning text-dark"><i class="fas fa-undo me-1"></i> Partially Refunded</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if($cost->status !== 'paid' && $cost->status !== 'refunded')
                                            <button type="button" class="btn btn-sm btn-success st-pay-cost-btn"
                                                    data-id="{{ $cost->id }}"
                                                    data-name="{{ $cost->cost_name }}"
                                                    data-amount="{{ number_format($cost->amount, 2) }}"
                                                    data-currency="{{ $application->course->currency ?? 'GBP' }}">
                                                <i class="fas fa-credit-card me-1"></i> Pay Now (Full)
                                            </button>
                                        @else
                                            <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Fully Paid</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th class="ps-4 text-end">Total Additional Costs:</th>
                                <th class="fw-bold text-primary">{{ format_currency($application->additionalCosts->sum('amount'), $application->course->currency ?? 'GBP') }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endif

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-bell text-warning me-2"></i> Recent Updates</h5>
            </div>
            <div class="card-body">
                @if($preAssessment->isApproved())
                    <div class="alert alert-success border-0 mb-0">
                        <i class="mdi mdi-check-circle-outline me-1"></i> Your Pre-Assessment was approved! Your profile has been auto-populated with your details.
                    </div>
                @else
                    <p class="text-muted mb-0">No recent updates.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Student Additional Cost Pay Modal -->
<div class="modal fade" id="studentPayCostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="POST" id="studentPayCostForm">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-credit-card me-2"></i> Pay Additional Fee</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info py-2 font-13">
                        <i class="fas fa-info-circle me-1"></i> Additional costs are required to be paid in full (one-time payment).
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Fee Item / Description</label>
                        <input type="text" id="st_modal_cost_name" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Payment Amount</label>
                        <input type="text" id="st_modal_cost_amount" class="form-control bg-light fw-bold text-success" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Online Payment">Online Payment / Debit Card</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4"><i class="fas fa-lock me-1"></i> Confirm & Pay</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $(document).on('click', '.st-pay-cost-btn', function() {
        const costId = $(this).data('id');
        const costName = $(this).data('name');
        const amount = $(this).data('amount');
        const currency = $(this).data('currency');

        $('#st_modal_cost_name').val(costName);
        $('#st_modal_cost_amount').val(amount + ' ' + currency);

        const actionUrl = "{{ url('/student/additional-cost') }}/" + costId + "/pay";
        $('#studentPayCostForm').attr('action', actionUrl);

        $('#studentPayCostModal').modal('show');
    });
});
</script>
@endpush

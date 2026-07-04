@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-percentage me-2"></i>
            Setup Commission
        </h5>
        <a href="{{ route('commissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('commissions.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                
                {{-- Agent Selection --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Agent <span class="text-danger">*</span>
                    </label>
                    <select name="agent_id" id="agent_id" 
                            class="form-select @error('agent_id') is-invalid @enderror" required>
                        <option value="">Select Agent</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->agent_code }}) - 
                                {{ ucfirst(str_replace('_', ' ', $agent->agent_type)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Course Selection --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Course
                        <small class="text-muted">(Leave empty for all courses)</small>
                    </label>
                    <select name="course_id" id="course_id" 
                            class="form-select @error('course_id') is-invalid @enderror">
                        <option value="">-- All Courses (Default) --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->currency }} {{ number_format($course->fee, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Commission Type --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Commission Type <span class="text-danger">*</span>
                    </label>
                    <select name="commission_type" id="commission_type" 
                            class="form-select @error('commission_type') is-invalid @enderror" required>
                        <option value="percentage" {{ old('commission_type') == 'percentage' ? 'selected' : '' }}>
                            Percentage (%)
                        </option>
                        <option value="flat" {{ old('commission_type') == 'flat' ? 'selected' : '' }}>
                            Flat Amount
                        </option>
                    </select>
                    @error('commission_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Amount --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Amount <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" id="amount_prefix">
                            {{ old('commission_type') == 'percentage' ? '%' : '' }}
                        </span>
                        <input type="number" step="0.01" min="0" max="1000000" 
                               name="amount" id="amount" 
                               class="form-control @error('amount') is-invalid @enderror" 
                               value="{{ old('amount') }}" 
                               placeholder="0.00" required>
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        For percentage: enter value between 0-100
                    </small>
                </div>

                {{-- Currency --}}
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Currency <span class="text-danger">*</span>
                    </label>
                    <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}" {{ old('currency') == $currency ? 'selected' : '' }}>
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                    @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        System will calculate based on numerical value only
                    </small>
                </div>

                {{-- Live Preview Box --}}
                <div class="col-12">
                    <div class="alert alert-info mb-0" id="preview_box" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calculator me-2"></i>
                                <strong>Live Preview:</strong>
                                <span id="preview_text"></span>
                            </div>
                            <div class="fs-4 fw-bold text-success" id="preview_amount"></div>
                        </div>
                    </div>
                </div>

                {{-- Info Alert --}}
                <div class="col-12">
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important Notes:</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Commission will be paid in <strong>full</strong> by each student - no partial payment.</li>
                            <li>One commission setup per agent per course (or all courses).</li>
                            <li>HQ staff can override or amend commission amounts at any time.</li>
                            <li>System calculates based on numerical values only (currency prefix ignored).</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('commissions.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Commission
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commissionType = document.getElementById('commission_type');
        const amount = document.getElementById('amount');
        const amountPrefix = document.getElementById('amount_prefix');
        const courseSelect = document.getElementById('course_id');
        const previewBox = document.getElementById('preview_box');
        const previewText = document.getElementById('preview_text');
        const previewAmount = document.getElementById('preview_amount');

        // Course data (from blade)
        const courses = @json($courses->keyBy('id'));

        function updatePreview() {
            const type = commissionType.value;
            const amt = parseFloat(amount.value) || 0;
            const courseId = courseSelect.value;
            const course = courses[courseId];

            // Update prefix
            amountPrefix.textContent = type === 'percentage' ? '%' : '';

            // Percentage এর জন্য max 100
            if (type === 'percentage') {
                amount.max = 100;
            } else {
                amount.max = 1000000;
            }

            // Preview calculation
            if (amt > 0 && course) {
                let calculatedAmount;
                if (type === 'percentage') {
                    calculatedAmount = (course.fee * amt) / 100;
                    previewText.textContent = `${amt}% of ${course.currency} ${parseFloat(course.fee).toFixed(2)} =`;
                } else {
                    calculatedAmount = amt;
                    previewText.textContent = `Flat commission per student:`;
                }
                previewAmount.textContent = `${course.currency} ${calculatedAmount.toFixed(2)}`;
                previewBox.style.display = 'block';
            } else if (amt > 0 && !courseId) {
                if (type === 'flat') {
                    previewText.textContent = `Flat commission per student (any course):`;
                    previewAmount.textContent = `${amt.toFixed(2)}`;
                    previewBox.style.display = 'block';
                } else {
                    previewBox.style.display = 'none';
                }
            } else {
                previewBox.style.display = 'none';
            }
        }

        commissionType.addEventListener('change', updatePreview);
        amount.addEventListener('input', updatePreview);
        courseSelect.addEventListener('change', updatePreview);

        // Initial call
        updatePreview();
    });
</script>
@endpush
@endsection
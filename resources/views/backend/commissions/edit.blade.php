@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2"></i>
            Edit Commission
        </h5>
        <a href="{{ route('commissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('commissions.update', $commission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Agent <span class="text-danger">*</span></label>
                    <select name="agent_id" class="form-select @error('agent_id') is-invalid @enderror" required>
                        <option value="">Select Agent</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" 
                                {{ old('agent_id', $commission->agent_id) == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->agent_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Course</label>
                    <select name="course_id" class="form-select @error('course_id') is-invalid @enderror">
                        <option value="">-- All Courses (Default) --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" 
                                {{ old('course_id', $commission->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Commission Type <span class="text-danger">*</span></label>
                    <select name="commission_type" id="commission_type" 
                            class="form-select @error('commission_type') is-invalid @enderror" required>
                        <option value="percentage" {{ old('commission_type', $commission->commission_type) == 'percentage' ? 'selected' : '' }}>
                            Percentage (%)
                        </option>
                        <option value="flat" {{ old('commission_type', $commission->commission_type) == 'flat' ? 'selected' : '' }}>
                            Flat Amount
                        </option>
                    </select>
                    @error('commission_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="amount_prefix">
                            {{ old('commission_type', $commission->commission_type) == 'percentage' ? '%' : '' }}
                        </span>
                        <input type="number" step="0.01" min="0" 
                               name="amount" id="amount" 
                               class="form-control @error('amount') is-invalid @enderror" 
                               value="{{ old('amount', $commission->amount) }}" required>
                        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                    <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency }}" 
                                {{ old('currency', $commission->currency) == $currency ? 'selected' : '' }}>
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                    @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('commissions.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Commission
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

        function updatePrefix() {
            amountPrefix.textContent = commissionType.value === 'percentage' ? '%' : '';
            if (commissionType.value === 'percentage') {
                amount.max = 100;
            } else {
                amount.max = 1000000;
            }
        }

        commissionType.addEventListener('change', updatePrefix);
        updatePrefix();
    });
</script>
@endpush
@endsection
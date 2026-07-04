@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-user-plus me-2"></i> Create Agent
        </h5>
        <a href="{{ route('agents.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('agents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body">
            <div class="row g-3">

                {{-- ─── Campus & Agent Type ─────────────────────────── --}}
                @if(auth()->user()->hasRole('Super Admin'))
                <div class="col-md-6">
                    <label class="form-label">Campus <span class="text-danger">*</span></label>
                    <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror" required>
                        <option value="">Select Campus</option>
                        @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                                {{ $campus->name }} ({{ $campus->campus_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endif

                <div class="{{ auth()->user()->hasRole('Super Admin') ? 'col-md-6' : 'col-md-6' }}">
                    <label class="form-label">Agent Type <span class="text-danger">*</span></label>
                    <select name="agent_type" id="agent_type" class="form-select @error('agent_type') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        <option value="master"    {{ old('agent_type') == 'master'    ? 'selected' : '' }}>Master Agent</option>
                        <option value="sub_agent" {{ old('agent_type') == 'sub_agent' ? 'selected' : '' }}>Sub-Agent</option>
                    </select>
                    @error('agent_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6" id="parent_agent_div" style="display: none;">
                    <label class="form-label">Parent Agent (Master) <span class="text-danger">*</span></label>
                    <select name="parent_agent_id" id="parent_agent_id" class="form-select @error('parent_agent_id') is-invalid @enderror">
                        <option value="">Select Master Agent</option>
                        @foreach ($masterAgents as $master)
                            <option value="{{ $master->id }}" {{ old('parent_agent_id') == $master->id ? 'selected' : '' }}>
                                {{ $master->full_name }} ({{ $master->agent_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Agent / Promo Code</label>
                    <input type="text" name="agent_code"
                           class="form-control @error('agent_code') is-invalid @enderror"
                           value="{{ old('agent_code') }}"
                           placeholder="Leave blank to auto-generate">
                    <small class="text-muted">Used as Promo Code for student referrals.</small>
                    @error('agent_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ─── Personal Details ────────────────────────────── --}}
                <div class="col-12 mt-2">
                    <h6 class="fw-semibold text-uppercase text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.06em;">
                        <i class="fas fa-id-card me-1"></i> Agent Personal Details
                    </h6>
                    <hr class="mt-1 mb-0">
                </div>

                <div class="col-md-4">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name"
                           class="form-control @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name') }}" required>
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name"
                           class="form-control @error('middle_name') is-invalid @enderror"
                           value="{{ old('middle_name') }}">
                    @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name"
                           class="form-control @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name') }}" required>
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           value="{{ old('password') }}" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Phone with country code dropdown ──────────────────── --}}
                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <div class="input-group">
                        <select name="phone_code" id="phone_code_select"
                                class="form-select flex-grow-0 @error('phone_code') is-invalid @enderror"
                                style="max-width: 160px;"
                                title="Country Phone Code">
                            <option value="">Code</option>
                            @foreach ($countries as $country)
                                @if ($country->phone_code)
                                    <option value="{{ $country->phone_code }}"
                                            data-iso="{{ $country->iso2 }}"
                                            {{ old('phone_code') == $country->phone_code ? 'selected' : '' }}>
                                        {{ $country->iso2 }} ({{ $country->phone_code }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <input type="text" name="phone"
                               class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone') }}"
                               placeholder="e.g. 7911 123456">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <small class="text-muted">Select country code, then enter local number.</small>
                </div>

                {{-- ─── Media ───────────────────────────────────────── --}}
                <div class="col-md-6">
                    <label class="form-label">Profile Photo</label>
                    <input type="file" name="photo" accept="image/*"
                           class="form-control @error('photo') is-invalid @enderror">
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Company Logo</label>
                    <input type="file" name="logo" accept="image/*"
                           class="form-control @error('logo') is-invalid @enderror">
                    @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ─── Status ──────────────────────────────────────── --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active"   {{ old('status', 'active') == 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="card-footer text-end py-2">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save me-1"></i> Save Agent
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ── Agent Type toggle for Parent Agent field ─────────────
        const agentTypeSelect  = document.getElementById('agent_type');
        const parentAgentDiv   = document.getElementById('parent_agent_div');
        const parentAgentSelect = document.getElementById('parent_agent_id');

        function toggleParentAgent() {
            if (agentTypeSelect.value === 'sub_agent') {
                parentAgentDiv.style.display = 'block';
                parentAgentSelect.setAttribute('required', 'required');
            } else {
                parentAgentDiv.style.display = 'none';
                parentAgentSelect.removeAttribute('required');
                parentAgentSelect.value = '';
            }
        }

        agentTypeSelect.addEventListener('change', toggleParentAgent);
        toggleParentAgent(); // run on page load for old() values

    });
</script>
@endpush
@endsection
@extends('layouts.backend_master')

@push('css')
<style>
    .password-wrapper {
        position: relative;
    }
    .password-wrapper input {
        padding-right: 40px;
    }
    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        background: none;
        border: none;
        padding: 0;
        font-size: 1.1rem;
        z-index: 10;
    }
    .password-toggle:hover {
        color: #0d6efd;
    }
    .current-photo {
        max-width: 100px;
        max-height: 100px;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }
    .promo-code-display {
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 6px;
        border-left: 4px solid #0d6efd;
        font-family: 'Courier New', monospace;
        font-weight: bold;
        letter-spacing: 1px;
    }
</style>
@endpush

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-user-edit me-2"></i>
            Edit Agent: {{ $agent->name }}
        </h5>
        <a href="{{ route('agents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="row g-3">
                
                {{-- Campus Selection (Only for Super Admin) --}}
                @if(auth()->user()->hasRole('Super Admin'))
                <div class="col-md-6">
                    <label class="form-label">Campus <span class="text-danger">*</span></label>
                    <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror" required>
                        <option value="">Select Campus</option>
                        @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}" 
                                {{ old('campus_id', $agent->campus_id) == $campus->id ? 'selected' : '' }}>
                                {{ $campus->name }} ({{ $campus->campus_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                @endif

                {{-- Agent Type --}}
                <div class="col-md-6">
                    <label class="form-label">Agent Type <span class="text-danger">*</span></label>
                    <select name="agent_type" id="agent_type" class="form-select @error('agent_type') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        <option value="master" {{ old('agent_type', $agent->agent_type) == 'master' ? 'selected' : '' }}>Master Agent</option>
                        <option value="sub_agent" {{ old('agent_type', $agent->agent_type) == 'sub_agent' ? 'selected' : '' }}>Sub-Agent</option>
                    </select>
                    @error('agent_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Parent Agent (For Sub-Agent) --}}
                <div class="col-md-6" id="parent_agent_div" style="display: {{ old('agent_type', $agent->agent_type) == 'sub_agent' ? 'block' : 'none' }};">
                    <label class="form-label">Parent Agent (Master) <span class="text-danger">*</span></label>
                    <select name="parent_agent_id" id="parent_agent_id" class="form-select @error('parent_agent_id') is-invalid @enderror">
                        <option value="">Select Master Agent</option>
                        @foreach ($masterAgents as $master)
                            <option value="{{ $master->id }}" 
                                {{ old('parent_agent_id', $agent->parent_agent_id) == $master->id ? 'selected' : '' }}>
                                {{ $master->name }} ({{ $master->agent_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('parent_agent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Promo Code (Read-only Info + Optional Edit) --}}
                <div class="col-md-6">
                    <label class="form-label">Promo Code / Agent Code</label>
                    <div class="promo-code-display mb-2">
                        <i class="fas fa-ticket-alt me-2 text-primary"></i>
                        Current: <span class="text-primary">{{ $agent->agent_code }}</span>
                    </div>
                    <input type="text" name="agent_code" class="form-control @error('agent_code') is-invalid @enderror" 
                           value="{{ old('agent_code', $agent->agent_code) }}" 
                           placeholder="Leave unchanged to keep current code">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        ⚠️ Changing this code will affect students who used it for registration.
                    </small>
                    @error('agent_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Personal Information Section --}}
                <div class="col-12">
                    <hr>
                    <h6 class="fw-semibold text-uppercase text-muted mb-3">
                        <i class="fas fa-user me-2"></i> Personal Information
                    </h6>
                </div>

                <div class="col-md-4">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', $agent->first_name) }}" required>
                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" 
                           value="{{ old('middle_name', $agent->middle_name) }}">
                    @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                           value="{{ old('last_name', $agent->last_name) }}" required>
                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $agent->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Phone Code</label>
                    <input type="text" name="phone_code" class="form-control @error('phone_code') is-invalid @enderror" 
                           value="{{ old('phone_code', $agent->phone_code) }}" placeholder="+880">
                    @error('phone_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $agent->phone) }}" placeholder="01700000000">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Photo & Logo Section --}}
                <div class="col-12">
                    <hr>
                    <h6 class="fw-semibold text-uppercase text-muted mb-3">
                        <i class="fas fa-images me-2"></i> Photo & Logo
                    </h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Profile Photo</label>
                    @if($agent->photo)
                        <div class="mb-2">
                            <img src="{{ Storage::url($agent->photo) }}" alt="Current Photo" class="current-photo">
                            <small class="d-block text-muted mt-1">Current photo</small>
                        </div>
                    @endif
                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Leave empty to keep current photo</small>
                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Company Logo</label>
                    @if($agent->logo)
                        <div class="mb-2">
                            <img src="{{ Storage::url($agent->logo) }}" alt="Current Logo" class="current-photo">
                            <small class="d-block text-muted mt-1">Current logo</small>
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Leave empty to keep current logo</small>
                    @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $agent->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $agent->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('agents.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Agent
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const agentTypeSelect = document.getElementById('agent_type');
        const parentAgentDiv = document.getElementById('parent_agent_div');
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

        // Initial check on page load
        toggleParentAgent(); 
    });
</script>
@endpush
@endsection
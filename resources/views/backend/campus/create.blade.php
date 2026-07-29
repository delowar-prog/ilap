@extends('layouts.backend_master')

@section('admin_contents')

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>
            Create Campus
        </h5>
        <a href="{{ route('campuses.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <form action="{{ route('campuses.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- Hidden defaults for currency & timezone (campus DB defaults) --}}
        <input type="hidden" name="currency" value="GBP">
        <input type="hidden" name="timezone" value="Europe/London">

        <div class="card-body">

            <div class="row g-3">

                {{-- ─── Campus Info ─────────────────────────────────── --}}
                <div class="col-12">
                    <h6 class="fw-semibold text-uppercase text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.06em;">
                        <i class="fas fa-university me-1"></i> Campus Information
                    </h6>
                    <hr class="mt-1 mb-0">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Campus Type <span class="text-danger">*</span></label>
                    <select name="campus_type" class="form-select @error('campus_type') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        @foreach($campusTypes as $type)
                            <option value="{{ $type }}" {{ old('campus_type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('campus_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Campus Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Campus Code <span class="text-danger">*</span></label>
                    <input type="text"
                           name="campus_code"
                           class="form-control @error('campus_code') is-invalid @enderror"
                           value="{{ old('campus_code') }}"
                           required>
                    @error('campus_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address"
                              rows="2"
                              class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Location Selector (now handles Post Code internally for perfect alignment) --}}
                <div class="col-md-12">
                    <livewire:geo.location-selector 
                        :showPostCode="true"
                        :initialPostCode="old('post_code')"
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Campus Phone</label>
                    <input type="text"
                           name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}"
                           placeholder="+44 20 1234 5678">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Campus Email</label>
                    <input type="email"
                           name="campus_email"
                           class="form-control @error('campus_email') is-invalid @enderror"
                           value="{{ old('campus_email') }}"
                           placeholder="campus@example.com">
                    @error('campus_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Logo</label>
                    <input type="file"
                           name="logo"
                           class="form-control @error('logo') is-invalid @enderror"
                           accept="image/*">
                    @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>


                <div class="col-md-6">
                    <label class="form-label">Website Link</label>
                    <input type="url"
                           name="website_link"
                           class="form-control @error('website_link') is-invalid @enderror"
                           value="{{ old('website_link') }}"
                           placeholder="https://example.com">
                    @error('website_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Note</label>
                    <textarea name="note"
                              rows="2"
                              class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                    @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ─── Campus Head (Admin User) ─────────────────────── --}}
                <div class="col-12 mt-2">
                    <h6 class="fw-semibold text-uppercase text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.06em;">
                        <i class="fas fa-user-shield me-1"></i> Campus Head Account
                    </h6>
                    <hr class="mt-1 mb-0">
                </div>

                <div class="col-md-4">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="user_first_name"
                           class="form-control @error('user_first_name') is-invalid @enderror"
                           value="{{ old('user_first_name') }}"
                           required>
                    @error('user_first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text"
                           name="user_middle_name"
                           class="form-control @error('user_middle_name') is-invalid @enderror"
                           value="{{ old('user_middle_name') }}">
                    @error('user_middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="user_last_name"
                           class="form-control @error('user_last_name') is-invalid @enderror"
                           value="{{ old('user_last_name') }}"
                           required>
                    @error('user_last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Admin Email <span class="text-danger">*</span></label>
                    <input type="email"
                           name="user_email"
                           class="form-control @error('user_email') is-invalid @enderror"
                           value="{{ old('user_email') }}"
                           required>
                    @error('user_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirm Admin Email <span class="text-danger">*</span></label>
                    <input type="email"
                           name="user_email_confirmation"
                           class="form-control"
                           value="{{ old('user_email_confirmation') }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Admin Phone</label>
                    <input type="text"
                           name="user_phone"
                           class="form-control @error('user_phone') is-invalid @enderror"
                           value="{{ old('user_phone') }}"
                           placeholder="+880 1700 000000">
                    @error('user_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <div class="input-group has-validation">
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Campus
            </button>
        </div>

    </form>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endpush

@endsection
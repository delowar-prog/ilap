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
          enctype="multipart/form-data"
          x-data="{
              name: '',
              countryIso2: '',
              campusNumber: {{ $nextCampusNumber }},
              get campusCode() {
                  if (!this.name) return 'Will be auto-generated';
                  let cleanName = this.name.replace(/[^A-Za-z0-9\s]/g, '');
                  let words = cleanName.trim().split(/\s+/).filter(w => w.length > 0);
                  let abbr = '';
                  if (words.length === 0) {
                      abbr = 'XXX';
                  } else if (words.length === 1) {
                      abbr = words[0].substring(0, 3).toUpperCase();
                  } else if (words.length === 2) {
                      let w1 = words[0].toUpperCase();
                      let w2 = words[1].toUpperCase();
                      abbr = w1.charAt(0) + w2.charAt(0) + w2.charAt(w2.length - 1);
                  } else {
                      abbr = (words[0].charAt(0) + words[1].charAt(0) + words[2].charAt(0)).toUpperCase();
                  }
                  while (abbr.length < 3) {
                      abbr += 'X';
                  }
                  let iso = this.countryIso2 ? this.countryIso2.toUpperCase() : 'XX';
                  return iso + abbr + 'C' + this.campusNumber;
              }
          }"
          @country-selected.window="countryIso2 = $event.detail.iso2">

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

                <div class="col-md-6">
                    <label class="form-label">Campus Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           x-model="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Campus Code <span class="text-muted">(Preview)</span></label>
                    <input type="text"
                           class="form-control"
                           style="background-color: #e9ecef; font-family: monospace; font-weight: bold; letter-spacing: 0.5px;"
                           x-bind:value="campusCode"
                           disabled
                           readonly>
                </div>

                {{-- Location Selector (submits hidden country & city fields) --}}
                <livewire:geo.location-selector />

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
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address"
                              rows="2"
                              class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    <label class="form-label">Admin Phone</label>
                    <input type="text"
                           name="user_phone"
                           class="form-control @error('user_phone') is-invalid @enderror"
                           value="{{ old('user_phone') }}"
                           placeholder="+880 1700 000000">
                    @error('user_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

@endsection
@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2"></i>
            Create Institute
        </h5>
        <a href="{{ route('institutes.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <form action="{{ route('institutes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row g-3">

                {{-- ─── Basic Info ─── --}}
                <div class="col-12">
                    <h6 class="fw-semibold text-uppercase text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.06em;">
                        <i class="fas fa-university me-1"></i> Institute Information
                    </h6>
                    <hr class="mt-1 mb-0">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Institute Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Code</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">EIIN</label>
                    <input type="text" name="eiin" class="form-control @error('eiin') is-invalid @enderror" value="{{ old('eiin') }}">
                    @error('eiin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Registration Number</label>
                    <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ old('registration_number') }}">
                    @error('registration_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Institute Type</label>
                    <input type="text" name="institute_type" class="form-control @error('institute_type') is-invalid @enderror" value="{{ old('institute_type') }}" placeholder="e.g. University, College">
                    @error('institute_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Established Year</label>
                    <input type="number" name="established_year" class="form-control @error('established_year') is-invalid @enderror" value="{{ old('established_year') }}" placeholder="e.g. 1998">
                    @error('established_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website') }}" placeholder="https://example.com">
                    @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ─── Location ─── --}}
                <div class="col-12 mt-2">
                    <h6 class="fw-semibold text-uppercase text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.06em;">
                        <i class="fas fa-map-marker-alt me-1"></i> Location
                    </h6>
                    <hr class="mt-1 mb-0">
                </div>

                {{-- Livewire Location Selector (Country → State → City dropdown) --}}
                <livewire:geo.location-selector />

                <div class="col-md-6">
                    <label class="form-label">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control @error('postal_code') is-invalid @enderror" value="{{ old('postal_code') }}">
                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ─── Media / Images ─── --}}
                <div class="col-12 mt-2">
                    <h6 class="fw-semibold text-uppercase text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 0.06em;">
                        <i class="fas fa-images me-1"></i> Media
                    </h6>
                    <hr class="mt-1 mb-0">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Max 2MB. Accepted: jpeg, png, jpg, gif, svg</small>
                    @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Institute Images <span class="text-muted">(Multiple)</span></label>
                    <input type="file" name="institute_images[]" class="form-control @error('institute_images.*') is-invalid @enderror" accept="image/*" multiple>
                    <small class="text-muted">You can select multiple images at once. Max 2MB each.</small>
                    @error('institute_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Image Preview --}}
                <div class="col-12" id="imagePreviewContainer" style="display:none;">
                    <label class="form-label">Selected Images Preview</label>
                    <div id="imagePreviewRow" class="d-flex flex-wrap gap-2"></div>
                </div>

            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Institute
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelector('input[name="institute_images[]"]').addEventListener('change', function(e) {
        const container = document.getElementById('imagePreviewContainer');
        const row = document.getElementById('imagePreviewRow');
        row.innerHTML = '';
        const files = e.target.files;
        if (files.length > 0) {
            container.style.display = 'block';
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.style.cssText = 'width:80px; height:80px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6;';
                    row.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.style.display = 'none';
        }
    });
</script>
@endsection

@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Course</h5>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            
            {{-- Course Type Section --}}
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Course Type:</strong> Select whether this is an iLAP own course or from an external institute.
            </div>

            <div class="row g-3">
                
                {{-- Course Ownership --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Course Ownership <span class="text-danger">*</span></label>
                    <select name="is_ilap_course" id="is_ilap_course" 
                            class="form-select @error('is_ilap_course') is-invalid @enderror" required>
                        <option value="1" {{ old('is_ilap_course', $course->is_ilap_course) == '1' ? 'selected' : '' }}>
                            🏠 iLAP Own Course
                        </option>
                        <option value="0" {{ old('is_ilap_course', $course->is_ilap_course) == '0' ? 'selected' : '' }}>
                            🏫 External Institute Course
                        </option>
                    </select>
                    @error('is_ilap_course') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Partner Institute (for external courses) --}}
                <div class="col-md-6" id="partner_institute_div">
                    <label class="form-label fw-semibold">Partner Institute <span class="text-danger">*</span></label>
                    <input type="text" name="partner_institute" 
                           class="form-control @error('partner_institute') is-invalid @enderror" 
                           value="{{ old('partner_institute', $course->partner_institute) }}" 
                           placeholder="e.g., University of Oxford">
                    @error('partner_institute') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6" id="institute_country_div">
                    <label class="form-label">Institute Country</label>
                    <input type="text" name="institute_country" 
                           class="form-control @error('institute_country') is-invalid @enderror" 
                           value="{{ old('institute_country', $course->institute_country) }}" 
                           placeholder="e.g., United Kingdom">
                    @error('institute_country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6" id="institute_website_div">
                    <label class="form-label">Institute Website</label>
                    <input type="url" name="institute_website" 
                           class="form-control @error('institute_website') is-invalid @enderror" 
                           value="{{ old('institute_website', $course->institute_website) }}" 
                           placeholder="https://www.ox.ac.uk">
                    @error('institute_website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">📚 Course Details</h6></div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Course Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $course->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Course Code</label>
                    <input type="text" name="course_code" 
                           class="form-control @error('course_code') is-invalid @enderror" 
                           value="{{ old('course_code', $course->course_code) }}" 
                           placeholder="Auto-generated if empty">
                    @error('course_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3">{{ old('description', $course->description) }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category', $course->category) == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach($levels as $lvl)
                            <option value="{{ $lvl }}" {{ old('level', $course->level) == $lvl ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $lvl)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Subject Area</label>
                    <input type="text" name="subject_area" class="form-control" 
                           value="{{ old('subject_area', $course->subject_area) }}" placeholder="e.g., Business, IT">
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">⏱️ Duration & Mode</h6></div>

                <div class="col-md-4">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" 
                           value="{{ old('duration', $course->duration) }}" placeholder="e.g., 1 year, 6 months">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Duration (Months)</label>
                    <input type="number" name="duration_months" class="form-control" 
                           value="{{ old('duration_months', $course->duration_months) }}" min="1">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Study Method</label>
                    <select name="study_method" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach($studyMethods as $method)
                            <option value="{{ $method }}" {{ old('study_method', $course->study_method) == $method ? 'selected' : '' }}>
                                {{ $method }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">💰 Fees</h6></div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Course Fee <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="fee" 
                           class="form-control @error('fee') is-invalid @enderror" 
                           value="{{ old('fee', $course->fee) }}" required>
                    @error('fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                    <select name="currency" class="form-select" required>
                        @foreach($currencies as $cur)
                            <option value="{{ $cur }}" {{ old('currency', $course->currency) == $cur ? 'selected' : '' }}>
                                {{ $cur }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Application Fee</label>
                    <input type="number" step="0.01" name="application_fee" 
                           class="form-control" value="{{ old('application_fee', $course->application_fee) }}">
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">📅 Intake & Requirements</h6></div>

                <div class="col-md-4">
                    <label class="form-label">Intake</label>
                    <select name="intake" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach($intakes as $intake)
                            <option value="{{ $intake }}" {{ old('intake', $course->intake) == $intake ? 'selected' : '' }}>
                                {{ $intake }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="application_deadline" class="form-control" 
                           value="{{ old('application_deadline', $course->application_deadline ? (is_string($course->application_deadline) ? date('Y-m-d', strtotime($course->application_deadline)) : $course->application_deadline->format('Y-m-d')) : '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">IELTS Required</label>
                    <input type="number" step="0.5" min="0" max="9" name="ielts_required" 
                           class="form-control" value="{{ old('ielts_required', $course->ielts_required) }}" placeholder="e.g., 6.5">
                </div>

                <div class="col-12">
                    <label class="form-label">Entry Requirements</label>
                    <textarea name="entry_requirements" class="form-control" rows="2">{{ old('entry_requirements', $course->entry_requirements) }}</textarea>
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">📁 Media & Visibility</h6></div>

                <div class="col-md-6">
                    <label class="form-label">Thumbnail Image</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    @if($course->thumbnail)
                        <div class="mt-2">
                            <img src="{{ Storage::url($course->thumbnail) }}" alt="Thumbnail" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label">Course Brochure (PDF)</label>
                    <input type="file" name="brochure" class="form-control" accept=".pdf,.doc,.docx">
                    @if($course->brochure_path)
                        <div class="mt-2">
                            <a href="{{ Storage::url($course->brochure_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file-pdf me-1"></i> View Current Brochure
                            </a>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" 
                           value="{{ old('sort_order', $course->sort_order) }}">
                </div>

                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <input type="checkbox" name="is_featured" value="1" 
                               class="form-check-input" id="is_featured"
                               {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Featured Course
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <input type="checkbox" name="is_available_for_admission" value="1" 
                               class="form-check-input" id="is_available"
                               {{ old('is_available_for_admission', $course->is_available_for_admission) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">
                            Available for Admission
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $course->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $course->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="archived" {{ old('status', $course->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Course
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const courseType = document.getElementById('is_ilap_course');
    const partnerDiv = document.getElementById('partner_institute_div');
    const countryDiv = document.getElementById('institute_country_div');
    const websiteDiv = document.getElementById('institute_website_div');

    function togglePartnerFields() {
        const isExternal = courseType.value === '0';
        partnerDiv.style.display = isExternal ? 'block' : 'none';
        countryDiv.style.display = isExternal ? 'block' : 'none';
        websiteDiv.style.display = isExternal ? 'block' : 'none';
        
        // Make partner_institute required for external courses
        const partnerInput = partnerDiv.querySelector('input');
        if (isExternal) {
            partnerInput.setAttribute('required', 'required');
        } else {
            partnerInput.removeAttribute('required');
        }
    }

    courseType.addEventListener('change', togglePartnerFields);
    togglePartnerFields();
});
</script>
@endpush
@endsection

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

                <div class="col-12 mt-4"><hr><h6 class="fw-bold">📚 Course Modules</h6></div>
                <div class="col-12">
                    <div id="course_modules_container">
                        @if($course->modules && $course->modules->count() > 0)
                            @foreach($course->modules as $index => $module)
                            <div class="row g-2 mb-2 align-items-center module-row">
                                <input type="hidden" name="modules[{{$index}}][id]" value="{{ $module->id }}">
                                <div class="col-md-2">
                                    <label class="form-label mb-0">Code</label>
                                    <input type="text" name="modules[{{$index}}][code]" class="form-control form-control-sm" placeholder="Module Code" value="{{ $module->code }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label mb-0">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="modules[{{$index}}][title]" class="form-control form-control-sm" placeholder="Module Title" required value="{{ $module->title }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label mb-0">Credit</label>
                                    <input type="text" name="modules[{{$index}}][credit]" class="form-control form-control-sm" placeholder="Credit" value="{{ $module->credit }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label mb-0" title="Guided Learning Hours">GLH</label>
                                    <input type="text" name="modules[{{$index}}][glh]" class="form-control form-control-sm" placeholder="GLH" value="{{ $module->glh }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mb-0">Type</label><br>
                                    <div class="form-check form-check-inline mt-1" title="Mandatory">
                                        <input class="form-check-input" type="radio" name="modules[{{$index}}][is_mandatory]" id="mand_{{$index}}" value="1" {{ $module->is_mandatory ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mand_{{$index}}">M</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-1" title="Optional">
                                        <input class="form-check-input" type="radio" name="modules[{{$index}}][is_mandatory]" id="opt_{{$index}}" value="0" {{ !$module->is_mandatory ? 'checked' : '' }}>
                                        <label class="form-check-label" for="opt_{{$index}}">O</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label mb-0">Priority</label>
                                    <input type="number" name="modules[{{$index}}][priority]" class="form-control form-control-sm" placeholder="Priority" value="{{ $module->priority }}">
                                </div>
                                <div class="col-md-1 text-center">
                                    <label class="form-label mb-0 d-block">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-sm remove-module-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="row g-2 mb-2 align-items-center module-row">
                                <div class="col-md-2">
                                    <label class="form-label mb-0">Code</label>
                                    <input type="text" name="modules[0][code]" class="form-control form-control-sm" placeholder="Module Code">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label mb-0">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="modules[0][title]" class="form-control form-control-sm" placeholder="Module Title" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label mb-0">Credit</label>
                                    <input type="text" name="modules[0][credit]" class="form-control form-control-sm" placeholder="Credit">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label mb-0" title="Guided Learning Hours">GLH</label>
                                    <input type="text" name="modules[0][glh]" class="form-control form-control-sm" placeholder="GLH">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mb-0">Type</label><br>
                                    <div class="form-check form-check-inline mt-1" title="Mandatory">
                                        <input class="form-check-input" type="radio" name="modules[0][is_mandatory]" id="mand_0" value="1" checked>
                                        <label class="form-check-label" for="mand_0">M</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-1" title="Optional">
                                        <input class="form-check-input" type="radio" name="modules[0][is_mandatory]" id="opt_0" value="0">
                                        <label class="form-check-label" for="opt_0">O</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label mb-0">Priority</label>
                                    <input type="number" name="modules[0][priority]" class="form-control form-control-sm" placeholder="Priority" value="0">
                                </div>
                                <div class="col-md-1 text-center">
                                    <label class="form-label mb-0 d-block">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-sm remove-module-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add_more_module_btn" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Add More Module</button>
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

                <div class="col-md-12 mt-3">
                    <label class="form-label fw-bold">Course Brochures</label>
                    <div id="course_brochures_container">
                        @if($course->brochures->count() > 0)
                            @foreach($course->brochures as $index => $brochure)
                                <div class="row g-2 mb-2 align-items-center brochure-row mt-2">
                                    <input type="hidden" name="brochures[{{$index}}][id]" value="{{ $brochure->id }}">
                                    <div class="col-md-4">
                                        <label class="form-label mb-0">Brochure Title</label>
                                        <input type="text" name="brochures[{{$index}}][title]" class="form-control form-control-sm" placeholder="e.g. Course Syllabus" value="{{ $brochure->title }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label mb-0">Upload PDF</label>
                                        <input type="file" name="brochures[{{$index}}][file]" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                                        <small class="text-muted mt-1 d-block">Current: <a href="{{ Storage::url($brochure->file_path) }}" target="_blank">View File</a></small>
                                    </div>
                                    <div class="col-md-1 text-center mt-4">
                                        <button type="button" class="btn btn-danger btn-sm remove-brochure-btn"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row g-2 mb-2 align-items-center brochure-row mt-2">
                                <div class="col-md-4">
                                    <label class="form-label mb-0">Brochure Title</label>
                                    <input type="text" name="brochures[0][title]" class="form-control form-control-sm" placeholder="e.g. Course Syllabus">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label mb-0">Upload PDF</label>
                                    <input type="file" name="brochures[0][file]" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                                </div>
                                <div class="col-md-1 text-center mt-4">
                                    <button type="button" class="btn btn-danger btn-sm remove-brochure-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add_more_brochure_btn" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Add More Brochure</button>
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

    // Module dynamic rows
    let moduleIndex = {{ isset($course) && $course->modules ? max(1, $course->modules->count()) : 1 }};
    document.getElementById('add_more_module_btn').addEventListener('click', function() {
        const container = document.getElementById('course_modules_container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center module-row mt-2';
        row.innerHTML = `
            <div class="col-md-2">
                <input type="text" name="modules[${moduleIndex}][code]" class="form-control form-control-sm" placeholder="Module Code">
            </div>
            <div class="col-md-4">
                <input type="text" name="modules[${moduleIndex}][title]" class="form-control form-control-sm" placeholder="Module Title" required>
            </div>
            <div class="col-md-1">
                <input type="text" name="modules[${moduleIndex}][credit]" class="form-control form-control-sm" placeholder="Credit">
            </div>
            <div class="col-md-1">
                <input type="text" name="modules[${moduleIndex}][glh]" class="form-control form-control-sm" placeholder="GLH">
            </div>
            <div class="col-md-2">
                <div class="form-check form-check-inline" title="Mandatory">
                    <input class="form-check-input" type="radio" name="modules[${moduleIndex}][is_mandatory]" id="mand_${moduleIndex}" value="1" checked>
                    <label class="form-check-label" for="mand_${moduleIndex}">M</label>
                </div>
                <div class="form-check form-check-inline" title="Optional">
                    <input class="form-check-input" type="radio" name="modules[${moduleIndex}][is_mandatory]" id="opt_${moduleIndex}" value="0">
                    <label class="form-check-label" for="opt_${moduleIndex}">O</label>
                </div>
            </div>
            <div class="col-md-1">
                <input type="number" name="modules[${moduleIndex}][priority]" class="form-control form-control-sm" placeholder="Priority" value="${moduleIndex}">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-module-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        moduleIndex++;
    });

    document.getElementById('course_modules_container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-module-btn') || e.target.closest('.remove-module-btn')) {
            const btn = e.target.classList.contains('remove-module-btn') ? e.target : e.target.closest('.remove-module-btn');
            btn.closest('.module-row').remove();
        }
    });

    // Brochure dynamic rows
    let brochureIndex = {{ $course->brochures->count() > 0 ? $course->brochures->count() : 1 }};
    document.getElementById('add_more_brochure_btn').addEventListener('click', function() {
        const container = document.getElementById('course_brochures_container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center brochure-row mt-2';
        row.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="brochures[${brochureIndex}][title]" class="form-control form-control-sm" placeholder="e.g. Course Syllabus">
            </div>
            <div class="col-md-5">
                <input type="file" name="brochures[${brochureIndex}][file]" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-brochure-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        brochureIndex++;
    });

    document.getElementById('course_brochures_container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-brochure-btn') || e.target.closest('.remove-brochure-btn')) {
            const btn = e.target.classList.contains('remove-brochure-btn') ? e.target : e.target.closest('.remove-brochure-btn');
            btn.closest('.brochure-row').remove();
        }
    });
});
</script>
@endpush
@endsection

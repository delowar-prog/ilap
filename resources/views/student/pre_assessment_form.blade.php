@extends('layouts.backend_master')
@section('title', 'Pre-Assessment Form')

@section('admin_contents')
<div class="row justify-content-center">
    <div class="col-12 col-xl-11">
        


        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-white"><i class="mdi mdi-clipboard-text-outline me-1"></i> Student Pre-Assessment</h4>
                <p class="mb-0 font-13 mt-1 text-white-50">Please complete all required fields accurately. This information will be reviewed by our admissions team.</p>
            </div>
            
            <div class="card-body p-4">
                
                <form method="POST" action="{{ route('pre.assessment.update') }}" id="assessForm">
                    @csrf
                    @method('PUT')

                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-justified bg-light p-1 rounded mb-4" id="assessmentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                <span class="d-none d-sm-block">1. Personal Info</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                <span class="d-none d-sm-block">2. Academic Background</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="mdi mdi-earth"></i></span>
                                <span class="d-none d-sm-block">3. Study Plan</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        
                        {{-- ═══ STEP 1: Personal Information ═══ --}}
                        <div class="tab-pane active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Personal Information</h5>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $assessment->first_name ?? $student->first_name) }}" placeholder="First Name" required />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name <small class="text-muted">(Optional)</small></label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ old('middle_name', $assessment->middle_name ?? $student->middle_name) }}" placeholder="Middle Name" />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="surname" class="form-label">Surname / Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="surname" id="surname" value="{{ old('surname', $assessment->surname ?? $student->surname) }}" placeholder="Surname" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="contact_number" id="contact_number" value="{{ old('contact_number', $assessment->contact_number ?? $student->phone) }}" placeholder="+44 7700 900077" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address (Read Only)</label>
                                    <input type="email" class="form-control" value="{{ $student->email }}" disabled />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" id="dob" value="{{ old('dob', optional($assessment->dob ?? $student->dob)->format('Y-m-d')) }}" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="passport_number" class="form-label">Passport Number <small class="text-muted">(Optional)</small></label>
                                    <input type="text" class="form-control" name="passport_number" id="passport_number" value="{{ old('passport_number', $assessment->passport_number) }}" placeholder="e.g. A0123456" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">Select Gender...</option>
                                        @foreach(['Male','Female','Prefer not to say'] as $opt)
                                            <option value="{{ $opt }}" {{ old('gender', $assessment->gender ?? $student->gender) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nationality" id="nationality" value="{{ old('nationality', $assessment->nationality ?? $student->nationality) }}" placeholder="e.g. British" required />
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label mb-2">Full Contact Address <span class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="contact_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="contact_address" id="contact_address" value="{{ old('contact_address', $assessment->contact_address) }}" placeholder="Street Address (e.g. 123 Main St, Apt 4B)" required />
                                        </div>
                                        <div class="col-md-12">
                                            <label for="postal_code" class="form-label">Postal / Zip Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="postal_code" id="postal_code" value="{{ old('postal_code', $assessment->postal_code) }}" placeholder="Postal / Zip Code" required />
                                        </div>
                                        <div class="col-md-12">
                                            <livewire:geo.location-selector 
                                                :initialCountry="old('country', $assessment->country ?? $student->country?->name)" 
                                                :initialState="old('state', $assessment->state)" 
                                                :initialCity="old('city', $assessment->city)" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-primary next-step" data-next="#step2-tab">Next Step <i class="mdi mdi-arrow-right ms-1"></i></button>
                            </div>
                        </div>

                        {{-- ═══ STEP 2: Academic Background ═══ --}}
                        <div class="tab-pane" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-school me-1"></i> Academic Background</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    @php
                                        $currentQual = old('highest_qualification', $assessment->highest_qualification);
                                        $isOther = !empty($currentQual) && !in_array($currentQual, $qualificationOptions);
                                    @endphp
                                    <label class="form-label">Highest Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select" name="highest_qualification" id="highest_qualification_select" required>
                                        <option value="">Select Qualification...</option>
                                        @foreach($qualificationOptions as $opt)
                                            <option value="{{ $opt }}" {{ $currentQual == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                        <option value="Other" {{ (old('highest_qualification') == 'Other' || $isOther) ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <div id="highest_qualification_other_div" class="mt-2" style="display: {{ (old('highest_qualification') == 'Other' || $isOther) ? 'block' : 'none' }};">
                                        <label for="highest_qualification_other" class="form-label font-12 text-muted mb-1">Please specify qualification <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="highest_qualification_other" id="highest_qualification_other" value="{{ old('highest_qualification_other', $isOther ? $currentQual : '') }}" placeholder="Enter your qualification" />
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name_of_institution" class="form-label">Name of Institution <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_of_institution" id="name_of_institution" value="{{ old('name_of_institution', $assessment->name_of_institution) }}" placeholder="e.g. Cardiff High School" required />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="year_of_passing" class="form-label">Year of Passing <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="year_of_passing" id="year_of_passing" value="{{ old('year_of_passing', $assessment->year_of_passing) }}" placeholder="e.g. 2022" required />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="grades_gpa" class="form-label">Grade / GPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="grades_gpa" id="grades_gpa" value="{{ old('grades_gpa', $assessment->grades_gpa) }}" placeholder="e.g. 3.8 / 4.0 or A,B,C" required />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="field_of_study" class="form-label">Field of Study</label>
                                    <input type="text" class="form-control" name="field_of_study" id="field_of_study" value="{{ old('field_of_study', $assessment->field_of_study) }}" placeholder="e.g. Computer Science" />
                                </div>

                                @php
                                    $additionalQuals = old('additional_qualifications', $assessment->additional_qualifications);
                                    if (empty($additionalQuals)) {
                                        if (!empty($assessment->second_qualification)) {
                                            $additionalQuals = [
                                                [
                                                    'qualification' => $assessment->second_qualification,
                                                    'institution' => $assessment->second_institution,
                                                    'year_of_passing' => $assessment->second_year_of_passing,
                                                ]
                                            ];
                                        } else {
                                            $additionalQuals = [];
                                        }
                                    }
                                @endphp

                                <div id="additional_qualifications_container" class="w-100 row p-0 m-0">
                                    @foreach($additionalQuals as $index => $qual)
                                        <div class="row p-0 m-0 qualification-row mb-3" id="qualification_row_{{ $index }}">
                                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Additional Educational Qualification</h6>
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQualificationRow({{ $index }})">
                                                    <i class="mdi mdi-close me-1"></i> Remove
                                                </button>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="additional_qualifications_{{ $index }}_qualification" class="form-label">Qualification Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[{{ $index }}][qualification]" id="additional_qualifications_{{ $index }}_qualification" value="{{ old('additional_qualifications.' . $index . '.qualification', $qual['qualification'] ?? '') }}" placeholder="e.g. GCSE / A-Level" required />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="additional_qualifications_{{ $index }}_institution" class="form-label">Institution Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[{{ $index }}][institution]" id="additional_qualifications_{{ $index }}_institution" value="{{ old('additional_qualifications.' . $index . '.institution', $qual['institution'] ?? '') }}" placeholder="e.g. High School" required />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="additional_qualifications_{{ $index }}_year" class="form-label">Year of Passing <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[{{ $index }}][year_of_passing]" id="additional_qualifications_{{ $index }}_year" value="{{ old('additional_qualifications.' . $index . '.year_of_passing', $qual['year_of_passing'] ?? '') }}" placeholder="e.g. 2020" required />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="additional_qualifications_{{ $index }}_grades_gpa" class="form-label">Grade / GPA <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[{{ $index }}][grades_gpa]" id="additional_qualifications_{{ $index }}_grades_gpa" value="{{ old('additional_qualifications.' . $index . '.grades_gpa', $qual['grades_gpa'] ?? '') }}" placeholder="e.g. 3.8 / 4.0 or A,B,C" required />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="additional_qualifications_{{ $index }}_field" class="form-label">Field of Study</label>
                                                <input type="text" class="form-control" name="additional_qualifications[{{ $index }}][field_of_study]" id="additional_qualifications_{{ $index }}_field" value="{{ old('additional_qualifications.' . $index . '.field_of_study', $qual['field_of_study'] ?? '') }}" placeholder="e.g. Computer Science" />
                                            </div>
                                            <div class="col-12"><hr class="mt-2 mb-4"></div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-12 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addQualificationRow()">
                                        <i class="mdi mdi-plus me-1"></i> Add More Educational Qualification
                                    </button>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">English Language Proficiency <span class="text-danger">*</span></label>
                                    <select class="form-select" name="english_proficiency" data-current-value="{{ old('english_proficiency', $assessment->english_proficiency) }}" required>
                                        <option value="">Select Proficiency...</option>
                                        @foreach($englishProficiencyOptions as $opt)
                                            <option value="{{ $opt }}" {{ old('english_proficiency', $assessment->english_proficiency) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="english_score" class="form-label">English Test Score (if applicable)</label>
                                    <input type="text" class="form-control" name="english_score" id="english_score" value="{{ old('english_score', $assessment->english_score) }}" placeholder="e.g. IELTS 6.5 Overall" />
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="work_experience" class="form-label">Work Experience <small class="text-muted">(If any - Job Title, Company, Duration)</small></label>
                                    <textarea class="form-control" name="work_experience" id="work_experience" rows="2" placeholder="e.g. Software Engineer, XYZ Corp, Jan 2023 - Present">{{ old('work_experience', $assessment->work_experience) }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-light prev-step" data-prev="#step1-tab"><i class="mdi mdi-arrow-left me-1"></i> Back</button>
                                <button type="button" class="btn btn-primary next-step" data-next="#step3-tab">Next Step <i class="mdi mdi-arrow-right ms-1"></i></button>
                            </div>
                        </div>

                        {{-- ═══ STEP 3: Study Plan ═══ --}}
                        <div class="tab-pane" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Study Plan</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Study Destination <span class="text-danger">*</span></label>
                                    <select class="form-select" name="study_destination" data-current-value="{{ old('study_destination', $assessment->study_destination) }}" required>
                                        <option value="">Select Destination...</option>
                                        @foreach($studyDestinations as $opt)
                                            <option value="{{ $opt }}" {{ old('study_destination', $assessment->study_destination) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Study Method <span class="text-danger">*</span></label>
                                    <select class="form-select" name="study_method" data-current-value="{{ old('study_method', $assessment->study_method) }}" required>
                                        <option value="">Select Method...</option>
                                        @foreach($studyMethods as $opt)
                                            <option value="{{ $opt }}" {{ old('study_method', $assessment->study_method) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Level of Study <span class="text-danger">*</span></label>
                                    <select class="form-select" name="level_of_study" data-current-value="{{ old('level_of_study', $assessment->level_of_study) }}" required>
                                        <option value="">Select Level...</option>
                                        @foreach($levelOfStudyOptions as $opt)
                                            <option value="{{ $opt }}" {{ old('level_of_study', $assessment->level_of_study) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="intended_course" class="form-label">Intended Course / Program of Study <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="intended_course" id="intended_course" value="{{ old('intended_course', $assessment->intended_course) }}" placeholder="e.g. BSc Computer Science" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="preferred_intake" class="form-label">Preferred Intake / Start Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="preferred_intake" id="preferred_intake" value="{{ old('preferred_intake', $assessment->preferred_intake) }}" placeholder="e.g. September 2026" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="course_link" class="form-label">Course URL / Link <small class="text-muted">(Optional)</small></label>
                                    <input type="url" class="form-control" name="course_link" id="course_link" value="{{ old('course_link', $assessment->course_link) }}" placeholder="https://university.ac.uk/..." />
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">How do you plan to fund your studies? <span class="text-danger">*</span></label>
                                    <select class="form-select" name="financial_source" data-current-value="{{ old('financial_source', $assessment->financial_source) }}" required>
                                        <option value="">Select Source...</option>
                                        @foreach($financialSourceOptions as $opt)
                                            <option value="{{ $opt }}" {{ old('financial_source', $assessment->financial_source) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h5 class="text-uppercase bg-light p-2"><i class="mdi mdi-plane me-1"></i> Travel History & Immigration</h5>
                                </div>

                                {{-- Section 1: Travel History --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Has this student applied for permission to remain in any of the following countries in the past ten years? <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        <input type="radio" class="btn-check" name="travel_history[has_history]" id="travel_yes" value="yes" {{ (old('travel_history.has_history', $assessment->travel_history['has_history'] ?? '') == 'yes') ? 'checked' : '' }} onclick="toggleTravelHistoryFields(true)">
                                        <label class="btn btn-outline-primary px-4" for="travel_yes">Yes</label>

                                        <input type="radio" class="btn-check" name="travel_history[has_history]" id="travel_no" value="no" {{ (old('travel_history.has_history', $assessment->travel_history['has_history'] ?? 'no') == 'no') ? 'checked' : '' }} onclick="toggleTravelHistoryFields(false)">
                                        <label class="btn btn-outline-secondary px-4" for="travel_no">No</label>
                                    </div>
                                </div>

                                <div class="col-md-12" id="travel_history_fields" style="display: {{ (old('travel_history.has_history', $assessment->travel_history['has_history'] ?? '') == 'yes') ? 'block' : 'none' }};">
                                    <div class="row bg-light p-3 border rounded-3 mb-3 m-0">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Date of Arrival <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="travel_history[arrival_date]" id="travel_arrival_date" value="{{ old('travel_history.arrival_date', $assessment->travel_history['arrival_date'] ?? '') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Date of Departure <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="travel_history[departure_date]" id="travel_departure_date" value="{{ old('travel_history.departure_date', $assessment->travel_history['departure_date'] ?? '') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Visa Start Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="travel_history[visa_start_date]" id="travel_visa_start_date" value="{{ old('travel_history.visa_start_date', $assessment->travel_history['visa_start_date'] ?? '') }}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Visa Expiry Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="travel_history[visa_expiry_date]" id="travel_visa_expiry_date" value="{{ old('travel_history.visa_expiry_date', $assessment->travel_history['visa_expiry_date'] ?? '') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Purpose of Visit <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="travel_history[purpose_of_visit]" id="travel_purpose_of_visit" value="{{ old('travel_history.purpose_of_visit', $assessment->travel_history['purpose_of_visit'] ?? '') }}" placeholder="e.g. Tourism, Study, Work">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <select class="form-select select2-tags" name="travel_history[country]" id="travel_country" data-placeholder="Select country">
                                                <option value="">Select Country...</option>
                                                @foreach(\App\Models\Country::orderBy('name')->get() as $c)
                                                    <option value="{{ $c->name }}" {{ (old('travel_history.country', $assessment->travel_history['country'] ?? '') == $c->name) ? 'selected' : '' }}>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="travel_history[visa_type]" id="travel_visa_type">
                                                <option value="">Select Visa Type...</option>
                                                @foreach(['Tourist Visa','Student Visa','Work Visa','Business Visa','Other'] as $vt)
                                                    <option value="{{ $vt }}" {{ (old('travel_history.visa_type', $assessment->travel_history['visa_type'] ?? '') == $vt) ? 'selected' : '' }}>{{ $vt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 2: Immigration History --}}
                                <div class="col-md-12 mb-3">
                                    <div class="bg-light p-3 border rounded-3">
                                        <label class="form-label fw-bold">Does this student need a visa to stay in any of the following countries? Please tick all that apply. <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="immigration_history[countries][]" value="{{ old('study_destination', $assessment->study_destination ?? '') }}" id="imm_country_chk" onclick="toggleImmigrationNone(false)" {{ (in_array(old('study_destination', $assessment->study_destination ?? ''), old('immigration_history.countries', $assessment->immigration_history['countries'] ?? []))) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="imm_country_chk" id="imm_country_label">
                                                    {{ old('study_destination', $assessment->study_destination ?? 'Selected Study Destination') }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="immigration_history[countries][]" value="None" id="imm_none_chk" onclick="toggleImmigrationNone(true)" {{ (in_array('None', old('immigration_history.countries', $assessment->immigration_history['countries'] ?? ['None']))) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="imm_none_chk">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section 3: Visa Rejections --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">For any country has this student ever been refused permission to stay or remain, refused asylum or deported? <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        <input type="radio" class="btn-check" name="visa_refusals[has_refusal]" id="refusal_yes" value="yes" {{ (old('visa_refusals.has_refusal', $assessment->visa_refusals['has_refusal'] ?? '') == 'yes') ? 'checked' : '' }} onclick="toggleVisaRefusalFields(true)">
                                        <label class="btn btn-outline-danger px-4" for="refusal_yes">Yes</label>

                                        <input type="radio" class="btn-check" name="visa_refusals[has_refusal]" id="refusal_no" value="no" {{ (old('visa_refusals.has_refusal', $assessment->visa_refusals['has_refusal'] ?? 'no') == 'no') ? 'checked' : '' }} onclick="toggleVisaRefusalFields(false)">
                                        <label class="btn btn-outline-secondary px-4" for="refusal_no">No</label>
                                    </div>
                                </div>

                                <div class="col-md-12" id="visa_refusal_fields" style="display: {{ (old('visa_refusals.has_refusal', $assessment->visa_refusals['has_refusal'] ?? '') == 'yes') ? 'block' : 'none' }};">
                                    <div class="row bg-light p-3 border rounded-3 mb-3 m-0">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Refusal Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="visa_refusals[refusal_type]" id="refusal_type">
                                                <option value="">Select Refusal Type...</option>
                                                @foreach(['Visa Refusal','Refused Entry','Deported','Refused Leave to Remain','Refused Asylum'] as $rt)
                                                    <option value="{{ $rt }}" {{ (old('visa_refusals.refusal_type', $assessment->visa_refusals['refusal_type'] ?? '') == $rt) ? 'selected' : '' }}>{{ $rt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Date of Refusal <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="visa_refusals[refusal_date]" id="refusal_date" value="{{ old('visa_refusals.refusal_date', $assessment->visa_refusals['refusal_date'] ?? '') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <select class="form-select select2-tags" name="visa_refusals[country]" id="refusal_country" data-placeholder="Select country">
                                                <option value="">Select Country...</option>
                                                @foreach(\App\Models\Country::orderBy('name')->get() as $c)
                                                    <option value="{{ $c->name }}" {{ (old('visa_refusals.country', $assessment->visa_refusals['country'] ?? '') == $c->name) ? 'selected' : '' }}>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                                            <select class="form-select" name="visa_refusals[visa_type]" id="refusal_visa_type">
                                                <option value="">Select Visa Type...</option>
                                                @foreach(['Tourist Visa','Student Visa','Work Visa','Business Visa','Other'] as $vt)
                                                    <option value="{{ $vt }}" {{ (old('visa_refusals.visa_type', $assessment->visa_refusals['visa_type'] ?? '') == $vt) ? 'selected' : '' }}>{{ $vt }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label">Details / Reason <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="visa_refusals[details]" id="refusal_details" rows="2" placeholder="Provide details or reason for refusal...">{{ old('visa_refusals.details', $assessment->visa_refusals['details'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="purpose_of_study" class="form-label">Why do you want to study abroad? <small class="text-muted">(Optional)</small></label>
                                    <textarea class="form-control" name="purpose_of_study" id="purpose_of_study" rows="3" placeholder="Briefly describe your motivation...">{{ old('purpose_of_study', $assessment->purpose_of_study) }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                <button type="button" class="btn btn-light prev-step" data-prev="#step2-tab"><i class="mdi mdi-arrow-left me-1"></i> Back</button>
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="mdi mdi-send me-1"></i> Submit Assessment
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let qualificationIndex = {{ count($additionalQuals) }};

    function addQualificationRow() {
        const container = document.getElementById('additional_qualifications_container');
        const rowHtml = `
            <div class="row p-0 m-0 qualification-row mb-3" id="qualification_row_${qualificationIndex}">
                <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Additional Educational Qualification</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQualificationRow(${qualificationIndex})">
                        <i class="mdi mdi-close me-1"></i> Remove
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_qualification" class="form-label">Qualification Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][qualification]" id="additional_qualifications_${qualificationIndex}_qualification" placeholder="e.g. GCSE / A-Level" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_institution" class="form-label">Institution Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][institution]" id="additional_qualifications_${qualificationIndex}_institution" placeholder="e.g. High School" required />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_year" class="form-label">Year of Passing <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][year_of_passing]" id="additional_qualifications_${qualificationIndex}_year" placeholder="e.g. 2020" required />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_grades_gpa" class="form-label">Grade / GPA <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][grades_gpa]" id="additional_qualifications_${qualificationIndex}_grades_gpa" placeholder="e.g. 3.8 / 4.0 or A,B,C" required />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_field" class="form-label">Field of Study</label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][field_of_study]" id="additional_qualifications_${qualificationIndex}_field" placeholder="e.g. Computer Science" />
                </div>
                <div class="col-12"><hr class="mt-2 mb-4"></div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
        
        // Re-attach change event listener to new inputs to clear invalid class if needed
        const newInputs = document.querySelectorAll(`#qualification_row_${qualificationIndex} input`);
        newInputs.forEach(input => {
            input.addEventListener('change', function() {
                if(this.value) this.classList.remove('is-invalid');
            });
        });

        qualificationIndex++;
    }

    function removeQualificationRow(index) {
        const row = document.getElementById(`qualification_row_${index}`);
        if (row) {
            row.remove();
        }
    }

    function toggleTravelHistoryFields(show) {
        const fieldsDiv = document.getElementById('travel_history_fields');
        fieldsDiv.style.display = show ? 'block' : 'none';
        
        const inputs = fieldsDiv.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (show) {
                input.setAttribute('required', 'required');
            } else {
                input.removeAttribute('required');
                input.value = '';
                input.classList.remove('is-invalid');
            }
        });
    }

    function toggleVisaRefusalFields(show) {
        const fieldsDiv = document.getElementById('visa_refusal_fields');
        fieldsDiv.style.display = show ? 'block' : 'none';
        
        const inputs = fieldsDiv.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (show) {
                input.setAttribute('required', 'required');
            } else {
                input.removeAttribute('required');
                input.value = '';
                input.classList.remove('is-invalid');
            }
        });
    }

    const immCountryChk = document.getElementById('imm_country_chk');
    function toggleImmigrationNone(isNoneChecked) {
        if (isNoneChecked) {
            if (immCountryChk) immCountryChk.checked = false;
        } else {
            const noneChk = document.getElementById('imm_none_chk');
            if (noneChk) noneChk.checked = false;
        }
    }

    function toggleHighestQualificationOther() {
        const select = document.getElementById('highest_qualification_select');
        const otherDiv = document.getElementById('highest_qualification_other_div');
        const otherInput = document.getElementById('highest_qualification_other');
        
        if (select && select.value === 'Other') {
            otherDiv.style.display = 'block';
            otherInput.setAttribute('required', 'required');
        } else if (otherDiv) {
            otherDiv.style.display = 'none';
            otherInput.removeAttribute('required');
            otherInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Toggle highest qualification other on load and change
        const highestQualSelect = document.getElementById('highest_qualification_select');
        if (highestQualSelect) {
            highestQualSelect.addEventListener('change', toggleHighestQualificationOther);
            toggleHighestQualificationOther();
        }

        // Travel History & Immigration setup
        const studyDestSelect = document.querySelector('select[name="study_destination"]');
        const immCountryLabel = document.getElementById('imm_country_label');
        const immCountryChk = document.getElementById('imm_country_chk');

        function updateImmigrationCheckboxes() {
            if (!studyDestSelect) return;
            const val = studyDestSelect.value;
            if (val) {
                if (immCountryLabel) immCountryLabel.textContent = val;
                if (immCountryChk) {
                    immCountryChk.value = val;
                    immCountryChk.closest('.form-check').style.display = 'block';
                }
            } else {
                if (immCountryLabel) immCountryLabel.textContent = 'Selected Study Destination';
                if (immCountryChk) {
                    immCountryChk.value = '';
                    immCountryChk.closest('.form-check').style.display = 'none';
                }
            }
        }

        if (studyDestSelect) {
            studyDestSelect.addEventListener('change', updateImmigrationCheckboxes);
            updateImmigrationCheckboxes();
        }

        // Next Button Click
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-next');
                const targetTab = document.querySelector(targetId);
                
                // Basic HTML5 validation before moving next
                const currentPane = this.closest('.tab-pane');
                let isValid = true;
                currentPane.querySelectorAll('[required]').forEach(input => {
                    // Check if parent element is hidden (skip validation for hidden inputs e.g. Other field when not visible)
                    if (input.offsetParent === null) {
                        return;
                    }
                    if(!input.value) {
                        isValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if(isValid) {
                    targetTab.classList.remove('disabled');
                    var tab = new bootstrap.Tab(targetTab);
                    tab.show();
                    window.scrollTo({top: 0, behavior: 'smooth'});
                }
            });
        });

        // Prev Button Click
        document.querySelectorAll('.prev-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-prev');
                const targetTab = document.querySelector(targetId);
                var tab = new bootstrap.Tab(targetTab);
                tab.show();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        });

        // Remove invalid class on change
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', function() {
                if(this.value) this.classList.remove('is-invalid');
            });
        });

        // Submit loading state
        document.getElementById('assessForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Submitting...';
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-tags').each(function() {
            const el = $(this);
            el.select2({
                tags: true,
                placeholder: el.attr('data-placeholder') || "Select from dropdown or type to add if not found...",
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>
@endpush
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 12px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
@endpush

@endsection

@extends('layouts.backend_master')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* ─── Profile Wizard Styles ─── */
    .student-wizard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,.08);
        overflow: hidden;
    }
    .student-wizard-header {
        background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%);
        padding: 28px 32px;
        color: #fff;
    }
    .student-wizard-header .badge-id {
        background: rgba(255,255,255,.2);
        color: #fff;
        font-size: .75rem;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: .5px;
    }
    .student-wizard-header h4 { color: #fff; font-weight: 700; margin-bottom: 4px; }
    .student-wizard-header p  { color: rgba(255,255,255,.75); font-size: .85rem; margin:0; }

    /* ─── Step Nav ─── */
    .step-nav { display: flex; flex-direction: column; gap: 4px; padding: 20px 12px; }
    .step-nav-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 16px; border-radius: 10px; cursor: pointer;
        font-size: .85rem; font-weight: 500; color: #6e7891;
        border: none; background: transparent; text-align: left; width: 100%;
        transition: all .2s ease;
    }
    .step-nav-item:hover { background: #f0f4ff; color: #2c3e7a; }
    .step-nav-item.active { background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%); color: #fff; box-shadow: 0 4px 12px rgba(44,62,122,.3); }
    .step-nav-item .step-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink:0; background: rgba(0,0,0,.06); }
    .step-nav-item.active .step-icon { background: rgba(255,255,255,.25); color: #fff; }
    .step-nav-item .step-number { width: 20px; height: 20px; border-radius: 50%; background: #e8ecf5; color: #6e7891; font-size: .7rem; font-weight: 700; display: flex; align-items:center; justify-content:center; flex-shrink:0; }
    .step-nav-item.active .step-number { background: rgba(255,255,255,.3); color: #fff; }
    .step-nav-item.completed .step-number { background: #2ecc71; color: #fff; }

    /* ─── Tab Content ─── */
    .tab-pane { display: none; } .tab-pane.show.active { display: block; }
    .section-title { font-size: .9rem; font-weight: 700; color: #2c3e7a; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 16px; display: flex; align-items:center; gap: 8px; }
    .section-title::after { content:''; flex:1; height:1px; background: linear-gradient(90deg,#d8e0f0,transparent); }
    .form-label { font-size: .8rem; font-weight: 600; color: #5a6278; margin-bottom: 5px; }
    .form-control, .form-select { border: 1.5px solid #e8ecf5; border-radius: 8px; font-size: .85rem; padding: 8px 14px; transition: border-color .2s; }
    .form-control:focus, .form-select:focus { border-color: #1a9fd4; box-shadow: 0 0 0 3px rgba(26,159,212,.1); }

    /* ─── Academic Row Card ─── */
    .academic-row { background: #fff; border: 1.5px solid #e8ecf5; border-radius: 12px; padding: 18px; margin-bottom: 14px; position:relative; }
    .academic-row.new-row { background: #f8fbff; border-style: dashed; }
    .remove-row-btn { position:absolute; top:10px; right:12px; color:#e74c3c; cursor:pointer; background:none; border:none; font-size: .9rem; }

    /* ─── Referee Card ─── */
    .referee-card { background: #fff; border: 1.5px solid #e8ecf5; border-radius: 12px; overflow:hidden; margin-bottom: 18px; }
    .referee-card .referee-header { background: linear-gradient(135deg, #f0f4ff, #e8f4fb); padding: 12px 18px; font-weight: 700; font-size: .85rem; color: #2c3e7a; display: flex; align-items:center; gap: 8px; }

    /* ─── Document Upload ─── */
    .doc-upload-area { border: 2px dashed #c5d0e8; border-radius: 12px; padding: 28px; text-align: center; cursor: pointer; transition: all .2s; }
    .doc-upload-area:hover { border-color: #1a9fd4; background: #f0f8ff; }
    .doc-badge { font-size: .78rem; padding: 5px 10px; border-radius: 6px; }

    /* ─── Save Button ─── */
    .btn-save { background: linear-gradient(135deg, #2c3e7a, #1a9fd4); border: none; color: #fff; padding: 10px 28px; border-radius: 8px; font-weight: 600; font-size: .88rem; transition: all .2s; }
    .btn-save:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(44,62,122,.3); color:#fff; }
    .btn-add-more { border: 1.5px dashed #1a9fd4; color: #1a9fd4; background: transparent; padding: 8px 20px; border-radius: 8px; font-size: .83rem; font-weight: 600; cursor:pointer; transition: all .2s; }
    .btn-add-more:hover { background: #f0f8ff; }

    /* ─── Toast ─── */
    #save-toast { position:fixed; bottom:24px; right:24px; z-index:9999; min-width:280px; }
    .toast-success { background: linear-gradient(135deg, #27ae60, #2ecc71); color:#fff; border:none; border-radius: 12px; }
    .toast-error   { background: linear-gradient(135deg, #c0392b, #e74c3c); color:#fff; border:none; border-radius: 12px; }

    /* Progress bar */
    .wizard-progress { height: 4px; background: #e8ecf5; border-radius: 2px; margin: 0 20px 0; }
    .wizard-progress-bar { height: 4px; background: linear-gradient(90deg, #2c3e7a, #1a9fd4); border-radius: 2px; transition: width .4s ease; }

    /* ─── Sidebar active tab link ─── */
    .student-tab-link.active {
        color: #2c3e7a !important;
        font-weight: 600;
        background: rgba(44, 62, 122, 0.08);
        border-radius: 6px;
    }
    .student-tab-link.active i { color: #2c3e7a !important; }
</style>
@endpush

@section('admin_contents')
<div class="row g-3 mb-4">
  <div class="col-12">
    <div class="student-wizard-card">

      <!-- Header -->
      <div class="student-wizard-header d-flex align-items-center gap-3">
        <div class="avatar avatar-3xl">
          <div class="avatar-name rounded-circle" style="background:rgba(255,255,255,.2);color:#fff;font-size:1.4rem;">
            {{ strtoupper(substr($student->first_name,0,1)) }}{{ strtoupper(substr($student->surname,0,1)) }}
          </div>
        </div>
        <div>
          <span class="badge-id">{{ $student->student_id }}</span>
          <h4 class="mt-1">{{ $student->first_name }} {{ $student->surname }}</h4>
          <p>{{ $student->email }} &bull; {{ $student->phone ?? 'Phone not set' }}</p>
        </div>
        <div class="ms-auto text-end">
          <div class="text-white-50 fs--2 mb-1">Profile Completion</div>
          <div style="font-size:1.6rem;font-weight:700;">{{ $completionPercent ?? 20 }}%</div>
        </div>
      </div>

      <!-- Progress Bar -->
      <div class="wizard-progress mx-0">
        <div class="wizard-progress-bar" id="mainProgressBar" style="width:{{ $completionPercent ?? 20 }}%"></div>
      </div>

      <!-- Hidden nav markers for JS (sidebar links use these) -->
      <span id="nav-0" class="d-none"></span>
      <span id="nav-1" class="d-none"></span>
      <span id="nav-2" class="d-none"></span>
      <span id="nav-3" class="d-none"></span>
      <span id="nav-4" class="d-none"></span>
      <span id="nav-5" class="d-none"></span>
      <span id="nav-6" class="d-none"></span>

      <div class="row g-0">
        <!-- ─── Tab Content ─── -->
        <div class="col-md-12">
          <div class="p-4" id="tab-content-area">

            <!-- ═══════════ TAB 0: Personal Info ═══════════ -->
            <div class="tab-section show active" id="tab-0">
              <form id="form-personal">
                @csrf
                <div class="section-title"><i class="fas fa-user text-primary"></i> Personal Information</div>
                <div class="row g-3">
                  <div class="col-md-2">
                    <label class="form-label">Title</label>
                    <select class="form-select" name="title">
                      <option value="">Select</option>
                      @foreach(['Mr','Mrs','Miss','Ms','Dr','Prof'] as $t)
                        <option value="{{ $t }}" {{ $student->title==$t?'selected':'' }}>{{ $t }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label">First Name (Given name) <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="first_name" value="{{ $student->first_name }}" required>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label">Middle Name</label>
                    <input class="form-control" type="text" name="middle_name" value="{{ $student->middle_name }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Family Name (Surname) <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="surname" value="{{ $student->surname }}" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Date of Birth</label>
                    <input class="form-control" type="date" name="dob" value="{{ $student->dob ? $student->dob->format('Y-m-d') : '' }}">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                      <option value="">Select...</option>
                      @foreach(['Male','Female','Other'] as $g)
                        <option value="{{ $g }}" {{ $student->gender==$g?'selected':'' }}>{{ $g }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Nationality</label>
                    <input class="form-control" type="text" name="nationality" value="{{ $student->nationality }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country of Birth</label>
                    <input class="form-control" type="text" name="country_of_birth" value="{{ $student->country_of_birth }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Native Language</label>
                    <input class="form-control" type="text" name="native_language" value="{{ $student->native_language }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input class="form-control" type="email" name="email" value="{{ $student->email }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input class="form-control" type="text" name="phone" value="{{ $student->phone }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Skype ID</label>
                    <input class="form-control" type="text" name="skype_id" value="{{ $student->skype_id }}">
                  </div>
                  <div class="col-md-8">
                    <label class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" name="profile_picture" accept="image/*">
                    @if($student->profile_picture)
                      <div class="mt-2 text-muted small">Current: <a href="{{ asset($student->profile_picture) }}" target="_blank">View Picture</a></div>
                    @endif
                  </div>

                  <div class="col-12 mt-2"><div class="section-title"><i class="fas fa-passport text-primary"></i> Passport Details</div></div>
                  <div class="col-md-6">
                    <label class="form-label">Name in Passport</label>
                    <input class="form-control" type="text" name="name_in_passport" value="{{ $student->name_in_passport }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Passport Number</label>
                    <input class="form-control" type="text" name="passport_number" value="{{ $student->passport_number }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Issue Location</label>
                    <input class="form-control" type="text" name="passport_issue_location" value="{{ $student->passport_issue_location }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Issue Date</label>
                    <input class="form-control" type="date" name="passport_issue_date" value="{{ $student->passport_issue_date ? $student->passport_issue_date->format('Y-m-d') : '' }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Expiry Date</label>
                    <input class="form-control" type="date" name="passport_expiry_date" value="{{ $student->passport_expiry_date ? $student->passport_expiry_date->format('Y-m-d') : '' }}">
                  </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-personal', '{{ route('student.profile.personal') }}', 1)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 1: Address & Emergency ═══════════ -->
            <div class="tab-section d-none" id="tab-1">
              <form id="form-address">
                @csrf
                <div class="section-title"><i class="fas fa-map-marker-alt text-primary"></i> Permanent Address</div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label">Full Address</label>
                    <input class="form-control" type="text" name="permanent_address" value="{{ $student->permanent_address }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input class="form-control" type="text" name="permanent_city" value="{{ $student->permanent_city }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Postcode</label>
                    <input class="form-control" type="text" name="permanent_postcode" value="{{ $student->permanent_postcode }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <input class="form-control" type="text" name="permanent_country" value="{{ $student->permanent_country }}">
                  </div>
                </div>

                <div class="section-title mt-4"><i class="fas fa-home text-primary"></i> Current Address <small class="text-muted fw-normal text-lowercase">(if different from permanent)</small></div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label">Full Address</label>
                    <input class="form-control" type="text" name="current_address" value="{{ $student->current_address }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input class="form-control" type="text" name="current_city" value="{{ $student->current_city }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Postcode</label>
                    <input class="form-control" type="text" name="current_postcode" value="{{ $student->current_postcode }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <input class="form-control" type="text" name="current_country" value="{{ $student->current_country }}">
                  </div>
                </div>

                <div class="section-title mt-4"><i class="fas fa-phone-alt text-primary"></i> Emergency Contact</div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" type="text" name="emergency_contact_name" value="{{ $student->emergency_contact_name }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Relationship</label>
                    <input class="form-control" type="text" name="emergency_contact_relationship" value="{{ $student->emergency_contact_relationship }}" placeholder="e.g. Father, Mother">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Mobile</label>
                    <input class="form-control" type="text" name="emergency_contact_mobile" value="{{ $student->emergency_contact_mobile }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="emergency_contact_email" value="{{ $student->emergency_contact_email }}">
                  </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(0)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-address', '{{ route('student.profile.personal') }}', 2)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 2: Travel & English ═══════════ -->
            <div class="tab-section d-none" id="tab-2">
              <form id="form-travel">
                @csrf
                <div class="section-title"><i class="fas fa-plane text-primary"></i> Travel History & Immigration</div>
                <div class="row g-3">
                  <div class="col-12">
                    <div class="card border-0 bg-light rounded-3 p-3">
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Has this student applied for leave to remain in the UK in the past 10 years?</label>
                        <select class="form-select w-auto ms-3" name="applied_leave_to_remain_uk" style="min-width:80px;">
                          <option value="0" {{ !$student->applied_leave_to_remain_uk ? 'selected' : '' }}>No</option>
                          <option value="1" {{ $student->applied_leave_to_remain_uk ? 'selected' : '' }}>Yes</option>
                        </select>
                      </div>
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Does this student need a visa to stay in the UK?</label>
                        <select class="form-select w-auto ms-3" name="need_visa_for_uk" style="min-width:80px;">
                          <option value="0" {{ !$student->need_visa_for_uk ? 'selected' : '' }}>No</option>
                          <option value="1" {{ $student->need_visa_for_uk ? 'selected' : '' }}>Yes</option>
                        </select>
                      </div>
                      <div class="d-flex align-items-center justify-content-between">
                        <label class="form-label mb-0">Has the student ever been refused a visa or deported?</label>
                        <select class="form-select w-auto ms-3" name="refused_visa_or_deported" style="min-width:80px;">
                          <option value="0" {{ !$student->refused_visa_or_deported ? 'selected' : '' }}>No</option>
                          <option value="1" {{ $student->refused_visa_or_deported ? 'selected' : '' }}>Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="form-label">TB Test Details</label>
                    <input class="form-control" type="text" name="taken_tb_test" value="{{ $student->taken_tb_test }}" placeholder="e.g. Yes - Certificate No: TB2024...">
                  </div>
                </div>

                <div class="section-title mt-4"><i class="fas fa-language text-primary"></i> English Language Exams</div>
                @php $test = $englishTests->first() ?? new \App\Models\StudentEnglishTest(); @endphp
                <input type="hidden" name="english_tests[0][id]" value="{{ $test->id }}">
                <div class="row g-3">
                  <div class="col-md-4">
                    <label class="form-label">Test Type</label>
                    <select class="form-select" name="english_tests[0][test_name]">
                      <option value="">Select...</option>
                      @foreach(['UKVI-IELTS','IELTS','TOEFL','PTE','Duolingo','Other'] as $en)
                        <option value="{{ $en }}" {{ $test->test_name==$en?'selected':'' }}>{{ $en }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Date of Exam</label>
                    <input class="form-control" type="date" name="english_tests[0][date_of_exam]" value="{{ $test->date_of_exam ? $test->date_of_exam->format('Y-m-d') : '' }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Overall Band / Score</label>
                    <input class="form-control" type="text" name="english_tests[0][overall_score]" value="{{ $test->overall_score }}" placeholder="e.g. 6.5">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Listening</label>
                    <input class="form-control" type="text" name="english_tests[0][listening]" value="{{ $test->listening }}" placeholder="e.g. 7.0">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Reading</label>
                    <input class="form-control" type="text" name="english_tests[0][reading]" value="{{ $test->reading }}" placeholder="e.g. 6.5">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Writing</label>
                    <input class="form-control" type="text" name="english_tests[0][writing]" value="{{ $test->writing }}" placeholder="e.g. 6.0">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Speaking</label>
                    <input class="form-control" type="text" name="english_tests[0][speaking]" value="{{ $test->speaking }}" placeholder="e.g. 6.5">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">TRF Number</label>
                    <input class="form-control" type="text" name="english_tests[0][trf_number]" value="{{ $test->trf_number }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">UKVI Number</label>
                    <input class="form-control" type="text" name="english_tests[0][ukvi_number]" value="{{ $test->ukvi_number }}">
                  </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(1)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-travel', '{{ route('student.profile.english') }}', 3)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 3: Academic History ═══════════ -->
            <div class="tab-section d-none" id="tab-3">
              <form id="form-academic">
                @csrf
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="section-title mb-0"><i class="fas fa-graduation-cap text-primary"></i> Academic History</div>
                  <button type="button" class="btn-add-more" onclick="addAcademicRow()"><i class="fas fa-plus me-1"></i> Add More</button>
                </div>
                <p class="text-muted fs--1 mb-3">Add all your qualifications: 10th Grade, 12th Grade, Bachelor's, Master's, PhD, etc.</p>

                <div id="academics-container">
                  @php $idx = 0; @endphp
                  @forelse($academics as $aca)
                  <div class="academic-row" id="aca-row-{{ $idx }}">
                    <button type="button" class="remove-row-btn" onclick="removeAcademicRow({{ $idx }})"><i class="fas fa-times-circle"></i></button>
                    <input type="hidden" name="academics[{{ $idx }}][id]" value="{{ $aca->id }}">
                    <div class="row g-2">
                      <div class="col-md-4">
                        <label class="form-label">Education Level</label>
                        <select class="form-select" name="academics[{{ $idx }}][education_level]">
                          @foreach(['10th Grade','12th Grade/A-Level','Diploma','Bachelor\'s Degree','Master\'s Degree','PhD/Doctorate','Other'] as $el)
                            <option value="{{ $el }}" {{ $aca->education_level==$el?'selected':'' }}>{{ $el }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input class="form-control" type="text" name="academics[{{ $idx }}][country]" value="{{ $aca->country }}">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Institution Name</label>
                        <input class="form-control" type="text" name="academics[{{ $idx }}][institution_name]" value="{{ $aca->institution_name }}">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Course / Subject</label>
                        <input class="form-control" type="text" name="academics[{{ $idx }}][course_name]" value="{{ $aca->course_name }}">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Start Date</label>
                        <input class="form-control" type="date" name="academics[{{ $idx }}][start_date]" value="{{ $aca->start_date ? $aca->start_date->format('Y-m-d') : '' }}">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input class="form-control" type="date" name="academics[{{ $idx }}][end_date]" value="{{ $aca->end_date ? $aca->end_date->format('Y-m-d') : '' }}">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Award Date</label>
                        <input class="form-control" type="date" name="academics[{{ $idx }}][award_date]" value="{{ $aca->award_date ? $aca->award_date->format('Y-m-d') : '' }}">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Result / %</label>
                        <input class="form-control" type="text" name="academics[{{ $idx }}][result_percentage]" value="{{ $aca->result_percentage }}" placeholder="e.g. 85%">
                      </div>
                    </div>
                  </div>
                  @php $idx++; @endphp
                  @empty
                  <!-- Empty placeholder row will be added by JS -->
                  @endforelse
                </div>

                @if($academics->isEmpty())
                <script>
                  document.addEventListener('DOMContentLoaded', function() { addAcademicRow(); });
                </script>
                @endif

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(2)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-academic', '{{ route('student.profile.academic') }}', 4)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 4: Course Preferences ═══════════ -->
            <div class="tab-section d-none" id="tab-4">
              <form id="form-preferences">
                @csrf
                <div class="section-title"><i class="fas fa-book-open text-primary"></i> Academic Interest</div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Discipline / Field of Study</label>
                    <input class="form-control" type="text" name="field_of_study" value="{{ $preAssessment->field_of_study }}">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Level of Study</label>
                    <select class="form-select" name="level_of_study">
                      <option value="">Select...</option>
                      @foreach(['Foundation','Undergraduate','Postgraduate Taught','Postgraduate Research','PhD','Professional'] as $ls)
                        <option value="{{ $ls }}" {{ $preAssessment->level_of_study==$ls?'selected':'' }}>{{ $ls }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred Course 1</label>
                    <select class="form-control select2-tags" name="intended_course">
                        <option value=""></option>
                        @if($preAssessment->intended_course && (!isset($courses) || !$courses->contains('name', $preAssessment->intended_course)))
                            <option value="{{ $preAssessment->intended_course }}" selected>{{ $preAssessment->intended_course }}</option>
                        @endif
                        @if(isset($courses))
                            @foreach($courses as $course)
                                <option value="{{ $course->name }}" {{ $preAssessment->intended_course == $course->name ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="col-md-6">
                    @php $val_uni_1 = $preAssessment->institute_name ?: ($student->institute->name ?? ''); @endphp
                    <label class="form-label">Preferred University 1</label>
                    <select class="form-control select2-tags" name="institute_name" required>
                        <option value=""></option>
                        @if($val_uni_1 && (!isset($institutes) || !$institutes->contains('name', $val_uni_1)))
                            <option value="{{ $val_uni_1 }}" selected>{{ $val_uni_1 }}</option>
                        @endif
                        @if(isset($institutes))
                            @foreach($institutes as $institute)
                                <option value="{{ $institute->name }}" {{ $val_uni_1 == $institute->name ? 'selected' : '' }}>{{ $institute->name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred Course 2</label>
                    <select class="form-control select2-tags" name="preferred_course_2">
                        <option value=""></option>
                        @if($preAssessment->preferred_course_2 && (!isset($courses) || !$courses->contains('name', $preAssessment->preferred_course_2)))
                            <option value="{{ $preAssessment->preferred_course_2 }}" selected>{{ $preAssessment->preferred_course_2 }}</option>
                        @endif
                        @if(isset($courses))
                            @foreach($courses as $course)
                                <option value="{{ $course->name }}" {{ $preAssessment->preferred_course_2 == $course->name ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred University 2</label>
                    <select class="form-control select2-tags" name="preferred_university_2">
                        <option value=""></option>
                        @if($preAssessment->preferred_university_2 && (!isset($institutes) || !$institutes->contains('name', $preAssessment->preferred_university_2)))
                            <option value="{{ $preAssessment->preferred_university_2 }}" selected>{{ $preAssessment->preferred_university_2 }}</option>
                        @endif
                        @if(isset($institutes))
                            @foreach($institutes as $institute)
                                <option value="{{ $institute->name }}" {{ $preAssessment->preferred_university_2 == $institute->name ? 'selected' : '' }}>{{ $institute->name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred Course 3</label>
                    <select class="form-control select2-tags" name="preferred_course_3">
                        <option value=""></option>
                        @if($preAssessment->preferred_course_3 && (!isset($courses) || !$courses->contains('name', $preAssessment->preferred_course_3)))
                            <option value="{{ $preAssessment->preferred_course_3 }}" selected>{{ $preAssessment->preferred_course_3 }}</option>
                        @endif
                        @if(isset($courses))
                            @foreach($courses as $course)
                                <option value="{{ $course->name }}" {{ $preAssessment->preferred_course_3 == $course->name ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred University 3</label>
                    <select class="form-control select2-tags" name="preferred_university_3">
                        <option value=""></option>
                        @if($preAssessment->preferred_university_3 && (!isset($institutes) || !$institutes->contains('name', $preAssessment->preferred_university_3)))
                            <option value="{{ $preAssessment->preferred_university_3 }}" selected>{{ $preAssessment->preferred_university_3 }}</option>
                        @endif
                        @if(isset($institutes))
                            @foreach($institutes as $institute)
                                <option value="{{ $institute->name }}" {{ $preAssessment->preferred_university_3 == $institute->name ? 'selected' : '' }}>{{ $institute->name }}</option>
                            @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country of Choice</label>
                    <input class="form-control" type="text" name="country_of_choice" value="{{ $preAssessment->country_of_choice }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Intake Date</label>
                    <input class="form-control" type="date" name="intake_date" value="{{ $preAssessment->intake_date ?? '' }}">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Study Method</label>
                    <select class="form-select" name="study_method">
                      <option value="">Select...</option>
                      <option value="on_campus" {{ $preAssessment->study_method=='on_campus'?'selected':'' }}>On Campus</option>
                      <option value="online" {{ $preAssessment->study_method=='online'?'selected':'' }}>Online</option>
                      <option value="blended" {{ $preAssessment->study_method=='blended'?'selected':'' }}>Blended</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Source of Funding</label>
                    <select class="form-select" name="source_of_funding">
                      <option value="">Select...</option>
                      @foreach(['Self-funded','Family Sponsor','Scholarship','Government Sponsor','Bank Loan','Other'] as $sf)
                        <option value="{{ $sf }}" {{ $preAssessment->source_of_funding==$sf?'selected':'' }}>{{ $sf }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Bank Balance / Financial Details</label>
                    <textarea class="form-control" name="bank_balance_info" rows="3" placeholder="Optional: Provide bank balance or sponsorship details...">{{ $student->bank_balance_info }}</textarea>
                  </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(3)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-preferences', '{{ route('student.profile.preferences') }}', 5)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 5: Referees ═══════════ -->
            <div class="tab-section d-none" id="tab-5">
              <form id="form-referees">
                @csrf
                <div class="section-title"><i class="fas fa-users text-primary"></i> Referee Details</div>
                <p class="text-muted fs--1 mb-4">Please provide at least 2 referees (academic or professional).</p>
                @php $refCount = max(2, count($referees)); @endphp
                <div id="referees-container">
                  @for($i=0; $i<$refCount; $i++)
                    @php $ref = $referees[$i] ?? new \App\Models\StudentReferee(); @endphp
                    <div class="referee-card mb-3" id="ref-card-{{ $i }}">
                      <div class="referee-header d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-user-tie text-primary"></i> Referee <span class="ref-num">{{ $i+1 }}</span>
                        </div>
                        @if($i >= 2)
                          <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRefereeRow({{ $i }})"><i class="fas fa-trash"></i></button>
                        @endif
                      </div>
                      <div class="p-3 row g-2">
                        <input type="hidden" name="referees[{{ $i }}][id]" value="{{ $ref->id }}">
                        <div class="col-md-4">
                          <label class="form-label">Full Name</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][full_name]" value="{{ $ref->full_name }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Job Title</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][job_title]" value="{{ $ref->job_title }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Relationship</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][relationship]" value="{{ $ref->relationship }}" placeholder="e.g. Lecturer, Manager">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Email</label>
                          <input class="form-control" type="email" name="referees[{{ $i }}][email]" value="{{ $ref->email }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">Mobile / Phone</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][mobile]" value="{{ $ref->mobile }}">
                        </div>
                        <div class="col-md-4">
                          <label class="form-label">How Long Known?</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][how_long_known]" value="{{ $ref->how_long_known }}" placeholder="e.g. 3 years">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Organization Name</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][organization_name]" value="{{ $ref->organization_name }}">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Organization Address</label>
                          <input class="form-control" type="text" name="referees[{{ $i }}][organization_address]" value="{{ $ref->organization_address }}">
                        </div>
                      </div>
                    </div>
                  @endfor
                </div>
                <div class="text-end mb-4">
                  <button type="button" class="btn btn-sm btn-primary" onclick="addRefereeRow()"><i class="fas fa-plus me-1"></i> Add More Referee</button>
                </div>

                

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(4)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-referees', '{{ route('student.profile.referees') }}', 6)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 6: Documents ═══════════ -->
            <div class="tab-section d-none" id="tab-6">
              <div class="section-title"><i class="fas fa-folder-open text-primary"></i> Document Upload</div>
              <p class="text-muted fs--1 mb-3">Accepted formats: PDF, JPG, PNG, DOC. Max 5MB per file.</p>
              
              <form id="form-documents">
                @csrf
                <div id="documents-upload-container">
                  <div class="row g-3 mb-3 doc-upload-row" id="doc-row-0">
                    <div class="col-md-4">
                      <label class="form-label">Document Type</label>
                      <select class="form-select" name="documents[0][type]">
                        <option value="CV">CV / Resume</option>
                        <option value="Passport">Passport Copy</option>
                        <option value="Certificate">Academic Certificates</option>
                        <option value="Transcript">Academic Transcripts</option>
                        <option value="EnglishResult">English Test Result</option>
                        <option value="SOP">Statement of Purpose</option>
                        <option value="LOR">Letter of Reference</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Document Title</label>
                      <input class="form-control" type="text" name="documents[0][title]" placeholder="e.g. IELTS Report 2023">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Select File</label>
                      <input class="form-control" type="file" name="documents[0][file]">
                    </div>
                  </div>
                </div>
                
                <div class="mb-4">
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDocumentRow()"><i class="fas fa-plus"></i> Add More Document</button>
                  <button type="button" class="btn btn-sm btn-save ms-2" onclick="uploadMultipleDocs()">Upload Documents</button>
                </div>
              </form>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Uploaded Documents</h6>
                <form action="{{ route('student.profile.edit') }}" method="GET" class="d-flex" style="max-width: 300px;">
                  <input type="hidden" name="tab" value="6">
                  <input type="text" name="doc_search" class="form-control form-control-sm me-2" placeholder="Search..." value="{{ request('doc_search') }}">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                  @if(request('doc_search'))
                    <a href="{{ route('student.profile.edit') }}?tab=6#tab-6" class="btn btn-sm btn-outline-secondary ms-1"><i class="fas fa-times"></i></a>
                  @endif
                </form>
              </div>
              <div id="docs-list">
                @forelse($documents as $doc)
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border">
                    <div class="d-flex align-items-center gap-3">
                      <i class="fas fa-file-pdf text-danger fs-5"></i>
                      <div>
                        <div class="fw-600 fs--1">{{ $doc->document_type }} @if($doc->title) - {{ $doc->title }} @endif</div>
                        <div class="text-500 fs--2">{{ $doc->created_at->format('d M Y') }}</div>
                      </div>
                    </div>
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-download me-1"></i> View</a>
                  </div>
                @empty
                  <div class="text-center text-muted py-4"><i class="fas fa-inbox fs-3 mb-2 d-block"></i>No documents uploaded yet.</div>
                @endforelse
              </div>
              
              <div class="mt-3">
                {{ $documents->appends(request()->query())->fragment('tab-6')->links('pagination::bootstrap-5') }}
              </div>

              <div class="mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="switchTab(5)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                <button type="button" class="btn btn-primary ms-2" onclick="switchTab(7)">Next <i class="fas fa-arrow-right ms-1"></i></button>
              </div>
            </div>

            <!-- ═══════════ TAB 7: Download Documents (Admin Uploaded) ═══════════ -->
            <div class="tab-section d-none" id="tab-7">
              <div class="section-title"><i class="fas fa-download text-primary"></i> Download Documents</div>
              <p class="text-muted fs--1 mb-3">Documents uploaded by the administration for you.</p>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Admin Documents</h6>
                <form action="{{ route('student.profile.edit') }}" method="GET" class="d-flex" style="max-width: 300px;">
                  <input type="hidden" name="tab" value="7">
                  <input type="text" name="admin_doc_search" class="form-control form-control-sm me-2" placeholder="Search..." value="{{ request('admin_doc_search') }}">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                  @if(request('admin_doc_search'))
                    <a href="{{ route('student.profile.edit') }}?tab=7#tab-7" class="btn btn-sm btn-outline-secondary ms-1"><i class="fas fa-times"></i></a>
                  @endif
                </form>
              </div>

              <div id="admin-docs-list">
                @forelse($adminDocuments as $doc)
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border">
                    <div class="d-flex align-items-center gap-3">
                      <i class="fas fa-file-alt text-success fs-5"></i>
                      <div>
                        <div class="fw-600 fs--1">{{ $doc->document_type }} @if($doc->title) - {{ $doc->title }} @endif</div>
                        <div class="text-500 fs--2">{{ $doc->created_at->format('d M Y') }}</div>
                      </div>
                    </div>
                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill" download><i class="fas fa-download me-1"></i> Download</a>
                  </div>
                @empty
                  <div class="text-center text-muted py-4"><i class="fas fa-inbox fs-3 mb-2 d-block"></i>No documents from admin yet.</div>
                @endforelse
              </div>

              <div class="mt-3">
                {{ $adminDocuments->appends(request()->query())->fragment('tab-7')->links('pagination::bootstrap-5') }}
              </div>

              <div class="mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="switchTab(6)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                <a href="{{ route('dashboard') }}" class="btn btn-success ms-2"><i class="fas fa-check-circle me-1"></i> Finish & Submit</a>
              </div>
            </div>

          </div><!-- /p-4 -->
        </div><!-- /col-md-9 -->
      </div><!-- /row -->
    </div><!-- /student-wizard-card -->
  </div>
</div>

<!-- Toast Notification -->
<div id="save-toast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
  <div class="d-flex">
    <div class="toast-body" id="toast-message">Saved!</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
  </div>
</div>
@endsection

@push('scripts')
<script>
let currentTab = 0;
let academicRowCount = {{ $academics->count() }};

function switchTab(index) {
    // Hide all
    document.querySelectorAll('.tab-section').forEach(s => s.classList.add('d-none'));
    document.querySelectorAll('.step-nav-item').forEach(n => n.classList.remove('active'));
    // Show selected
    document.getElementById('tab-' + index).classList.remove('d-none');
    
    let navItem = document.getElementById('nav-' + index);
    if(navItem) navItem.classList.add('active');
    
    currentTab = index;
    // Update progress bar (8 steps)
    document.getElementById('mainProgressBar').style.width = (((index + 1) / 8) * 100) + '%';
    // Update URL hash without scroll
    history.replaceState(null, '', '#tab-' + index);
}

// ─── Sidebar active link highlight ───
function updateSidebarActiveLink(index) {
    document.querySelectorAll('.student-tab-link').forEach(link => {
        link.classList.remove('active');
        if (parseInt(link.getAttribute('data-tab')) === index) {
            link.classList.add('active');
        }
    });
}

// ─── Handle sidebar link click (works on same page) ───
function handleStudentTabClick(event, index) {
    // If we are already on the student dashboard, switch tab without navigation
    if (document.getElementById('tab-content-area')) {
        event.preventDefault();
        switchTab(index);
        updateSidebarActiveLink(index);
    }
    // Otherwise let the link navigate normally (hash will be read on load)
}

// ─── Auto-switch based on URL hash or query param on page load ───
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    let hash = window.location.hash;

    let targetTab = null;

    if (hash && hash.startsWith('#tab-')) {
        targetTab = parseInt(hash.replace('#tab-', ''));
    } else if (tabParam !== null) {
        targetTab = parseInt(tabParam);
    }

    if (targetTab !== null && !isNaN(targetTab) && targetTab >= 0 && targetTab <= 7) {
        switchTab(targetTab);
        updateSidebarActiveLink(targetTab);
    } else {
        updateSidebarActiveLink(0); // default: Personal Info active
    }

    // Also handle hash change if user navigates via browser back/forward
    window.addEventListener('hashchange', function() {
        const h = window.location.hash;
        if (h && h.startsWith('#tab-')) {
            const i = parseInt(h.replace('#tab-', ''));
            if (!isNaN(i) && i >= 0 && i <= 6) {
                switchTab(i);
                updateSidebarActiveLink(i);
            }
        }
    });
});

function showToast(message, isSuccess) {
    const toast = document.getElementById('save-toast');
    const msg = document.getElementById('toast-message');
    msg.textContent = message;
    toast.className = 'toast align-items-center border-0 ' + (isSuccess ? 'toast-success' : 'toast-error');
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}

function saveAndContinue(formId, url, nextTab) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    // Disable button
    const btns = form.querySelectorAll('button[type=button]');
    btns.forEach(b => { b.disabled = true; });

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, true);
            // Mark nav item as completed
            document.getElementById('nav-' + currentTab).classList.add('completed');
            if (nextTab !== undefined) setTimeout(() => switchTab(nextTab), 600);
        } else {
            showToast(data.message || 'Failed to save. Please try again.', false);
        }
    })
    .catch(err => {
        showToast('Network error. Please check your connection.', false);
        console.error(err);
    })
    .finally(() => {
        btns.forEach(b => { b.disabled = false; });
    });
}

function addAcademicRow() {
    const idx = academicRowCount++;
    const container = document.getElementById('academics-container');
    const html = `
    <div class="academic-row new-row" id="aca-row-${idx}">
        <button type="button" class="remove-row-btn" onclick="removeAcademicRow(${idx})"><i class="fas fa-times-circle"></i></button>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Education Level</label>
                <select class="form-select" name="academics[${idx}][education_level]">
                    <option value="">Select...</option>
                    <option value="10th Grade">10th Grade</option>
                    <option value="12th Grade/A-Level">12th Grade / A-Level</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Bachelor's Degree">Bachelor's Degree</option>
                    <option value="Master's Degree">Master's Degree</option>
                    <option value="PhD/Doctorate">PhD / Doctorate</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input class="form-control" type="text" name="academics[${idx}][country]" placeholder="Country of institution">
            </div>
            <div class="col-md-4">
                <label class="form-label">Institution Name</label>
                <input class="form-control" type="text" name="academics[${idx}][institution_name]" placeholder="University / School name">
            </div>
            <div class="col-md-4">
                <label class="form-label">Course / Subject</label>
                <input class="form-control" type="text" name="academics[${idx}][course_name]" placeholder="e.g. BSc Computer Science">
            </div>
            <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input class="form-control" type="date" name="academics[${idx}][start_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input class="form-control" type="date" name="academics[${idx}][end_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Award Date</label>
                <input class="form-control" type="date" name="academics[${idx}][award_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Result / %</label>
                <input class="form-control" type="text" name="academics[${idx}][result_percentage]" placeholder="e.g. 85%">
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function removeAcademicRow(idx) {
    const row = document.getElementById('aca-row-' + idx);
    if (row) row.remove();
}

let refIdx = {{ max(2, count($referees)) }};
function addRefereeRow() {
    const container = document.getElementById('referees-container');
    const idx = refIdx++;
    const html = `
    <div class="referee-card mb-3" id="ref-card-${idx}">
      <div class="referee-header d-flex justify-content-between align-items-center">
        <div>
          <i class="fas fa-user-tie text-primary"></i> Referee <span class="ref-num">${idx + 1}</span>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRefereeRow(${idx})"><i class="fas fa-trash"></i></button>
      </div>
      <div class="p-3 row g-2">
        <input type="hidden" name="referees[${idx}][id]" value="">
        <div class="col-md-4">
          <label class="form-label">Full Name</label>
          <input class="form-control" type="text" name="referees[${idx}][full_name]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Job Title</label>
          <input class="form-control" type="text" name="referees[${idx}][job_title]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Relationship</label>
          <input class="form-control" type="text" name="referees[${idx}][relationship]" value="" placeholder="e.g. Lecturer, Manager">
        </div>
        <div class="col-md-4">
          <label class="form-label">Email</label>
          <input class="form-control" type="email" name="referees[${idx}][email]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Mobile / Phone</label>
          <input class="form-control" type="text" name="referees[${idx}][mobile]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">How Long Known?</label>
          <input class="form-control" type="text" name="referees[${idx}][how_long_known]" value="" placeholder="e.g. 3 years">
        </div>
        <div class="col-md-6">
          <label class="form-label">Organization Name</label>
          <input class="form-control" type="text" name="referees[${idx}][organization_name]" value="">
        </div>
        <div class="col-md-6">
          <label class="form-label">Organization Address</label>
          <input class="form-control" type="text" name="referees[${idx}][organization_address]" value="">
        </div>
      </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    updateRefereeNumbers();
}

function removeRefereeRow(idx) {
    const row = document.getElementById('ref-card-' + idx);
    if (row) row.remove();
    updateRefereeNumbers();
}

function updateRefereeNumbers() {
    const cards = document.querySelectorAll('#referees-container .referee-card');
    cards.forEach((card, index) => {
        const numSpan = card.querySelector('.ref-num');
        if (numSpan) numSpan.textContent = index + 1;
    });
}

let docIdx = 1;
function addDocumentRow() {
    const container = document.getElementById('documents-upload-container');
    const idx = docIdx++;
    const html = `
    <div class="row g-3 mb-3 doc-upload-row" id="doc-row-${idx}">
      <div class="col-md-4">
        <label class="form-label">Document Type</label>
        <select class="form-select" name="documents[${idx}][type]">
          <option value="CV">CV / Resume</option>
          <option value="Passport">Passport Copy</option>
          <option value="Certificate">Academic Certificates</option>
          <option value="Transcript">Academic Transcripts</option>
          <option value="EnglishResult">English Test Result</option>
          <option value="SOP">Statement of Purpose</option>
          <option value="LOR">Letter of Reference</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Document Title</label>
        <input class="form-control" type="text" name="documents[${idx}][title]" placeholder="e.g. IELTS Report 2023">
      </div>
      <div class="col-md-3">
        <label class="form-label">Select File</label>
        <input class="form-control" type="file" name="documents[${idx}][file]">
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button type="button" class="btn btn-outline-danger w-100 px-2" onclick="removeDocumentRow(${idx})"><i class="fas fa-trash"></i></button>
      </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function removeDocumentRow(idx) {
    const row = document.getElementById('doc-row-' + idx);
    if (row) row.remove();
}

function uploadMultipleDocs() {
    const form = document.getElementById('form-documents');
    const formData = new FormData(form);
    
    // Check if at least one file is selected
    let hasFile = false;
    for (let [key, value] of formData.entries()) {
        if (value instanceof File && value.name !== '') {
            hasFile = true;
            break;
        }
    }
    
    if (!hasFile) {
        showToast('Please select at least one file to upload.', false);
        return;
    }

    const btns = form.querySelectorAll('button');
    btns.forEach(b => b.disabled = true);

    fetch('{{ route('student.profile.upload') }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, true);
            setTimeout(() => {
                window.location.href = window.location.pathname + '?tab=6#tab-6';
                window.location.reload();
            }, 1000);
        } else {
            showToast(data.message, false);
        }
    })
    .catch(() => showToast('Upload failed. Try again.', false))
    .finally(() => {
        btns.forEach(b => b.disabled = false);
    });
}
</script>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-tags').select2({
        tags: true,
        placeholder: "Select from dropdown or type your own",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endpush

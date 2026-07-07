@extends('layouts.backend_master')
@section('title', 'Assessment Details')

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Assessment Details: {{ $assessment->full_name }}</h4>
            <a href="{{ route('admin.pre.assessments.index', ['status' => $assessment->assessment_status]) }}" class="btn btn-secondary btn-sm">
                <i class="mdi mdi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3"><i class="mdi mdi-account-circle me-1"></i> Personal Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Full Name</p>
                        <h5 class="m-0 font-14">{{ $assessment->full_name }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Email</p>
                        <h5 class="m-0 font-14">{{ $assessment->student->email ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Contact Number</p>
                        <h5 class="m-0 font-14">{{ $assessment->contact_number }}</h5>
                    </div>
                    <div class="col-md-3 mb-3">
                        <p class="text-muted mb-1 font-13">Gender</p>
                        <h5 class="m-0 font-14">{{ $assessment->gender ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-3 mb-3">
                        <p class="text-muted mb-1 font-13">Nationality</p>
                        <h5 class="m-0 font-14">{{ $assessment->nationality ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-3 mb-3">
                        <p class="text-muted mb-1 font-13">Date of Birth</p>
                        <h5 class="m-0 font-14">{{ $assessment->dob ? $assessment->dob : 'N/A' }}</h5>
                    </div>
                    <div class="col-md-3 mb-3">
                        <p class="text-muted mb-1 font-13">Passport Number</p>
                        <h5 class="m-0 font-14">{{ $assessment->passport_number ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="text-muted mb-1 font-13">Address</p>
                        <h5 class="m-0 font-14">{{ $assessment->contact_address }}</h5>
                    </div>
                </div>

                <h5 class="text-uppercase bg-light p-2 mt-4 mb-3"><i class="mdi mdi-school me-1"></i> Academic Background</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Highest Qualification</p>
                        <h5 class="m-0 font-14">{{ $assessment->highest_qualification }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Institution / College</p>
                        <h5 class="m-0 font-14">{{ $assessment->name_of_institution ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Year of Passing</p>
                        <h5 class="m-0 font-14">{{ $assessment->year_of_passing ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Grade / GPA</p>
                        <h5 class="m-0 font-14">{{ $assessment->grades_gpa ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Field of Study</p>
                        <h5 class="m-0 font-14">{{ $assessment->field_of_study ?? 'N/A' }}</h5>
                    </div>

                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Second Qualification</p>
                        <h5 class="m-0 font-14">{{ $assessment->second_qualification ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Second Institution</p>
                        <h5 class="m-0 font-14">{{ $assessment->second_institution ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <p class="text-muted mb-1 font-13">Sec. Year of Passing</p>
                        <h5 class="m-0 font-14">{{ $assessment->second_year_of_passing ?? 'N/A' }}</h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">English Proficiency</p>
                        <h5 class="m-0 font-14">{{ $assessment->english_proficiency }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">English Score</p>
                        <h5 class="m-0 font-14">{{ $assessment->english_score ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="text-muted mb-1 font-13">Work Experience</p>
                        <h5 class="m-0 font-14">{{ $assessment->work_experience ?? 'N/A' }}</h5>
                    </div>
                </div>

                <h5 class="text-uppercase bg-light p-2 mt-4 mb-3"><i class="mdi mdi-earth me-1"></i> Study Plan</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Study Destination</p>
                        <h5 class="m-0 font-14">{{ $assessment->study_destination }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Preferred Intake</p>
                        <h5 class="m-0 font-14">{{ $assessment->preferred_intake ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Level of Study</p>
                        <h5 class="m-0 font-14">{{ $assessment->level_of_study }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Intended Course</p>
                        <h5 class="m-0 font-14">{{ $assessment->intended_course }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1 font-13">Financial Source</p>
                        <h5 class="m-0 font-14">{{ $assessment->financial_source }}</h5>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="text-muted mb-1 font-13">Course Link</p>
                        <h5 class="m-0 font-14">
                            @if($assessment->course_link)
                                <a href="{{ $assessment->course_link }}" target="_blank">{{ $assessment->course_link }}</a>
                            @else
                                N/A
                            @endif
                        </h5>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="text-muted mb-1 font-13">Visa Refusal History</p>
                        <h5 class="m-0 font-14">{{ $assessment->visa_refusal_history ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-6 mb-3">
                        <p class="text-muted mb-1 font-13">Previous UK Study</p>
                        <h5 class="m-0 font-14">{{ $assessment->previous_uk_study_history ?? 'N/A' }}</h5>
                    </div>
                    <div class="col-12 mb-3">
                        <p class="text-muted mb-1 font-13">Purpose of Study</p>
                        <h5 class="m-0 font-14">{{ $assessment->purpose_of_study ?? 'N/A' }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Approval Status</h4>
                
                <div class="mb-3">
                    @if($assessment->isPending())
                        <div class="alert alert-warning border-0 rounded-0">
                            <strong>Status:</strong> Pending Review
                        </div>
                    @elseif($assessment->isApproved())
                        <div class="alert alert-success border-0 rounded-0">
                            <strong>Status:</strong> Approved
                            <p class="mb-0 mt-2 font-13">
                                By: {{ $assessment->approvedBy->name ?? 'Admin' }}<br>
                                Date: {{ $assessment->approved_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                    @elseif($assessment->isRejected())
                        <div class="alert alert-danger border-0 rounded-0">
                            <strong>Status:</strong> Rejected
                            <p class="mb-0 mt-2 font-13">
                                By: {{ $assessment->approvedBy->name ?? 'Admin' }}<br>
                                Date: {{ $assessment->approved_at->format('d M Y, h:i A') }}
                            </p>
                        </div>
                        <div class="mt-2 p-2 bg-light border">
                            <strong class="font-13">Reason:</strong>
                            <p class="mb-0 font-13">{{ $assessment->rejection_note }}</p>
                        </div>
                    @endif
                </div>

                @if($assessment->isPending())
                    <form action="{{ route('admin.pre.assessments.approve', $assessment->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Are you sure you want to approve this student?')">
                            <i class="mdi mdi-check-all"></i> Approve Application
                        </button>
                    </form>

                    <hr>

                    <form action="{{ route('admin.pre.assessments.reject', $assessment->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label for="rejection_note" class="form-label font-13 text-danger">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea name="rejection_note" id="rejection_note" class="form-control" rows="3" placeholder="Provide a reason for rejection..." required></textarea>
                            @error('rejection_note')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to reject this student?')">
                            <i class="mdi mdi-close"></i> Reject Application
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

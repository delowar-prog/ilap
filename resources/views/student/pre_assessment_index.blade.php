@extends('layouts.backend_master')
@section('title', 'My Pre-Assessment')

@section('admin_contents')
<div class="row justify-content-center">
    <div class="col-xl-10">
        


        <div class="page-title-box d-flex justify-content-between align-items-center mt-3">
            <h4 class="page-title">My Pre-Assessment Application</h4>
            @if(!$assessment->isApproved())
                <a href="{{ route('pre.assessment.show') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-pencil"></i> Edit Application
                </a>
            @endif
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="header-title mb-3">Application Summary</h4>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-13">Full Name</div>
                            <div class="col-sm-8 fw-semibold font-14">{{ $assessment->full_name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-13">Contact Number</div>
                            <div class="col-sm-8 fw-semibold font-14">{{ $assessment->contact_number }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-13">Intended Course</div>
                            <div class="col-sm-8 fw-semibold font-14">{{ $assessment->intended_course }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-13">Study Destination</div>
                            <div class="col-sm-8 fw-semibold font-14">{{ $assessment->study_destination }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-13">Submitted On</div>
                            <div class="col-sm-8 fw-semibold font-14">{{ $assessment->updated_at->format('d M Y, h:i A') }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 border-start">
                        <h4 class="header-title mb-3">Current Status</h4>
                        
                        @if($assessment->isPending())
                            <div class="alert alert-warning border-0 rounded-0">
                                <h5><i class="mdi mdi-clock-outline me-1"></i> Under Review</h5>
                                <p class="mb-0 font-13 mt-2">Your application has been successfully submitted and is currently being reviewed by our admissions team.</p>
                            </div>
                        @elseif($assessment->isApproved())
                            @if(!$student->enrolment_status)
                                <div class="alert alert-success border-0 rounded-0">
                                    <h5><i class="mdi mdi-check-circle-outline me-1"></i> Approved</h5>
                                    <p class="mb-0 font-13 mt-2">Congratulations! Your pre-assessment has been approved. Please wait while the admissions team reviews and moves your application to Pre-Enrolment.</p>
                                </div>
                            @else
                                <div class="alert alert-success border-0 rounded-0">
                                    <h5><i class="mdi mdi-check-circle-outline me-1"></i> Sent to Pre-Enrolment</h5>
                                    <p class="mb-0 font-13 mt-2">Congratulations! Your pre-assessment has been approved and moved to Pre-Enrolment. You now have full access to fill in and submit your profile.</p>
                                </div>
                            @endif
                        @elseif($assessment->isRejected())
                            <div class="alert alert-danger border-0 rounded-0">
                                <h5><i class="mdi mdi-close-circle-outline me-1"></i> Revisions Required</h5>
                                <p class="mb-0 font-13 mt-2">Your application requires some changes before we can proceed.</p>
                                
                                @if($assessment->rejection_note)
                                    <div class="mt-3 p-2 bg-white border border-danger rounded">
                                        <strong>Admin Note:</strong><br>
                                        {{ $assessment->rejection_note }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

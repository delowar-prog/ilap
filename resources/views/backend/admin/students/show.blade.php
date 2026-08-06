@extends('layouts.backend_master')

@section('title', 'Student Profile - ' . ($student->first_name ?? ''))

@push('css')
<style>
.profile-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 2rem;
}
.profile-header {
    background: linear-gradient(135deg, #1b2a47 0%, #2c3e7a 100%);
    color: #fff;
    padding: 2.5rem;
    position: relative;
}
.profile-avatar-container {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}
.profile-avatar {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.2);
    object-fit: cover;
    background: rgba(255,255,255,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: #fff;
}
.profile-header-info h2 {
    margin: 0 0 0.2rem;
    font-weight: 700;
    color: #fff;
}
.profile-header-info p {
    margin: 0;
    opacity: 0.85;
}
.profile-back-btn {
    position: absolute;
    top: 2rem;
    right: 2.5rem;
}

/* Custom Unified Nav Bar Styling */
.custom-profile-tabs {
    border-bottom: none;
}
.custom-profile-tabs .nav-link {
    font-size: 0.92rem;
    color: #475569;
    border-radius: 8px 8px 0 0;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 0.75rem 1.25rem;
    transition: all 0.2s ease-in-out;
}
.custom-profile-tabs .nav-link:hover {
    color: #1e293b;
    background: rgba(241, 245, 249, 0.8);
}
.custom-profile-tabs .nav-link.active {
    color: #1e40af !important;
    background: #ffffff !important;
    font-weight: 700;
    border-bottom: 3px solid #1e40af;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.03);
}

.info-section {
    padding: 1.75rem 2rem;
    border-bottom: 1px solid #edf2f9;
}
.info-section:last-child {
    border-bottom: none;
}
.info-section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e7a;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}
.info-item label {
    display: block;
    font-size: 0.85rem;
    color: #95aac9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}
.info-item span {
    display: block;
    font-weight: 500;
    color: #344050;
    font-size: 1rem;
}
.table-custom th {
    background: #f8f9fa;
    color: #5e6e82;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
}
.download-icon-btn {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(220, 53, 69, 0.25);
    transition: transform 0.2s ease;
}
.download-icon-btn:hover {
    transform: scale(1.08);
}
</style>
@endpush

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="profile-card">
            
            <!-- Header Section -->
            <div class="profile-header">
                <a href="{{ route('admin.students.index') }}" class="btn btn-light btn-sm profile-back-btn shadow-sm fw-semibold">
                    <i class="fas fa-arrow-left me-1"></i> Back to Students
                </a>
                <div class="profile-avatar-container">
                    @if($student->profile_picture)
                        <img src="{{ asset($student->profile_picture) }}" alt="Profile" class="profile-avatar">
                    @else
                        <div class="profile-avatar">
                            {{ strtoupper(substr($student->first_name,0,1)) }}{{ strtoupper(substr($student->surname,0,1)) }}
                        </div>
                    @endif
                    <div class="profile-header-info">
                        <h2>{{ ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname)) }}</h2>
                        <p><i class="fas fa-id-badge me-1"></i> {{ $student->student_id }} &nbsp;|&nbsp; <i class="fas fa-envelope me-1"></i> {{ $student->email }}</p>
                        <div class="mt-2 text-white-50 small">
                            Profile Completion: <strong class="text-white me-3">{{ $completionPercent }}%</strong>
                            Status: 
                            @if($student->enrolment_status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($student->enrolment_status === 'enrolled')
                                <span class="badge bg-primary">Enrolled</span>
                                <button type="button" class="btn btn-xs btn-outline-light ms-2 text-white border-white-50" data-bs-toggle="modal" data-bs-target="#terminateStudentModal" title="Terminate / Discontinue Student">
                                    <i class="fas fa-user-slash me-1"></i> Terminate Student
                                </button>
                            @elseif($student->enrolment_status === 'terminated')
                                <span class="badge bg-dark px-2 py-1"><i class="fas fa-user-slash me-1"></i> Terminated</span>
                                <form action="{{ route('admin.students.reinstall', $student->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-outline-success text-white border-success-subtle" title="Re-enroll Student">
                                        <i class="fas fa-undo me-1"></i> Re-enroll Student
                                    </button>
                                </form>
                            @elseif($student->enrolment_status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unified Top Navigation Bar (Profile, Course, Letters, Invoices, Chatting, Email, Support) -->
            <div class="px-3 pt-2 bg-light border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <ul class="nav nav-tabs custom-profile-tabs border-0 align-items-center flex-wrap" id="studentProfileTabs" role="tablist">
                        <!-- 1. Profile Tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-profile-btn" data-bs-toggle="tab" data-bs-target="#tab-profile" type="button" role="tab" aria-controls="tab-profile" aria-selected="true">
                                <i class="fas fa-user me-1 text-primary"></i> Profile
                            </button>
                        </li>
                        <!-- 2. Course Tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-course-btn" data-bs-toggle="tab" data-bs-target="#tab-course" type="button" role="tab" aria-controls="tab-course" aria-selected="false">
                                <i class="fas fa-graduation-cap me-1 text-info"></i> Course
                            </button>
                        </li>
                        <!-- 3. Letters Tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-letters-btn" data-bs-toggle="tab" data-bs-target="#tab-letters" type="button" role="tab" aria-controls="tab-letters" aria-selected="false">
                                <i class="fas fa-envelope-open-text me-1 text-warning"></i> Letters
                                <span class="badge bg-primary rounded-pill ms-1">{{ isset($letterHistory) ? $letterHistory->count() : 0 }}</span>
                            </button>
                        </li>
                        <!-- 4. Invoices Tab -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-invoices-btn" data-bs-toggle="tab" data-bs-target="#tab-invoices" type="button" role="tab" aria-controls="tab-invoices" aria-selected="false">
                                <i class="fas fa-file-invoice-dollar me-1 text-success"></i> Invoices
                                <span class="badge bg-success rounded-pill ms-1">{{ isset($invoiceHistory) ? $invoiceHistory->count() : 0 }}</span>
                            </button>
                        </li>
                        <!-- 5. Chatting Button -->
                        <li class="nav-item my-1 ms-md-2">
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Chatting', text: 'Chatting option is coming soon!', icon: 'info'})">
                                <i class="fas fa-comments me-1 text-info"></i> Chatting
                            </a>
                        </li>
                        <!-- 6. Email Button -->
                        <li class="nav-item my-1 ms-1">
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Email', text: 'Email communication option is coming soon!', icon: 'info'})">
                                <i class="fas fa-envelope me-1 text-warning"></i> Email
                            </a>
                        </li>
                        <!-- 7. Support Button -->
                        <li class="nav-item my-1 ms-1">
                            <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Support', text: 'Support ticket/queries option is coming soon!', icon: 'info'})">
                                <i class="fas fa-headset me-1 text-success"></i> Support
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content Panes -->
            <div class="tab-content" id="studentProfileTabsContent">
                
                <!-- ==================== TAB 1: PROFILE ==================== -->
                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="tab-profile-btn">

                    <!-- Profile Tab Header with Download PDF Icon Only -->
                    <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-info-circle text-primary me-2"></i> Student Details & Documents</h6>
                        <a href="{{ route('admin.students.profile.pdf', $student->id) }}" class="btn btn-danger btn-sm download-icon-btn" data-bs-toggle="tooltip" title="Download Profile PDF">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>

                    <!-- Referral Info (Only visible to the owner and enrolled students) -->
                    @if(Auth::id() == $student->user_id && $student->enrolment_status === 'enrolled')
                    <div class="info-section bg-light" style="border-bottom: 2px solid #e1e8f1;">
                        <div class="info-section-title"><i class="fas fa-bullhorn text-primary"></i> Invite Friends</div>
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <p class="text-muted mb-2">Share this invite link for new registrations.</p>
                                <div class="input-group mb-3 shadow-sm">
                                    <span class="input-group-text bg-white"><i class="fas fa-link text-primary"></i></span>
                                    <input type="text" class="form-control bg-white" id="inviteLinkInput" value="{{ url('/register/' . ($student->user_id ?? '')) }}" readonly>
                                    <button class="btn btn-primary" type="button" onclick="copyInviteLink()"><i class="fas fa-copy"></i> Copy</button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="info-grid" style="grid-template-columns: 1fr 1fr;">
                                    <div class="info-item">
                                        <label>Your Promo Code</label>
                                        <span class="badge bg-success" style="font-size: 1rem; padding: 8px 12px;">{{ $student->user->referral_code ?? 'N/A' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Your Campus Code</label>
                                        <span class="badge bg-info text-dark" style="font-size: 1rem; padding: 8px 12px;">{{ $student->campus ? $student->campus->campus_code : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Personal Info -->
                    <div class="info-section">
                        <div class="info-section-title"><i class="fas fa-user-circle text-primary"></i> Personal Information</div>
                        <div class="info-grid">
                            <div class="info-item"><label>First Name</label><span>{{ $student->first_name ?? $preAssessment->first_name }}</span></div>
                            <div class="info-item"><label>Middle Name</label><span>{{ $student->middle_name ?? $preAssessment->middle_name ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>Last Name (Surname)</label><span>{{ $student->surname ?? $preAssessment->surname }}</span></div>
                            <div class="info-item">
                                <label>Preferred Institute</label>
                                <span>
                                    <span class="badge bg-primary">
                                        @if($student->institute)
                                            {{ $student->institute->name }}
                                        @elseif($preAssessment->institute_name)
                                            {{ $preAssessment->institute_name }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </span>
                            </div>
                            <div class="info-item">
                                <label>Date of Birth</label>
                                <span>
                                    @php
                                        $dobVal = $student->dob ?? $preAssessment->dob;
                                    @endphp
                                    {{ $dobVal ? ($dobVal instanceof \DateTimeInterface ? $dobVal->format('d M Y') : date('d M Y', strtotime($dobVal))) : 'N/A' }}
                                </span>
                            </div>
                            <div class="info-item"><label>Gender</label><span>{{ $student->gender ?? $preAssessment->gender ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>Country of Nationality</label><span>{{ $student->nationality ?? $preAssessment->nationality ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>Country of Birth</label><span>{{ $student->country_of_birth ?? $preAssessment->country ?? 'N/A' }}</span></div>
                            <div class="info-item">
                                <label>Country of Residence</label>
                                <span>
                                    @if($student->country)
                                        {{ $student->country->name }}
                                    @elseif($preAssessment->country)
                                        {{ $preAssessment->country }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="info-item"><label>Phone</label><span>{{ $student->phone ?? $preAssessment->contact_number ?? 'N/A' }}</span></div>
                            <div class="info-item">
                                <label>WhatsApp Status</label>
                                <span>
                                    @if($student->has_whatsapp)
                                        <span class="badge bg-success"><i class="fab fa-whatsapp me-1"></i> Available on {{ $student->phone }}</span>
                                    @else
                                        <span class="badge bg-secondary">Not Marked</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="info-section bg-light">
                        <div class="info-section-title"><i class="fas fa-map-marker-alt text-danger"></i> Contact & Address</div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Permanent Address</h6>
                                <div class="info-grid" style="grid-template-columns: 1fr;">
                                    <div class="info-item"><label>Address</label><span>{{ $student->permanent_address ?? $preAssessment->contact_address ?? 'N/A' }}</span></div>
                                    <div class="info-item">
                                        <label>City & Postcode</label>
                                        <span>
                                            @php
                                                $permAddr = trim(($student->permanent_city ?? '').' '.($student->permanent_postcode ?? ''));
                                                $preAddr = implode(', ', array_filter([$preAssessment->city, $preAssessment->state, $preAssessment->postal_code]));
                                            @endphp
                                            @if($permAddr !== '')
                                                {{ $permAddr }}
                                            @elseif($preAddr !== '')
                                                {{ $preAddr }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-item"><label>Country</label><span>{{ $student->permanent_country ?? $preAssessment->country ?? 'N/A' }}</span></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Current Address</h6>
                                <div class="info-grid" style="grid-template-columns: 1fr;">
                                    <div class="info-item"><label>Address</label><span>{{ $student->current_address ?? $preAssessment->contact_address ?? 'N/A' }}</span></div>
                                    <div class="info-item">
                                        <label>City & Postcode</label>
                                        <span>
                                            @php
                                                $currAddr = trim(($student->current_city ?? '').' '.($student->current_postcode ?? ''));
                                                $preAddr = implode(', ', array_filter([$preAssessment->city, $preAssessment->state, $preAssessment->postal_code]));
                                            @endphp
                                            @if($currAddr !== '')
                                                {{ $currAddr }}
                                            @elseif($preAddr !== '')
                                                {{ $preAddr }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
                                    </div>
                                    <div class="info-item"><label>Country</label><span>{{ $student->current_country ?? $preAssessment->country ?? 'N/A' }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Passport & Travel Info -->
                    <div class="info-section">
                        <div class="info-section-title"><i class="fas fa-passport text-info"></i> Passport & Travel History</div>
                        <div class="info-grid mb-4">
                            <div class="info-item"><label>Name in Passport</label><span>{{ $student->name_in_passport ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>Passport Number</label><span>{{ $student->passport_number ?? $preAssessment->passport_number ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>Issue Date</label><span>{{ $student->passport_issue_date ? $student->passport_issue_date->format('d M Y') : 'N/A' }}</span></div>
                            <div class="info-item"><label>Expiry Date</label><span>{{ $student->passport_expiry_date ? $student->passport_expiry_date->format('d M Y') : 'N/A' }}</span></div>
                            <div class="info-item"><label>Issue Location</label><span>{{ $student->passport_issue_location ?? 'N/A' }}</span></div>
                        </div>
                        
                        @php
                            $travelHistory = $student->travel_history ?? $preAssessment->travel_history ?? [];
                            $immigrationHistory = $student->immigration_history ?? $preAssessment->immigration_history ?? [];
                            $visaRefusals = $student->visa_refusals ?? $preAssessment->visa_refusals ?? [];
                            $takenTbTest = $student->taken_tb_test ?? 'N/A';
                        @endphp
                        <h6 class="text-muted text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">Travel & Immigration History</h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="p-3 border rounded bg-light font-13">
                                    <strong>Permission to remain in past 10 years:</strong> 
                                    <span class="badge {{ ($travelHistory['has_history'] ?? '') === 'yes' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ strtoupper($travelHistory['has_history'] ?? 'No') }}
                                    </span>
                                    @if(($travelHistory['has_history'] ?? '') === 'yes')
                                        @php
                                            $tEntries = $travelHistory['entries'] ?? [];
                                            if (empty($tEntries) && (!empty($travelHistory['country']) || !empty($travelHistory['arrival_date']))) {
                                                $tEntries = [$travelHistory];
                                            }
                                        @endphp
                                        @foreach($tEntries as $idx => $tEntry)
                                            <div class="mt-2 ps-3 border-start border-3 border-primary mb-2">
                                                @if(count($tEntries) > 1)<div class="fw-bold text-primary mb-1 font-12">Travel Entry #{{ $idx + 1 }}</div>@endif
                                                <div class="row g-2">
                                                    <div class="col-md-6"><strong>Country:</strong> {{ $tEntry['country'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Visa Type:</strong> {{ $tEntry['visa_type'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Purpose:</strong> {{ $tEntry['purpose_of_visit'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Arrival Date:</strong> {{ $tEntry['arrival_date'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Departure Date:</strong> {{ $tEntry['departure_date'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Visa Validity:</strong> {{ $tEntry['visa_start_date'] ?? 'N/A' }} to {{ $tEntry['visa_expiry_date'] ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="p-3 border rounded bg-light font-13">
                                    <strong>Needs visa for:</strong> 
                                    @php
                                        $immCountries = $immigrationHistory['countries'] ?? [];
                                    @endphp
                                    @if(empty($immCountries) || in_array('None', $immCountries))
                                        <span class="badge bg-secondary">None</span>
                                    @else
                                        @foreach($immCountries as $country)
                                            <span class="badge bg-success me-1">{{ $country }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="p-3 border rounded bg-light font-13">
                                    <strong>Refused visa/asylum/deported:</strong> 
                                    <span class="badge {{ ($visaRefusals['has_refusal'] ?? '') === 'yes' ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ strtoupper($visaRefusals['has_refusal'] ?? 'No') }}
                                    </span>
                                    @if(($visaRefusals['has_refusal'] ?? '') === 'yes')
                                        @php
                                            $rEntries = $visaRefusals['entries'] ?? [];
                                            if (empty($rEntries) && (!empty($visaRefusals['country']) || !empty($visaRefusals['refusal_type']))) {
                                                $rEntries = [$visaRefusals];
                                            }
                                        @endphp
                                        @foreach($rEntries as $idx => $rEntry)
                                            <div class="mt-2 ps-3 border-start border-3 border-danger mb-2">
                                                @if(count($rEntries) > 1)<div class="fw-bold text-danger mb-1 font-12">Refusal Entry #{{ $idx + 1 }}</div>@endif
                                                <div class="row g-2">
                                                    <div class="col-md-6"><strong>Country:</strong> {{ $rEntry['country'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Visa Type:</strong> {{ $rEntry['visa_type'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Refusal Type:</strong> {{ $rEntry['refusal_type'] ?? 'N/A' }}</div>
                                                    <div class="col-md-6"><strong>Date of Refusal:</strong> {{ $rEntry['refusal_date'] ?? 'N/A' }}</div>
                                                    <div class="col-md-12"><strong>Details/Reason:</strong> {{ $rEntry['details'] ?? 'N/A' }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="p-3 border rounded bg-light font-13">
                                    <strong>TB Test Details:</strong> {{ $takenTbTest }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academics -->
                    <div class="info-section bg-light">
                        <div class="info-section-title"><i class="fas fa-graduation-cap text-success"></i> Academic History</div>
                        @if($academics->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-custom mb-0 border">
                                <thead>
                                    <tr>
                                        <th>Education Level</th>
                                        <th>Institution</th>
                                        <th>Course</th>
                                        <th>Start - End Date</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($academics as $aca)
                                    <tr>
                                        <td>{{ $aca->education_level }}</td>
                                        <td>
                                            {{ $aca->institution_name }}<br>
                                            <small class="text-muted">
                                                {{ array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country]) ? implode(', ', array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country])) : 'N/A' }}
                                            </small>
                                        </td>
                                        <td>{{ $aca->course_name }}</td>
                                        <td>{{ $aca->start_date ? $aca->start_date->format('M Y') : 'N/A' }} to {{ $aca->end_date ? $aca->end_date->format('M Y') : 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $aca->result_type == 'Others' ? $aca->other_result_type : $aca->result_type }}: {{ $aca->result_percentage }}{{ $aca->result_out_of ? ' / ' . $aca->result_out_of : '' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">No academic history provided.</p>
                        @endif
                    </div>

                    <!-- English Test -->
                    <div class="info-section">
                        <div class="info-section-title"><i class="fas fa-language text-warning"></i> English Language Proficiency</div>
                        @if($englishTests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-custom mb-0 border">
                                <thead>
                                    <tr>
                                        <th>Test Type</th>
                                        <th>Test Date</th>
                                        <th>Overall Score</th>
                                        <th>Scores (L, R, W, S)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($englishTests as $test)
                                    <tr>
                                        <td>{{ $test->test_type }}</td>
                                        <td>{{ $test->test_date }}</td>
                                        <td><span class="badge bg-primary fs--1">{{ $test->overall_score }}</span></td>
                                        <td>L: {{ $test->listening_score }}, R: {{ $test->reading_score }}, W: {{ $test->writing_score }}, S: {{ $test->speaking_score }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted mb-0">No English tests recorded.</p>
                        @endif
                    </div>

                    <!-- Referees -->
                    <div class="info-section bg-light">
                        <div class="info-section-title"><i class="fas fa-users text-secondary"></i> References</div>
                        @if($referees->count() > 0)
                        <div class="row g-3">
                            @foreach($referees as $ref)
                            <div class="col-md-6">
                                <div class="card shadow-none border h-100">
                                    <div class="card-body p-3">
                                        <h6 class="mb-1">{{ $ref->name }} <small class="text-muted fw-normal">({{ $ref->type }})</small></h6>
                                        <p class="mb-1 small"><i class="fas fa-briefcase text-muted me-1"></i> {{ $ref->designation }}, {{ $ref->company_name }}</p>
                                        <p class="mb-1 small"><i class="fas fa-envelope text-muted me-1"></i> {{ $ref->email }}</p>
                                        <p class="mb-0 small"><i class="fas fa-phone text-muted me-1"></i> {{ $ref->phone }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted mb-0">No referees provided.</p>
                        @endif
                    </div>

                    <!-- Student Uploaded Documents -->
                    <div class="info-section">
                        <div class="info-section-title"><i class="fas fa-file-upload text-success"></i> Student Uploaded Documents</div>
                        @if(isset($documents) && $documents->count() > 0)
                        <div class="row g-2">
                            @foreach($documents as $doc)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-white rounded border shadow-sm h-100">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-file-pdf text-danger fs-4"></i>
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $doc->document_type }}</div>
                                            @if($doc->title)
                                                <div class="text-muted small" style="font-size: 11px;">{{ $doc->title }}</div>
                                            @endif
                                            <div class="text-muted" style="font-size: 10px;">Uploaded: {{ $doc->created_at->format('d M, Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="d-inline-flex align-items-center gap-1 text-nowrap">
                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-xs btn-outline-info" data-bs-toggle="tooltip" title="View Document">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ Storage::url($doc->file_path) }}" download class="btn btn-xs btn-outline-primary" data-bs-toggle="tooltip" title="Download Document">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-muted mb-0">No documents uploaded by the student yet.</p>
                        @endif
                    </div>

                </div>

                <!-- ==================== TAB 2: COURSE ==================== -->
                <div class="tab-pane fade" id="tab-course" role="tabpanel" aria-labelledby="tab-course-btn">
                    @php
                        $canAssignCourse = ($student->preAssessment && $student->preAssessment->assessment_status === 'approved' && $student->enrolment_status !== 'pending');
                    @endphp

                    <div class="p-4">
                        @if(isset($application) && $application->course)
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="border-left: 5px solid #2c3e7a !important;">
                            <div class="card-body p-4">
                                <!-- Top Header Section -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom pb-3 mb-4">
                                    <div class="d-flex align-items-center mb-3 mb-md-0">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%) !important; box-shadow: 0 4px 10px rgba(44, 62, 122, 0.3);">
                                            <i class="fas fa-graduation-cap fa-lg"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.75rem;">Enrolled Program</span>
                                            <h4 class="mb-0 fw-bold text-dark mt-1" style="font-size: 1.35rem; line-height: 1.2;">{{ $application->course->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge px-3 py-2 rounded-pill font-13 fw-bold" style="background-color: rgba(44, 62, 122, 0.1); color: #2c3e7a; border: 1px solid rgba(44, 62, 122, 0.2); font-size: 0.9rem;">
                                            <i class="fas fa-barcode me-1"></i> {{ $application->course->course_code }}
                                        </span>
                                        @if($canAssignCourse)
                                            <a href="{{ route('admin.students.enrolment', $student->id) }}" class="btn btn-sm btn-primary py-2 px-3 rounded-pill shadow-sm">
                                                <i class="fas fa-edit me-1"></i> Edit Enrolment & Fees
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-sm btn-secondary py-2 px-3 rounded-pill shadow-sm" disabled title="Approve Pre-Enrolment first">
                                                <i class="fas fa-lock me-1"></i> Edit Enrolment (Pending Approval)
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Course Attributes Grid -->
                                <div class="row g-4 mb-4">
                                    <div class="col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center text-primary me-3" style="width: 42px; height: 42px; background-color: rgba(44, 62, 122, 0.1);">
                                                <i class="fas fa-university fa-lg"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Partner Institute</small>
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $application->course->partner_institute }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center text-success me-3" style="width: 42px; height: 42px; background-color: rgba(40, 167, 69, 0.1);">
                                                <i class="fas fa-book-reader fa-lg"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Study Method</small>
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $application->course->study_method }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center text-warning me-3" style="width: 42px; height: 42px; background-color: rgba(255, 193, 7, 0.1);">
                                                <i class="fas fa-clock fa-lg"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Duration</small>
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ is_numeric($application->course->duration) ? $application->course->duration . ' Years' : $application->course->duration }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center text-danger me-3" style="width: 42px; height: 42px; background-color: rgba(220, 53, 69, 0.1);">
                                                <i class="fas fa-wallet fa-lg"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Tuition Fee</small>
                                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ number_format($application->total_fee, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Schedule & Summary Row -->
                                <div class="row g-4 pt-3 border-top">
                                    <div class="col-lg-8">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;"><i class="fas fa-calendar-alt text-primary me-2"></i> Payment Installments Schedule</h6>
                                            <button type="button" id="generateInvoiceSelectedBtn" class="btn btn-sm btn-outline-success rounded-pill px-3 d-none" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal" onclick="prepareInvoiceModal()">
                                                <i class="fas fa-file-invoice me-1"></i> Generate Invoice (<span id="selectedItemCount">0</span> selected)
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm align-middle" style="font-size: 0.85rem;">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width:36px;"><input type="checkbox" id="selectAllInstallments" class="form-check-input" title="Select All Installments"></th>
                                                        <th>Installment</th>
                                                        <th>Due Date</th>
                                                        <th>Payment Date</th>
                                                        <th class="text-end">Amount</th>
                                                        <th class="text-end">Paid</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($application->installments as $inst)
                                                        <tr>
                                                            <td><input type="checkbox" class="form-check-input installment-checkbox" value="{{ $inst->id }}" onchange="updateSelectedCount()"></td>
                                                            <td class="fw-semibold text-muted">
                                                                Installment {{ $inst->installment_number }}
                                                                @if($inst->is_invoiced)
                                                                    <span class="badge bg-info ms-1" title="Invoiced on {{ $inst->invoiced_at?->format('d M Y H:i') }}"><i class="fas fa-file-invoice me-1"></i>Invoiced</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $inst->due_date ? $inst->due_date->format('d M, Y') : '-' }}</td>
                                                            <td>
                                                                @if($inst->paid_at)
                                                                    <span class="text-success fw-semibold"><i class="fas fa-calendar-check me-1"></i>{{ $inst->paid_at->format('d M, Y') }}</span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-end fw-bold">{{ number_format($inst->amount, 2) }} {{ $application->course->currency ?? 'GBP' }}</td>
                                                            <td class="text-end text-success">{{ number_format($inst->paid_amount, 2) }} {{ $application->course->currency ?? 'GBP' }}</td>
                                                            <td class="text-center">
                                                                @if($inst->status === 'paid')
                                                                    <span class="badge bg-success">Paid</span>
                                                                @elseif($inst->status === 'partially_paid')
                                                                    <span class="badge bg-info text-dark">Partially Paid</span>
                                                                @elseif($inst->status === 'pending_approval')
                                                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending Approval</span>
                                                                @elseif($inst->status === 'waived')
                                                                    <span class="badge bg-secondary"><i class="fas fa-slash me-1"></i> Waived / Adjusted</span>
                                                                @else
                                                                    @if($inst->due_date && $inst->due_date->isPast())
                                                                        <span class="badge bg-danger">Overdue</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Pending</span>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="text-center text-nowrap">
                                                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                                    @if($inst->status === 'pending_approval')
                                                                        <form action="{{ route('admin.installments.approve_payment', $inst->id) }}" method="POST" class="d-inline m-0 p-0">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-xs btn-success" data-bs-toggle="tooltip" title="Approve Payment">
                                                                                <i class="fas fa-check"></i>
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('admin.installments.reject_payment', $inst->id) }}" method="POST" class="d-inline m-0 p-0">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-xs btn-danger delete-btn-confirm" data-text="You want to reject this payment request!" data-bs-toggle="tooltip" title="Reject Payment">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    @elseif(!in_array($inst->status, ['paid', 'waived']))
                                                                        <button type="button" 
                                                                                class="btn btn-xs btn-outline-success record-payment-btn" 
                                                                                data-id="{{ $inst->id }}" 
                                                                                data-inst="{{ $inst->installment_number }}" 
                                                                                data-due="{{ $inst->due_date ? $inst->due_date->format('d M, Y') : '-' }}" 
                                                                                data-amount="{{ $inst->amount }}" 
                                                                                data-paid="{{ $inst->paid_amount }}" 
                                                                                data-currency="{{ $application->course->currency ?? 'GBP' }}"
                                                                                data-bs-toggle="tooltip" 
                                                                                title="Record Payment">
                                                                            <i class="fas fa-coins"></i>
                                                                        </button>
                                                                    @endif
                                                                    <button type="button" 
                                                                            class="btn btn-xs btn-outline-info payment-details-btn" 
                                                                            data-item-type="installment"
                                                                            data-item-title="Installment {{ $inst->installment_number }}"
                                                                            data-payer-name="{{ trim($student->first_name . ' ' . $student->surname) }}"
                                                                            data-payer-id="{{ $student->student_id }}"
                                                                            data-receiver-name="{{ auth()->user()->name ?? 'System Admin' }}"
                                                                            data-amount="{{ number_format($inst->amount, 2) }} {{ $application->course->currency ?? 'GBP' }}"
                                                                            data-paid="{{ number_format($inst->paid_amount, 2) }} {{ $application->course->currency ?? 'GBP' }}"
                                                                            data-due-date="{{ $inst->due_date ? $inst->due_date->format('d M, Y') : 'N/A' }}"
                                                                            data-paid-date="{{ $inst->paid_at ? $inst->paid_at->format('d M, Y h:i A') : 'N/A' }}"
                                                                            data-payment-method="{{ $inst->payment_method ?? 'N/A' }}"
                                                                            data-transaction-id="{{ $inst->transaction_id ?? 'N/A' }}"
                                                                            data-attachment-url="{{ $inst->attachment ? Storage::url($inst->attachment) : '' }}"
                                                                            data-status="{{ $inst->status === 'pending_approval' ? 'Pending Approval' : ucfirst(str_replace('_', ' ', $inst->status)) }}"
                                                                            data-bs-toggle="tooltip" 
                                                                            title="View Payment Details">
                                                                        <i class="fas fa-info-circle"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Fees Summary -->
                                    <div class="col-lg-4">
                                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem; letter-spacing: 0.5px;"><i class="fas fa-receipt text-primary me-2"></i> Fees Summary</h6>
                                        <div class="p-3 border rounded bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                                <span class="text-dark fw-bold">Grand Total Fee</span>
                                                <span class="text-primary fw-bold fs-5">{{ number_format($application->total_fee, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 font-13">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="checkbox" class="form-check-input fee-summary-checkbox" value="base_fee" onchange="updateSelectedCount()" title="Include Base Course Fee in invoice">
                                                    <span class="text-muted">Base Course Fee</span>
                                                </div>
                                                <span class="fw-semibold text-dark">{{ number_format($application->course->fee, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                            @if(($application->scholarship_amount ?? 0) > 0)
                                            <div class="d-flex justify-content-between align-items-center mb-1 font-13">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="checkbox" class="form-check-input fee-summary-checkbox" value="scholarship" onchange="updateSelectedCount()" title="Include Scholarship in invoice">
                                                    <span class="text-success"><i class="fas fa-gift me-1"></i> Scholarship</span>
                                                </div>
                                                <span class="fw-bold text-success">-{{ number_format($application->scholarship_amount, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-1 font-13">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="checkbox" class="form-check-input fee-summary-checkbox" value="net_course_fee" onchange="updateSelectedCount()" title="Include Net Course Fee in invoice">
                                                    <span class="text-muted">Course Fee</span>
                                                </div>
                                                <span class="fw-semibold text-primary">{{ number_format($application->net_course_fee ?? ($application->course->fee - $application->scholarship_amount), 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                            @endif
                                            <div class="d-flex justify-content-between mb-2 font-13">
                                                <span class="text-muted">Additional Costs Total</span>
                                                <span class="fw-semibold text-dark">{{ number_format($application->additionalCosts->sum('amount'), 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                            @php
                                                $totalWaivedInstallments = $application->installments->where('status', 'waived')->sum(function($inst) {
                                                    return max(0, $inst->amount - $inst->paid_amount);
                                                });
                                                $totalWaivedCosts = $application->additionalCosts->where('status', 'waived')->sum('amount');
                                                $totalWaived = $totalWaivedInstallments + $totalWaivedCosts;
                                                $balanceDue = max(0, $application->total_fee - $application->paid_amount - $totalWaived);
                                            @endphp
                                            <hr class="my-2">
                                            <div class="d-flex justify-content-between mb-1 font-13">
                                                <span class="text-muted">Total Paid</span>
                                                <span class="fw-semibold text-success">{{ number_format($application->paid_amount, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                            @if($totalWaived > 0 || $student->enrolment_status === 'terminated')
                                                <div class="d-flex justify-content-between mb-1 font-13">
                                                    <span class="text-muted"><i class="fas fa-slash text-secondary me-1"></i> Waived / Adjusted</span>
                                                    <span class="fw-semibold text-secondary">{{ number_format($totalWaived, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                                </div>
                                            @endif
                                            <div class="d-flex justify-content-between font-13">
                                                <span class="text-muted">Balance Due</span>
                                                <span class="fw-semibold {{ $balanceDue > 0 ? 'text-danger' : 'text-muted' }}">{{ number_format($balanceDue, 2) }} {{ $application->course->currency ?? 'GBP' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Costs Row (Outside Installments) -->
                                <div class="row g-4 pt-3 border-top mt-2">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-muted text-uppercase mb-0" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-tags text-primary me-2"></i> Additional Costs (One-time Full Payments)
                                            </h6>
                                            @if($canAssignCourse)
                                                <a href="{{ route('admin.students.enrolment', $student->id) }}" class="btn btn-xs btn-outline-primary">
                                                    <i class="fas fa-plus me-1"></i> Add / Edit Additional Costs
                                                </a>
                                            @endif
                                        </div>

                                        @if($application->additionalCosts->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 0.85rem;">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width:36px;"><input type="checkbox" id="selectAllCosts" class="form-check-input" title="Select All Additional Costs"></th>
                                                            <th>Cost Item / Description</th>
                                                            <th>Payment Date</th>
                                                            <th class="text-end">Amount</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($application->additionalCosts as $cost)
                                                            <tr>
                                                                <td><input type="checkbox" class="form-check-input cost-checkbox" value="{{ $cost->id }}" onchange="updateSelectedCount()"></td>
                                                                <td class="fw-semibold text-dark">
                                                                    <i class="fas fa-tag text-secondary me-2"></i> {{ $cost->cost_name }}
                                                                    @if($cost->is_invoiced)
                                                                        <span class="badge bg-info ms-1" title="Invoiced on {{ $cost->invoiced_at?->format('d M Y H:i') }}"><i class="fas fa-file-invoice me-1"></i>Invoiced</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($cost->paid_at)
                                                                        <span class="text-success fw-semibold"><i class="fas fa-calendar-check me-1"></i>{{ $cost->paid_at->format('d M, Y') }}</span>
                                                                    @else
                                                                        <span class="text-muted">-</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-end fw-bold text-primary">{{ number_format($cost->amount, 2) }} {{ $application->course->currency ?? 'GBP' }}</td>
                                                                <td class="text-center">
                                                                    @if($cost->status === 'paid')
                                                                        <span class="badge bg-success">Paid</span>
                                                                        @if($cost->paid_at)
                                                                            <small class="d-block text-muted" style="font-size: 10px;">{{ $cost->paid_at->format('d M, Y') }}</small>
                                                                        @endif
                                                                    @elseif($cost->status === 'pending_approval')
                                                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending Approval</span>
                                                                    @elseif($cost->status === 'waived')
                                                                        <span class="badge bg-secondary"><i class="fas fa-slash me-1"></i> Waived / Adjusted</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Pending</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center text-nowrap">
                                                                    <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                                                        @if($cost->status === 'pending_approval')
                                                                            <form action="{{ route('admin.additional_costs.approve_payment', $cost->id) }}" method="POST" class="d-inline m-0 p-0">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-xs btn-success" data-bs-toggle="tooltip" title="Approve Payment">
                                                                                    <i class="fas fa-check"></i>
                                                                                </button>
                                                                            </form>
                                                                            <form action="{{ route('admin.additional_costs.reject_payment', $cost->id) }}" method="POST" class="d-inline m-0 p-0">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-xs btn-danger delete-btn-confirm" data-text="You want to reject this payment request!" data-bs-toggle="tooltip" title="Reject Payment">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            </form>
                                                                        @elseif(!in_array($cost->status, ['paid', 'waived']))
                                                                            <button type="button" 
                                                                                    class="btn btn-xs btn-outline-success record-cost-payment-btn" 
                                                                                    data-id="{{ $cost->id }}" 
                                                                                    data-name="{{ $cost->cost_name }}" 
                                                                                    data-amount="{{ $cost->amount }}" 
                                                                                    data-currency="{{ $application->course->currency ?? 'GBP' }}"
                                                                                    data-bs-toggle="tooltip" 
                                                                                    title="Record Full Payment">
                                                                                <i class="fas fa-coins"></i>
                                                                            </button>
                                                                        @endif
                                                                        <button type="button" 
                                                                                class="btn btn-xs btn-outline-info payment-details-btn" 
                                                                                data-item-type="additional_cost"
                                                                                data-item-title="{{ $cost->cost_name }}"
                                                                                data-payer-name="{{ trim($student->first_name . ' ' . $student->surname) }}"
                                                                                data-payer-id="{{ $student->student_id }}"
                                                                                data-receiver-name="{{ auth()->user()->name ?? 'System Admin' }}"
                                                                                data-amount="{{ number_format($cost->amount, 2) }} {{ $application->course->currency ?? 'GBP' }}"
                                                                                data-paid="{{ number_format($cost->status === 'paid' ? $cost->amount : 0, 2) }} {{ $application->course->currency ?? 'GBP' }}"
                                                                                data-due-date="{{ $cost->paid_at ? $cost->paid_at->format('d M, Y') : 'N/A' }}"
                                                                                data-paid-date="{{ $cost->paid_at ? $cost->paid_at->format('d M, Y h:i A') : 'N/A' }}"
                                                                                data-payment-method="{{ $cost->payment_method ?? 'N/A' }}"
                                                                                data-transaction-id="{{ $cost->transaction_id ?? 'N/A' }}"
                                                                                data-attachment-url="{{ $cost->attachment ? Storage::url($cost->attachment) : '' }}"
                                                                                data-status="{{ $cost->status === 'pending_approval' ? 'Pending Approval' : ucfirst($cost->status) }}"
                                                                                data-bs-toggle="tooltip" 
                                                                                title="View Payment Details">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-light">
                                                        <tr>
                                                            <th class="text-end" colspan="2">Total Additional Costs:</th>
                                                            <th class="text-end text-primary fw-bold">{{ number_format($application->additionalCosts->sum('amount'), 2) }} {{ $application->course->currency ?? 'GBP' }}</th>
                                                            <th colspan="2"></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-light border py-2 px-3 small text-muted mb-0">
                                                <i class="fas fa-info-circle me-1"></i> No additional costs assigned for this enrolment. Click <strong><a href="{{ route('admin.students.enrolment', $student->id) }}">Manage Enrolment & Fees</a></strong> to add items.
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        @else
                            @if($canAssignCourse)
                                <div class="alert alert-info py-4 px-4 shadow-sm border-0 rounded-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="fw-bold text-primary mb-1"><i class="fas fa-graduation-cap me-2"></i> No Course Assigned</h5>
                                        <p class="mb-0 text-muted">No course or fee schedule has been assigned to this student yet.</p>
                                    </div>
                                    <a href="{{ route('admin.students.enrolment', $student->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                                        <i class="fas fa-plus-circle me-1"></i> Assign Course & Fee
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-warning py-4 px-4 shadow-sm border-0 rounded-3 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="fw-bold text-warning mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Pre-Enrolment Pending</h5>
                                        <p class="mb-0 text-muted">Pre-Enrolment / Pre-Assessment is currently <strong>Pending</strong>. Course & fees can only be assigned after approving the Pre-Enrolment.</p>
                                    </div>
                                    @if($student->enrolment_status === 'pending')
                                        <button type="button" class="btn btn-success rounded-pill px-4 shadow-sm btn-approve-enrol fw-bold" data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->surname }}">
                                            <i class="fas fa-check-circle me-1"></i> Approve Pre-Enrolment
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- ==================== TAB 3: LETTERS ==================== -->
                <div class="tab-pane fade" id="tab-letters" role="tabpanel" aria-labelledby="tab-letters-btn">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-envelope-open-text text-primary me-2"></i> Generated Letters History</h5>
                                <p class="text-muted small mb-0">View, preview, download, or send generated letters to this student.</p>
                            </div>
                            <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#generateLetterModal">
                                <i class="fas fa-plus-circle me-1"></i> Add More
                            </button>
                        </div>

                        @if(isset($letterHistory) && $letterHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle border rounded-3 overflow-hidden">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Letter Title</th>
                                        <th>Type</th>
                                        <th>Generated By</th>
                                        <th>Date & Time</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($letterHistory as $idx => $item)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td><strong>{{ $item->letter_title }}</strong></td>
                                        <td><span class="badge bg-secondary text-uppercase">{{ $item->file_type }}</span></td>
                                        <td>{{ $item->generator->name ?? 'System Admin' }}</td>
                                        <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                        <td class="text-center">
                                            @if($item->sent_to_student)
                                                <span class="badge bg-success rounded-pill"><i class="fas fa-check me-1"></i> Sent</span>
                                                <div class="text-muted" style="font-size:10px;">{{ $item->sent_at?->format('d M, Y') }}</div>
                                            @else
                                                <span class="badge bg-light text-secondary border">Not Sent</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                                <a href="{{ route('admin.students.letters.preview', $item->id) }}" target="_blank" class="btn btn-xs btn-outline-info" data-bs-toggle="tooltip" title="Preview Letter">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.students.letters.download', $item->id) }}" class="btn btn-xs btn-outline-success" data-bs-toggle="tooltip" title="Download Letter">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @if(!$item->sent_to_student)
                                                <form action="{{ route('admin.students.letters.send', $item->id) }}" method="POST" class="d-inline m-0 p-0">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-xs btn-success" data-bs-toggle="tooltip" title="Send to Student">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                <form action="{{ route('admin.students.letters.delete', $item->id) }}" method="POST" class="d-inline m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-outline-danger delete-btn-confirm" data-text="You want to delete this generated letter history!" data-bs-toggle="tooltip" title="Delete Letter">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="card border-dashed p-5 text-center bg-light">
                            <i class="fas fa-envelope-open text-muted fa-3x mb-3"></i>
                            <h5 class="fw-bold text-dark">No Letters Generated Yet</h5>
                            <p class="text-muted mb-3">There are no letter documents generated for this student yet.</p>
                            <div>
                                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#generateLetterModal">
                                    <i class="fas fa-plus-circle me-1"></i> Add More
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- ==================== TAB 4: INVOICES ==================== -->
                <div class="tab-pane fade" id="tab-invoices" role="tabpanel" aria-labelledby="tab-invoices-btn">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-file-invoice-dollar text-success me-2"></i> Generated Invoices History</h5>
                                <p class="text-muted small mb-0">View, preview, download, or send generated invoice receipts to this student.</p>
                            </div>
                            <button type="button" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal">
                                <i class="fas fa-plus-circle me-1"></i> Add More
                            </button>
                        </div>

                        @if(isset($invoiceHistory) && $invoiceHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle border rounded-3 overflow-hidden">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Title</th>
                                        <th>Type</th>
                                        <th>Generated By</th>
                                        <th>Date & Time</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoiceHistory as $idx => $item)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td><strong>{{ $item->invoice_title }}</strong></td>
                                        <td><span class="badge bg-secondary text-uppercase">{{ $item->file_type }}</span></td>
                                        <td>{{ $item->generator->name ?? 'System Admin' }}</td>
                                        <td>{{ $item->created_at->format('d M, Y h:i A') }}</td>
                                        <td class="text-center">
                                            @if($item->sent_to_student)
                                                <span class="badge bg-success rounded-pill"><i class="fas fa-check me-1"></i> Sent</span>
                                                <div class="text-muted" style="font-size:10px;">{{ $item->sent_at?->format('d M, Y') }}</div>
                                            @else
                                                <span class="badge bg-light text-secondary border">Not Sent</span>
                                            @endif
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div class="d-inline-flex align-items-center justify-content-end gap-1">
                                                <a href="{{ route('admin.students.invoices.preview', $item->id) }}" target="_blank" class="btn btn-xs btn-outline-info" data-bs-toggle="tooltip" title="Preview Invoice">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.students.invoices.download', $item->id) }}" class="btn btn-xs btn-outline-success" data-bs-toggle="tooltip" title="Download Invoice">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @if(!$item->sent_to_student)
                                                <form action="{{ route('admin.students.invoices.send', $item->id) }}" method="POST" class="d-inline m-0 p-0">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-xs btn-success" data-bs-toggle="tooltip" title="Send to Student">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                <form action="{{ route('admin.students.invoices.delete', $item->id) }}" method="POST" class="d-inline m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-outline-danger delete-btn-confirm" data-text="You want to delete this generated invoice history!" data-bs-toggle="tooltip" title="Delete Invoice">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="card border-dashed p-5 text-center bg-light">
                            <i class="fas fa-file-invoice text-muted fa-3x mb-3"></i>
                            <h5 class="fw-bold text-dark">No Invoices Generated Yet</h5>
                            <p class="text-muted mb-3">There are no invoice documents generated for this student yet.</p>
                            <div>
                                <button type="button" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal">
                                    <i class="fas fa-plus-circle me-1"></i> Add More
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- ==================== Generate Letter Modal ==================== -->
<div class="modal fade" id="generateLetterModal" tabindex="-1" aria-labelledby="generateLetterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form action="{{ route('admin.students.letters.generate', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="letter_action" id="letter_action_input" value="download">
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-primary text-white py-3">
            <h5 class="modal-title fw-bold text-white mb-0" id="generateLetterModalLabel">
                <i class="fas fa-envelope-open-text me-2"></i> Generate Letter for {{ $student->first_name }} {{ $student->surname }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4">
             <!-- Mode Switch -->
             <div class="card bg-light border-0 mb-4 p-3">
                 <label class="form-label fw-bold me-3">Choose Generation Method:</label>
                 <div class="d-flex gap-4">
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="generation_type" id="gen_type_template" value="template" checked onclick="toggleGenMode('template')">
                         <label class="form-check-label fw-semibold" for="gen_type_template">
                            <i class="fas fa-list-alt text-primary me-1"></i> Select Built-in Template
                         </label>
                     </div>
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="generation_type" id="gen_type_file" value="file_upload" onclick="toggleGenMode('file')">
                         <label class="form-check-label fw-semibold" for="gen_type_file">
                            <i class="fas fa-cloud-upload-alt text-success me-1"></i> Upload File (DOCX / PDF / Image)
                         </label>
                     </div>
                 </div>
             </div>

             <!-- Template Block -->
             <div id="block_template">
                 <div class="mb-3">
                     <label class="form-label fw-bold">Select Template <span class="text-danger">*</span></label>
                     <select name="letter_template_id" id="modal_template_id" class="form-select form-select-lg" onchange="fetchTemplatePreview(this.value)">
                         <option value="">-- Choose a Letter Template --</option>
                         @if(isset($letterTemplates))
                             @foreach($letterTemplates as $tpl)
                                 <option value="{{ $tpl->id }}">{{ $tpl->title }} ({{ strtoupper($tpl->type) }})</option>
                             @endforeach
                         @endif
                     </select>
                 </div>

                 <!-- Live Preview Box -->
                 <div id="preview_container" class="d-none">
                     <div class="d-flex justify-content-between align-items-center mb-2">
                         <label class="form-label fw-bold text-success mb-0"><i class="fas fa-eye me-1"></i> Live Preview (Editable before generating):</label>
                         <span class="badge bg-success bg-opacity-10 text-success small">Auto-filled with student data</span>
                     </div>
                     <div class="border rounded shadow-sm bg-white">
                         <textarea name="custom_content" id="modal_custom_content" class="form-control"></textarea>
                     </div>
                 </div>
             </div>

             <!-- File Upload Block -->
             <div id="block_file" class="d-none">
                 <div class="mb-3">
                     <label class="form-label fw-bold">Upload Custom Letter File (.docx, .pdf, .jpg, .png)</label>
                     <input type="file" name="uploaded_file" class="form-control form-control-lg" accept=".docx,.pdf,.jpg,.jpeg,.png">
                     <div class="form-text mt-2">
                        <i class="fas fa-info-circle text-info"></i> For <strong>Microsoft Word (.docx)</strong> templates, include placeholders such as <code>${student_name}</code>, <code>${passport_number}</code>, <code>${today_date}</code> inside your doc file to auto-populate student data.
                     </div>
                 </div>
             </div>

          </div>

          <div class="modal-footer bg-light py-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Close
            </button>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary rounded-pill px-4 fw-semibold" onclick="document.getElementById('letter_action_input').value='download'">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" onclick="document.getElementById('letter_action_input').value='send'">
                    <i class="fas fa-paper-plane me-1"></i> Send to Student
                </button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- Floating Sticky Bar for Invoice Generation -->
<div id="floatingInvoiceBar" class="position-fixed bottom-0 start-50 translate-middle-x mb-4 shadow-lg p-3 bg-dark text-white rounded-pill d-none" style="z-index: 1050; border: 2px solid #28a745; transition: all 0.3s ease;">
    <div class="d-flex align-items-center gap-3 px-2">
        <span><i class="fas fa-check-circle text-success fs-5"></i> <strong><span id="floatingSelectedItemCount">0</span> item(s) selected</strong> for invoice</span>
        <button type="button" class="btn btn-success rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal" onclick="prepareInvoiceModal()">
            <i class="fas fa-magic me-1"></i> Make Invoice Now
        </button>
        <button type="button" class="btn btn-sm btn-outline-light rounded-circle" title="Clear selection" onclick="clearAllInvoiceSelections()">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>

<!-- ==================== Generate Invoice Modal ==================== -->
<div class="modal fade" id="generateInvoiceModal" tabindex="-1" aria-labelledby="generateInvoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form action="{{ route('admin.students.invoices.generate', $student->id) }}" method="POST" enctype="multipart/form-data" id="generateInvoiceForm">
        @csrf
        <input type="hidden" name="invoice_action" id="invoice_action_input" value="download">
        <input type="hidden" name="generation_type" id="generation_type_input" value="template">
        <div id="hidden_installment_ids_container"></div>
        <div id="hidden_cost_ids_container"></div>
        <div class="modal-content border-0 shadow-lg">
          <div class="modal-header bg-success text-white py-3">
            <h5 class="modal-title fw-bold text-white mb-0" id="generateInvoiceModalLabel">
                <i class="fas fa-file-invoice-dollar me-2"></i> Make Invoice for {{ $student->first_name }} {{ $student->surname }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4">
             <!-- Selected Items Summary Banner -->
             <div id="selectedItemsIndicator" class="d-none alert alert-success border-0 py-3 px-3 mb-3 rounded-3 shadow-sm">
                 <div class="d-flex align-items-center">
                     <i class="fas fa-check-circle me-2 fs-5 text-success"></i>
                     <div>
                         <strong class="text-success"><span id="selectedItemsCount">0</span> Fee Item(s) Selected:</strong>
                         <span id="selectedItemsDesc" class="ms-1 text-dark fw-semibold"></span>
                     </div>
                 </div>
             </div>

             <!-- Template Choice (Primary Flow) -->
             <div class="mb-4">
                 <label class="form-label fw-bold fs-6 text-dark mb-1"><i class="fas fa-file-alt text-primary me-1"></i> Step 1: Choose Invoice Template <span class="text-danger">*</span></label>
                 <select name="invoice_template_id" id="modal_invoice_template_id" class="form-select form-select-lg border-primary shadow-sm" onchange="fetchInvoiceTemplatePreview(this.value)" required>
                      <option value="">-- Click to Select Invoice Template --</option>
                      @if(isset($invoiceTemplates))
                          @foreach($invoiceTemplates as $tpl)
                              <option value="{{ $tpl->id }}">{{ $tpl->title }} ({{ strtoupper($tpl->type) }})</option>
                          @endforeach
                      @endif
                 </select>
                 <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i> Selecting a template will automatically build the invoice with student details and selected items.</small>
             </div>

             <!-- Live Preview Box -->
             <div id="inv_preview_container" class="d-none mb-3">
                 <div class="d-flex justify-content-between align-items-center mb-2">
                      <label class="form-label fw-bold text-success mb-0"><i class="fas fa-eye me-1"></i> Step 2: Live Invoice Preview (Editable if needed):</label>
                      <span class="badge bg-success bg-opacity-10 text-success px-2 py-1"><i class="fas fa-magic me-1"></i> Auto-populated</span>
                 </div>
                 <div class="border rounded-3 shadow-sm bg-white p-1">
                      <textarea name="custom_content" id="modal_invoice_custom_content" class="form-control"></textarea>
                 </div>
             </div>

             <!-- Optional File Upload Toggle -->
             <div class="border-top pt-3 mt-3">
                 <a class="text-muted small text-decoration-none" data-bs-toggle="collapse" href="#inv_file_upload_collapse" role="button" aria-expanded="false">
                     <i class="fas fa-paperclip me-1"></i> Need to upload a custom DOCX/PDF file instead? Click here
                 </a>
                 <div class="collapse mt-2" id="inv_file_upload_collapse">
                     <div class="card card-body bg-light border-0">
                         <label class="form-label fw-bold">Upload Custom File (.docx, .pdf, .jpg, .png)</label>
                         <input type="file" name="uploaded_file" class="form-control" accept=".docx,.pdf,.jpg,.jpeg,.png" onchange="document.getElementById('generation_type_input').value = this.value ? 'file_upload' : 'template'">
                     </div>
                 </div>
             </div>

          </div>

          <div class="modal-footer bg-light py-3 d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Cancel
            </button>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-outline-success rounded-pill px-4 fw-semibold" onclick="document.getElementById('invoice_action_input').value='download'">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" onclick="document.getElementById('invoice_action_input').value='send'">
                    <i class="fas fa-paper-plane me-1"></i> Send to Student
                </button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- Record Payment Modal -->
<div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-labelledby="recordPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="recordPaymentModalLabel"><i class="fas fa-coins me-2"></i> Submit Payment Request</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="recordPaymentForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <span class="text-muted d-block text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Installment Details</span>
                        <h5 class="fw-bold text-dark mb-1" id="modal_installment_title">Installment 1</h5>
                        <small class="text-muted">Due date: <span id="modal_due_date">N/A</span></small>
                    </div>
                    <hr class="my-3">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Amount to Pay (<span class="currency-label">GBP</span>) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text currency-label">GBP</span>
                            <input type="number" name="amount_paid" id="amount_paid_input" class="form-control" step="0.01" min="0.01" readonly required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Online Payment">Online Payment</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Transaction Reference / TXN ID (Optional)</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="Enter Reference No. or TXN ID">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Attachment / Proof (Optional)</label>
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <small class="text-muted">Upload receipt, bank slip or payment proof (PDF, JPG, PNG, DOC).</small>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-paper-plane me-1"></i> Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Record Additional Cost Payment Modal -->
<div class="modal fade" id="recordCostPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="POST" id="recordCostPaymentForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white"><i class="fas fa-hand-holding-usd me-2"></i> Submit Additional Cost Payment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-3 text-muted small"><i class="fas fa-info-circle me-1"></i> Additional cost payments are paid in full (one-time payment, no installments).</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cost Item / Description</label>
                        <input type="text" id="modal_cost_name" class="form-control bg-light" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Full Payment Amount</label>
                        <input type="text" id="modal_cost_amount" class="form-control bg-light fw-bold text-success" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Online Payment">Online Payment</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Transaction Reference / TXN ID (Optional)</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="Enter Reference No. or TXN ID">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Payment Attachment / Proof (Optional)</label>
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <small class="text-muted">Upload receipt, bank slip or payment proof (PDF, JPG, PNG, DOC).</small>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-paper-plane me-1"></i> Submit Payment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Payment Details Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white py-3">
                <h5 class="modal-title fw-bold text-white mb-0" id="paymentDetailsModalLabel">
                    <i class="fas fa-info-circle me-2"></i> Payment Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4 pb-3 border-bottom">
                    <span class="badge bg-secondary px-3 py-1 rounded-pill mb-2 font-12" id="det_item_type">Installment Schedule</span>
                    <h4 class="fw-bold text-dark mb-1" id="det_item_title">Installment 1</h4>
                    <span class="badge bg-success font-13" id="det_status_badge">Paid</span>
                </div>

                <div class="row g-3 font-13">
                    <!-- Payer Information -->
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border h-100">
                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 10px;">Paid By (Payer)</small>
                            <div class="fw-bold text-dark" id="det_payer_name">Student Name</div>
                            <small class="text-muted" id="det_payer_id">STU-12345</small>
                        </div>
                    </div>

                    <!-- Receiver Information -->
                    <div class="col-6">
                        <div class="p-3 bg-light rounded border h-100">
                            <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 10px;">Received By (Receiver)</small>
                            <div class="fw-bold text-dark" id="det_receiver_name">Admin Name</div>
                            <small class="text-muted">Accounts Dept</small>
                        </div>
                    </div>

                    <!-- Payment Amounts -->
                    <div class="col-6">
                        <small class="text-muted d-block">Scheduled Amount</small>
                        <span class="fw-bold text-dark fs-6" id="det_amount">0.00 GBP</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Total Paid Amount</small>
                        <span class="fw-bold text-success fs-6" id="det_paid">0.00 GBP</span>
                    </div>

                    <!-- Dates & Methods -->
                    <div class="col-6">
                        <small class="text-muted d-block">Due Date</small>
                        <span class="fw-semibold text-dark" id="det_due_date">N/A</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Payment Date</small>
                        <span class="fw-semibold text-dark" id="det_paid_date">N/A</span>
                    </div>

                    <div class="col-6">
                        <small class="text-muted d-block">Payment Method</small>
                        <span class="fw-semibold text-dark" id="det_payment_method">Cash</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Transaction Reference / TXN ID</small>
                        <span class="fw-semibold text-primary" id="det_transaction_id">N/A</span>
                    </div>

                    <!-- Attachment / Receipt Document Link -->
                    <div class="col-12 border-top pt-3">
                        <small class="text-muted d-block mb-1">Payment Proof / Attachment</small>
                        <div id="det_attachment_container">
                            <span class="text-muted small"><i class="fas fa-file-alt me-1"></i> No attachment uploaded</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Terminate Student Modal -->
<div class="modal fade" id="terminateStudentModal" tabindex="-1" aria-labelledby="terminateStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold text-white mb-0" id="terminateStudentModalLabel">
                    <i class="fas fa-user-slash me-2"></i> Terminate / Discontinue Student
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.students.terminate', $student->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-warning border-0 d-flex align-items-center gap-2 font-13 mb-3">
                        <i class="fas fa-exclamation-triangle fa-lg text-warning flex-shrink-0"></i>
                        <div>
                            <strong>Warning:</strong> Mark this student as discontinued/terminated. All remaining unpaid course installments and costs will be <strong>Waived / Adjusted</strong> and the Balance Due will become zero.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Termination / Discontinuation Reason <span class="text-danger">*</span></label>
                        <textarea name="termination_reason" class="form-control" rows="3" placeholder="Enter reason (e.g. Discontinued studies, Returned home, Visa cancelled...)" required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm fw-bold"><i class="fas fa-user-slash me-1"></i> Confirm Termination</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
function copyInviteLink() {
    var copyText = document.getElementById("inviteLinkInput");
    if (copyText) {
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        if (typeof toastr !== 'undefined') {
            toastr.success('Invite link copied to clipboard!');
        } else {
            alert("Copied invite link: " + copyText.value);
        }
    }
}

function toggleGenMode(mode) {
    if (mode === 'template') {
        document.getElementById('block_template').classList.remove('d-none');
        document.getElementById('block_file').classList.add('d-none');
    } else {
        document.getElementById('block_template').classList.add('d-none');
        document.getElementById('block_file').classList.remove('d-none');
    }
}

function fetchTemplatePreview(templateId) {
    if (!templateId) {
        document.getElementById('preview_container').classList.add('d-none');
        return;
    }

    const url = "{{ route('admin.students.letters.preview_modal', $student->id) }}?template_id=" + templateId;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('preview_container').classList.remove('d-none');
                $('#modal_custom_content').summernote('code', data.content);
            }
        })
        .catch(err => console.error('Error fetching preview:', err));
}

function toggleInvGenMode(mode) {
    if (mode === 'template') {
        document.getElementById('inv_block_template').classList.remove('d-none');
        document.getElementById('inv_block_file').classList.add('d-none');
    } else {
        document.getElementById('inv_block_template').classList.add('d-none');
        document.getElementById('inv_block_file').classList.remove('d-none');
    }
}

function updateSelectedCount() {
    const installmentBoxes = document.querySelectorAll('.installment-checkbox:checked');
    const costBoxes        = document.querySelectorAll('.cost-checkbox:checked');
    const summaryBoxes     = document.querySelectorAll('.fee-summary-checkbox:checked');
    const total = installmentBoxes.length + costBoxes.length + summaryBoxes.length;

    if (document.getElementById('selectedItemCount')) {
        document.getElementById('selectedItemCount').textContent = total;
    }
    if (document.getElementById('floatingSelectedItemCount')) {
        document.getElementById('floatingSelectedItemCount').textContent = total;
    }

    const btn = document.getElementById('generateInvoiceSelectedBtn');
    const floatBar = document.getElementById('floatingInvoiceBar');

    if (total > 0) {
        if (btn) btn.classList.remove('d-none');
        if (floatBar) floatBar.classList.remove('d-none');
    } else {
        if (btn) btn.classList.add('d-none');
        if (floatBar) floatBar.classList.add('d-none');
    }
}

function clearAllInvoiceSelections() {
    document.querySelectorAll('.installment-checkbox, .cost-checkbox, .fee-summary-checkbox, #selectAllInstallments, #selectAllCosts').forEach(cb => cb.checked = false);
    updateSelectedCount();
}

function prepareInvoiceModal() {
    const installmentBoxes = document.querySelectorAll('.installment-checkbox:checked');
    const costBoxes        = document.querySelectorAll('.cost-checkbox:checked');
    const summaryBoxes     = document.querySelectorAll('.fee-summary-checkbox:checked');

    document.getElementById('hidden_installment_ids_container').innerHTML = '';
    document.getElementById('hidden_cost_ids_container').innerHTML = '';

    let installmentDescParts = [];
    installmentBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'installment_ids[]';
        input.value = cb.value;
        document.getElementById('hidden_installment_ids_container').appendChild(input);
        const row = cb.closest('tr');
        if (row) {
            const label = row.querySelector('td:nth-child(2)');
            if (label) installmentDescParts.push(label.textContent.trim().replace(/\s+/g, ' ').split('\n')[0]);
        }
    });

    let costDescParts = [];
    costBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'additional_cost_ids[]';
        input.value = cb.value;
        document.getElementById('hidden_cost_ids_container').appendChild(input);
        const row = cb.closest('tr');
        if (row) {
            const label = row.querySelector('td:nth-child(2)');
            if (label) costDescParts.push(label.textContent.trim().replace(/\s+/g, ' ').split('\n')[0]);
        }
    });

    let summaryDescParts = [];
    summaryBoxes.forEach(cb => {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'fee_summary_items[]';
        input.value = cb.value;
        document.getElementById('hidden_cost_ids_container').appendChild(input);
        const titleMap = {
            'base_fee': 'Base Course Fee',
            'scholarship': 'Scholarship',
            'net_course_fee': 'Course Fee'
        };
        if (titleMap[cb.value]) summaryDescParts.push(titleMap[cb.value]);
    });

    const total = installmentBoxes.length + costBoxes.length + summaryBoxes.length;
    const indicator = document.getElementById('selectedItemsIndicator');
    const descEl    = document.getElementById('selectedItemsDesc');
    document.getElementById('selectedItemsCount').textContent = total;
    const allDesc = [...installmentDescParts, ...costDescParts, ...summaryDescParts].join(', ');
    descEl.textContent = allDesc ? '(' + allDesc + ')' : '';

    if (total > 0) {
        indicator.classList.remove('d-none');
    } else {
        indicator.classList.add('d-none');
    }
}

// Select All Installments
const selectAllInstallments = document.getElementById('selectAllInstallments');
if (selectAllInstallments) {
    selectAllInstallments.addEventListener('change', function() {
        document.querySelectorAll('.installment-checkbox').forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });
}

// Select All Costs
const selectAllCosts = document.getElementById('selectAllCosts');
if (selectAllCosts) {
    selectAllCosts.addEventListener('change', function() {
        document.querySelectorAll('.cost-checkbox').forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });
}

function fetchInvoiceTemplatePreview(templateId) {
    if (!templateId) {
        document.getElementById('inv_preview_container').classList.add('d-none');
        return;
    }

    let params = new URLSearchParams();
    params.append('template_id', templateId);

    document.querySelectorAll('.installment-checkbox:checked').forEach(cb => {
        params.append('installment_ids[]', cb.value);
    });

    document.querySelectorAll('.cost-checkbox:checked').forEach(cb => {
        params.append('additional_cost_ids[]', cb.value);
    });

    document.querySelectorAll('.fee-summary-checkbox:checked').forEach(cb => {
        params.append('fee_summary_items[]', cb.value);
    });

    const url = "{{ route('admin.students.invoices.preview_modal', $student->id) }}?" + params.toString();
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('inv_preview_container').classList.remove('d-none');
                $('#modal_invoice_custom_content').summernote('code', data.content);
            }
        })
        .catch(err => console.error('Error fetching invoice preview:', err));
}

function openInvoiceModalForInstallment(installmentId) {
    if (document.getElementById('modal_invoice_installment_id')) {
        document.getElementById('modal_invoice_installment_id').value = installmentId;
    }
    var modal = new bootstrap.Modal(document.getElementById('generateInvoiceModal'));
    modal.show();
    if (document.getElementById('modal_invoice_template_id').value) {
        fetchInvoiceTemplatePreview(document.getElementById('modal_invoice_template_id').value);
    }
}

$(document).ready(function() {
    // Summernote Initialization
    $('#modal_custom_content').summernote({
        height: 380,
        placeholder: 'Template preview will appear here after selecting a template above...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'hr']],
            ['view', ['codeview']],
        ]
    });

    $('#modal_invoice_custom_content').summernote({
        height: 380,
        placeholder: 'Template preview will appear here after selecting a template above...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'hr']],
            ['view', ['codeview']],
        ]
    });

    $('form').on('submit', function() {
        if ($('#modal_custom_content').length && $('#modal_custom_content').data('summernote')) {
            $('#modal_custom_content').val($('#modal_custom_content').summernote('code'));
        }
        if ($('#modal_invoice_custom_content').length && $('#modal_invoice_custom_content').data('summernote')) {
            $('#modal_invoice_custom_content').val($('#modal_invoice_custom_content').summernote('code'));
        }
    });

    // Record Payment Modal logic
    $(document).on('click', '.record-payment-btn', function() {
        const id = $(this).data('id');
        const number = $(this).data('inst');
        const due = $(this).data('due');
        const amount = parseFloat($(this).data('amount'));
        const paid = parseFloat($(this).data('paid'));
        const currency = $(this).data('currency');
        const remaining = amount - paid;

        $('#modal_installment_title').text(`Installment ${number}`);
        $('#modal_due_date').text(due);
        $('#modal_amount_display').text(`${amount.toFixed(2)} ${currency}`);
        $('#modal_paid_display').text(`${paid.toFixed(2)} ${currency}`);
        $('.currency-label').text(currency);
        
        $('#amount_paid_input').val(remaining.toFixed(2));
        $('#recordPaymentForm').attr('action', `/admin/installments/${id}/record-payment`);
        $('#recordPaymentModal').modal('show');
    });

    $(document).on('click', '.record-cost-payment-btn', function() {
        const costId = $(this).data('id');
        const costName = $(this).data('name');
        const amount = parseFloat($(this).data('amount')).toFixed(2);
        const currency = $(this).data('currency');

        $('#modal_cost_name').val(costName);
        $('#modal_cost_amount').val(amount + ' ' + currency);

        const actionUrl = "{{ url('/admin/additional-costs') }}/" + costId + "/record-payment";
        $('#recordCostPaymentForm').attr('action', actionUrl);

        $('#recordCostPaymentModal').modal('show');
    });

    $(document).on('click', '.payment-details-btn', function() {
        const type = $(this).data('item-type');
        const title = $(this).data('item-title');
        const payerName = $(this).data('payer-name');
        const payerId = $(this).data('payer-id');
        const receiverName = $(this).data('receiver-name');
        const amount = $(this).data('amount');
        const paid = $(this).data('paid');
        const dueDate = $(this).data('due-date');
        const paidDate = $(this).data('paid-date') || 'N/A';
        const method = $(this).data('payment-method') || 'N/A';
        const txnId = $(this).data('transaction-id') || 'N/A';
        const attachmentUrl = $(this).data('attachment-url') || '';
        const status = $(this).data('status');

        $('#det_item_type').text(type === 'installment' ? 'Installment Schedule' : 'Additional Cost Item');
        $('#det_item_title').text(title);
        $('#det_payer_name').text(payerName);
        $('#det_payer_id').text('ID: ' + payerId);
        $('#det_receiver_name').text(receiverName);
        $('#det_amount').text(amount);
        $('#det_paid').text(paid);
        $('#det_due_date').text(dueDate);
        $('#det_paid_date').text(paidDate);
        $('#det_payment_method').text(method);
        $('#det_transaction_id').text(txnId);

        if (attachmentUrl) {
            $('#det_attachment_container').html(`
                <div class="d-flex align-items-center gap-2 mt-1">
                    <a href="${attachmentUrl}" target="_blank" class="btn btn-xs btn-outline-info rounded-pill px-3">
                        <i class="fas fa-eye me-1"></i> View Attachment
                    </a>
                    <a href="${attachmentUrl}" download class="btn btn-xs btn-outline-primary rounded-pill px-3">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                </div>
            `);
        } else {
            $('#det_attachment_container').html('<span class="text-muted small"><i class="fas fa-file-alt me-1"></i> No attachment uploaded</span>');
        }

        if (status === 'Paid') {
            $('#det_status_badge').text('Paid').attr('class', 'badge bg-success font-13');
        } else if (status === 'Partially paid') {
            $('#det_status_badge').text('Partially Paid').attr('class', 'badge bg-info text-dark font-13');
        } else if (status === 'Pending Approval') {
            $('#det_status_badge').text('Pending Approval').attr('class', 'badge bg-warning text-dark font-13');
        } else {
            $('#det_status_badge').text('Pending').attr('class', 'badge bg-secondary font-13');
        }

        var modal = new bootstrap.Modal(document.getElementById('paymentDetailsModal'));
        modal.show();
    });

    // Handle Active Tab from URL (e.g. ?tab=letters, ?tab=invoices, ?tab=course, ?tab=profile)
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    const hashParam = window.location.hash.replace('#', '');
    const activeTab = tabParam || hashParam;

    if (activeTab) {
        let tabBtn = document.getElementById('tab-' + activeTab + '-btn');
        if (!tabBtn && (activeTab === 'enrolment' || activeTab === 'course')) {
            tabBtn = document.getElementById('tab-course-btn');
        }
        if (tabBtn) {
            let bsTab = new bootstrap.Tab(tabBtn);
            bsTab.show();
        }
    }

    // Preserve active tab in URL hash/param when user changes tab
    const tabButtons = document.querySelectorAll('#studentProfileTabs button[data-bs-toggle="tab"]');
    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function(e) {
            const targetId = e.target.getAttribute('data-bs-target').replace('#tab-', '');
            const newUrl = new URL(window.location);
            newUrl.searchParams.set('tab', targetId);
            window.history.replaceState(null, '', newUrl);
        });
    });
});
</script>
@endpush

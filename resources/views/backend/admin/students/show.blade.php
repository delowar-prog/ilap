@extends('layouts.backend_master')

@section('title', 'Student Profile')

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
    width: 200px;
    height: 200px;
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
    opacity: 0.8;
}
.profile-edit-btn {
    position: absolute;
    top: 2rem;
    right: 2.5rem;
}
.info-section {
    padding: 2rem;
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
</style>
@endpush

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="profile-card">
            
            <!-- Header Section -->
            <div class="profile-header">
                <a href="{{ route('admin.students.index') }}" class="btn btn-light btn-sm profile-edit-btn shadow-sm">
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
                        <div class="mt-2 text-white-50 small">Profile Completion: <strong class="text-white">{{ $completionPercent }}%</strong></div>
                    </div>
                </div>
            </div>

            @if($student->enrolment_status === 'enrolled')
            <div class="action-bar border-bottom p-3 bg-light d-flex gap-2 align-items-center flex-wrap">
                <a href="{{ route('admin.students.profile.pdf', $student->id) }}" class="btn btn-primary btn-sm rounded-pill shadow-sm px-3">
                    <i class="fas fa-file-pdf me-1"></i> Profile PDF
                </a>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#generateLetterModal">
                    <i class="fas fa-envelope-open-text me-1"></i> Generate Letter
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Generate Invoice
                </button>
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Chatting', text: 'Chatting option is coming soon!', icon: 'info'})">
                    <i class="fas fa-comments me-1"></i> Chatting
                </a>
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Email', text: 'Email communication option is coming soon!', icon: 'info'})">
                    <i class="fas fa-envelope me-1"></i> Email
                </a>
                <a href="#" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="Swal.fire({title: 'Support', text: 'Support ticket/queries option is coming soon!', icon: 'info'})">
                    <i class="fas fa-headset me-1"></i> Support
                </a>
            </div>
            @endif

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
                <div class="info-section-title"><i class="fas fa-user-circle"></i> Personal Information</div>
                <div class="info-grid">
                    <div class="info-item"><label>First Name</label><span>{{ $student->first_name }}</span></div>
                    <div class="info-item"><label>Middle Name</label><span>{{ $student->middle_name ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Last Name (Surname)</label><span>{{ $student->surname }}</span></div>
                    <div class="info-item"><label>Preferred Institute</label><span><span class="badge bg-primary">{{ $student->institute ? $student->institute->name : 'N/A' }}</span></span></div>
                    <div class="info-item"><label>Date of Birth</label><span>{{ $student->dob ? $student->dob->format('d M Y') : 'N/A' }}</span></div>
                    <div class="info-item"><label>Gender</label><span>{{ $student->gender ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Nationality</label><span>{{ $student->nationality ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Country of Birth</label><span>{{ $student->country_of_birth ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Country of Residence</label><span>{{ $student->country ? $student->country->name : 'N/A' }}</span></div>
                    <div class="info-item"><label>Phone</label><span>{{ $student->phone ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Skype ID</label><span>{{ $student->skype_id ?? 'N/A' }}</span></div>
                </div>
            </div>

            <!-- Address Info -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-map-marker-alt"></i> Contact & Address</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Permanent Address</h6>
                        <div class="info-grid" style="grid-template-columns: 1fr;">
                            <div class="info-item"><label>Address</label><span>{{ $student->permanent_address ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>City & Postcode</label><span>{{ $student->permanent_city }} {{ $student->permanent_postcode }}</span></div>
                            <div class="info-item"><label>Country</label><span>{{ $student->permanent_country ?? 'N/A' }}</span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Current Address</h6>
                        <div class="info-grid" style="grid-template-columns: 1fr;">
                            <div class="info-item"><label>Address</label><span>{{ $student->current_address ?? 'N/A' }}</span></div>
                            <div class="info-item"><label>City & Postcode</label><span>{{ $student->current_city }} {{ $student->current_postcode }}</span></div>
                            <div class="info-item"><label>Country</label><span>{{ $student->current_country ?? 'N/A' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passport & Travel Info -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-passport"></i> Passport & Travel History</div>
                <div class="info-grid mb-4">
                    <div class="info-item"><label>Name in Passport</label><span>{{ $student->name_in_passport ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Passport Number</label><span>{{ $student->passport_number ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Issue Date</label><span>{{ $student->passport_issue_date ? $student->passport_issue_date->format('d M Y') : 'N/A' }}</span></div>
                    <div class="info-item"><label>Expiry Date</label><span>{{ $student->passport_expiry_date ? $student->passport_expiry_date->format('d M Y') : 'N/A' }}</span></div>
                    <div class="info-item"><label>Issue Location</label><span>{{ $student->passport_issue_location ?? 'N/A' }}</span></div>
                </div>
                
                @php
                    $travelHistory = $student->travel_history ?? [];
                    $immigrationHistory = $student->immigration_history ?? [];
                    $visaRefusals = $student->visa_refusals ?? [];
                    $takenTbTest = $student->taken_tb_test ?? 'N/A';
                @endphp
                <h6 class="text-muted text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">Travel & Immigration History</h6>
                <div class="row g-3">
                    {{-- 1. Travel History --}}
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Permission to remain in past 10 years:</strong> 
                            <span class="badge {{ ($travelHistory['has_history'] ?? '') === 'yes' ? 'bg-primary' : 'bg-secondary' }}">
                                {{ strtoupper($travelHistory['has_history'] ?? 'No') }}
                            </span>
                            @if(($travelHistory['has_history'] ?? '') === 'yes')
                                <div class="mt-2 ps-3 border-start border-3 border-primary">
                                    <div class="row g-2">
                                        <div class="col-md-6"><strong>Country:</strong> {{ $travelHistory['country'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Visa Type:</strong> {{ $travelHistory['visa_type'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Purpose:</strong> {{ $travelHistory['purpose_of_visit'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Arrival Date:</strong> {{ $travelHistory['arrival_date'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Departure Date:</strong> {{ $travelHistory['departure_date'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Visa Validity:</strong> {{ $travelHistory['visa_start_date'] ?? 'N/A' }} to {{ $travelHistory['visa_expiry_date'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- 2. Immigration History --}}
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

                    {{-- 3. Visa Rejections --}}
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Refused visa/asylum/deported:</strong> 
                            <span class="badge {{ ($visaRefusals['has_refusal'] ?? '') === 'yes' ? 'bg-danger' : 'bg-secondary' }}">
                                {{ strtoupper($visaRefusals['has_refusal'] ?? 'No') }}
                            </span>
                            @if(($visaRefusals['has_refusal'] ?? '') === 'yes')
                                <div class="mt-2 ps-3 border-start border-3 border-danger">
                                    <div class="row g-2">
                                        <div class="col-md-6"><strong>Country:</strong> {{ $visaRefusals['country'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Visa Type:</strong> {{ $visaRefusals['visa_type'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Refusal Type:</strong> {{ $visaRefusals['refusal_type'] ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Date of Refusal:</strong> {{ $visaRefusals['refusal_date'] ?? 'N/A' }}</div>
                                        <div class="col-md-12"><strong>Details/Reason:</strong> {{ $visaRefusals['details'] ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- 4. TB Test Details --}}
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>TB Test Details:</strong> {{ $takenTbTest }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academics -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-graduation-cap"></i> Academic History</div>
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
                <div class="info-section-title"><i class="fas fa-language"></i> English Language Proficiency</div>
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
                <div class="info-section-title"><i class="fas fa-users"></i> References</div>
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
                            <div class="d-flex gap-2">
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                <a href="{{ Storage::url($doc->file_path) }}" download class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fas fa-download me-1"></i> Download
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

            <!-- Generated Letters History Section -->
            <div class="info-section">
                <div class="info-section-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history text-primary me-2"></i> Generated Letters History</span>
                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#generateLetterModal">
                        <i class="fas fa-plus me-1"></i> Generate New Letter
                    </button>
                </div>
                @if(isset($letterHistory) && $letterHistory->count() > 0)
                <div class="table-responsive mt-2">
                    <table class="table table-hover table-striped align-middle border">
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
                                <td class="text-end">
                                    <a href="{{ route('admin.students.letters.preview', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Preview Letter">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </a>
                                    <a href="{{ route('admin.students.letters.download', $item->id) }}" class="btn btn-sm btn-outline-success" title="Download Letter">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    @if(!$item->sent_to_student)
                                    <form action="{{ route('admin.students.letters.send', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" title="Send to Student">
                                            <i class="fas fa-paper-plane me-1"></i> Send
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.students.letters.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn-confirm" data-text="You want to delete this generated letter history!" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0 py-2">No letters generated yet for this student.</p>
                @endif
            </div>

            <!-- Generated Invoices History Section -->
            <div class="info-section mt-4">
                <div class="info-section-title d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-history text-success me-2"></i> Generated Invoices History</span>
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#generateInvoiceModal">
                        <i class="fas fa-plus me-1"></i> Generate New Invoice
                    </button>
                </div>
                @if(isset($invoiceHistory) && $invoiceHistory->count() > 0)
                <div class="table-responsive mt-2">
                    <table class="table table-hover table-striped align-middle border">
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
                                <td class="text-end">
                                    <a href="{{ route('admin.students.invoices.preview', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-info" title="Preview Invoice">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </a>
                                    <a href="{{ route('admin.students.invoices.download', $item->id) }}" class="btn btn-sm btn-outline-success" title="Download Invoice">
                                        <i class="fas fa-download me-1"></i> Download
                                    </a>
                                    @if(!$item->sent_to_student)
                                    <form action="{{ route('admin.students.invoices.send', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" title="Send to Student">
                                            <i class="fas fa-paper-plane me-1"></i> Send
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.students.invoices.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-btn-confirm" data-text="You want to delete this generated invoice history!" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted mb-0 py-2">No invoices generated yet for this student.</p>
                @endif
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
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fw-bold text-white" id="generateLetterModalLabel">
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

          <div class="modal-footer bg-light d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Close
            </button>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary rounded-pill px-4" onclick="document.getElementById('letter_action_input').value='download'">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4" onclick="document.getElementById('letter_action_input').value='send'">
                    <i class="fas fa-paper-plane me-1"></i> Send to Student
                </button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- ==================== Generate Invoice Modal ==================== -->
<div class="modal fade" id="generateInvoiceModal" tabindex="-1" aria-labelledby="generateInvoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <form action="{{ route('admin.students.invoices.generate', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="invoice_action" id="invoice_action_input" value="download">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title fw-bold text-white" id="generateInvoiceModalLabel">
                <i class="fas fa-file-invoice-dollar me-2"></i> Generate Invoice for {{ $student->first_name }} {{ $student->surname }}
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body p-4">
             <!-- Mode Switch -->
             <div class="card bg-light border-0 mb-4 p-3">
                 <label class="form-label fw-bold me-3">Choose Generation Method:</label>
                 <div class="d-flex gap-4">
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="generation_type" id="inv_gen_type_template" value="template" checked onclick="toggleInvGenMode('template')">
                         <label class="form-check-label fw-semibold" for="inv_gen_type_template">
                            <i class="fas fa-list-alt text-success me-1"></i> Select Built-in Template
                         </label>
                     </div>
                     <div class="form-check">
                         <input class="form-check-input" type="radio" name="generation_type" id="inv_gen_type_file" value="file_upload" onclick="toggleInvGenMode('file')">
                         <label class="form-check-label fw-semibold" for="inv_gen_type_file">
                            <i class="fas fa-cloud-upload-alt text-primary me-1"></i> Upload File (DOCX / PDF / Image)
                         </label>
                     </div>
                 </div>
             </div>

             <!-- Template Block -->
             <div id="inv_block_template">
                 <div class="mb-3">
                     <label class="form-label fw-bold">Select Template <span class="text-danger">*</span></label>
                     <select name="invoice_template_id" id="modal_invoice_template_id" class="form-select form-select-lg" onchange="fetchInvoiceTemplatePreview(this.value)">
                          <option value="">-- Choose an Invoice Template --</option>
                          @if(isset($invoiceTemplates))
                              @foreach($invoiceTemplates as $tpl)
                                  <option value="{{ $tpl->id }}">{{ $tpl->title }} ({{ strtoupper($tpl->type) }})</option>
                              @endforeach
                          @endif
                     </select>
                 </div>

                 <!-- Live Preview Box -->
                 <div id="inv_preview_container" class="d-none">
                     <div class="d-flex justify-content-between align-items-center mb-2">
                          <label class="form-label fw-bold text-success mb-0"><i class="fas fa-eye me-1"></i> Live Preview (Editable before generating):</label>
                          <span class="badge bg-success bg-opacity-10 text-success small">Auto-filled with student data</span>
                     </div>
                     <div class="border rounded shadow-sm bg-white">
                          <textarea name="custom_content" id="modal_invoice_custom_content" class="form-control"></textarea>
                     </div>
                 </div>
             </div>

             <!-- File Upload Block -->
             <div id="inv_block_file" class="d-none">
                 <div class="mb-3">
                     <label class="form-label fw-bold">Upload Custom Invoice File (.docx, .pdf, .jpg, .png)</label>
                     <input type="file" name="uploaded_file" class="form-control form-control-lg" accept=".docx,.pdf,.jpg,.jpeg,.png">
                     <div class="form-text mt-2">
                        <i class="fas fa-info-circle text-info"></i> For <strong>Microsoft Word (.docx)</strong> templates, include placeholders such as <code>${student_name}</code>, <code>${passport_number}</code>, <code>${today_date}</code> inside your doc file to auto-populate student data.
                     </div>
                 </div>
             </div>

          </div>

          <div class="modal-footer bg-light d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Close
            </button>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-outline-success rounded-pill px-4" onclick="document.getElementById('invoice_action_input').value='download'">
                    <i class="fas fa-file-download me-1"></i> Download PDF
                </button>
                <button type="submit" class="btn btn-success rounded-pill px-4" onclick="document.getElementById('invoice_action_input').value='send'">
                    <i class="fas fa-paper-plane me-1"></i> Send to Student
                </button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

<script>
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
                // Set content into Summernote editor
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

function fetchInvoiceTemplatePreview(templateId) {
    if (!templateId) {
        document.getElementById('inv_preview_container').classList.add('d-none');
        return;
    }

    const url = "{{ route('admin.students.invoices.preview_modal', $student->id) }}?template_id=" + templateId;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('inv_preview_container').classList.remove('d-none');
                // Set content into Summernote editor
                $('#modal_invoice_custom_content').summernote('code', data.content);
            }
        })
        .catch(err => console.error('Error fetching invoice preview:', err));
}
</script>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
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

    // Make sure Summernote content is synced before form submit
    $('form').on('submit', function() {
        if ($('#modal_custom_content').length && $('#modal_custom_content').data('summernote')) {
            $('#modal_custom_content').val($('#modal_custom_content').summernote('code'));
        }
        if ($('#modal_invoice_custom_content').length && $('#modal_invoice_custom_content').data('summernote')) {
            $('#modal_invoice_custom_content').val($('#modal_invoice_custom_content').summernote('code'));
        }
    });
});
</script>
@endpush

@endsection

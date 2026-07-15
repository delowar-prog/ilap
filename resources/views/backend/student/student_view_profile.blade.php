@extends('layouts.backend_master')

@section('title', 'My Profile')

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
    width: 100px;
    height: 100px;
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
                <a href="{{ route('student.profile.edit') }}" class="btn btn-light btn-sm profile-edit-btn shadow-sm">
                    <i class="fas fa-edit me-1"></i> Edit Profile
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
                        <h2>{{ $student->first_name }} {{ $student->surname }}</h2>
                        <p><i class="fas fa-id-badge me-1"></i> {{ $student->student_id }} &nbsp;|&nbsp; <i class="fas fa-envelope me-1"></i> {{ $student->email }}</p>
                        <div class="mt-2 text-white-50 small">Profile Completion: <strong class="text-white">{{ $completionPercent }}%</strong></div>
                    </div>
                </div>
            </div>

            <!-- Personal Info -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-user-circle"></i> Personal Information</div>
                <div class="info-grid">
                    <div class="info-item"><label>Full Name</label><span>{{ $student->title }} {{ $student->first_name }} {{ $student->middle_name }} {{ $student->surname }}</span></div>
                    <div class="info-item"><label>Preferred Institute</label><span><span class="badge bg-primary">{{ $student->institute ? $student->institute->name : 'N/A' }}</span></span></div>
                    <div class="info-item"><label>Date of Birth</label><span>{{ $student->dob ? $student->dob->format('d M Y') : 'N/A' }}</span></div>
                    <div class="info-item"><label>Gender</label><span>{{ $student->gender ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Nationality</label><span>{{ $student->nationality ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Country of Birth</label><span>{{ $student->country_of_birth ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Native Language</label><span>{{ $student->native_language ?? 'N/A' }}</span></div>
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
                
                <h6 class="text-muted text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">UK Travel History</h6>
                <div class="info-grid">
                    <div class="info-item"><label>Applied to remain in UK?</label><span>{{ $student->applied_leave_to_remain_uk ? 'Yes' : 'No' }}</span></div>
                    <div class="info-item"><label>Need Visa for UK?</label><span>{{ $student->need_visa_for_uk ? 'Yes' : 'No' }}</span></div>
                    <div class="info-item"><label>Refused Visa or Deported?</label><span>{{ $student->refused_visa_or_deported ? 'Yes' : 'No' }}</span></div>
                    <div class="info-item"><label>Taken TB Test?</label><span>{{ $student->taken_tb_test ?? 'N/A' }}</span></div>
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
                                <th>Result / %</th>
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
                                <td><span class="badge bg-success">{{ $aca->result_percentage }}</span></td>
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
            </div>

            <!-- Documents -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-folder-open"></i> Uploaded Documents</div>
                @if($documents->count() > 0)
                <div class="list-group">
                    @foreach($documents as $doc)
                    <a href="{{ asset($doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                        <div>
                            <i class="fas fa-file-pdf text-danger me-2 fs-2 align-middle"></i>
                            <strong>{{ $doc->document_type }}</strong>
                            <div class="text-muted small mt-1">Uploaded: {{ $doc->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <i class="fas fa-external-link-alt text-primary"></i>
                    </a>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">No documents uploaded.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

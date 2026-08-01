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
                <a href="{{ route('student.profile.edit') }}" class="btn btn-light btn-sm profile-edit-btn shadow-sm">
                    <i class="fas fa-edit me-1"></i> Edit Profile
                </a>
                <div class="profile-avatar-container">
                    <label for="header_profile_picture" style="cursor: pointer; position: relative; display: inline-block;" class="position-relative overflow-hidden shadow-sm rounded-circle">
                        @if($student->profile_picture)
                            <img id="header-avatar-img" src="{{ asset($student->profile_picture) }}" alt="Profile" class="profile-avatar">
                        @else
                            <div id="header-avatar-img" class="profile-avatar">
                                {{ strtoupper(substr($student->first_name,0,1)) }}{{ strtoupper(substr($student->surname,0,1)) }}
                            </div>
                        @endif
                        <div class="position-absolute bottom-0 w-100 text-center" style="background: rgba(0,0,0,0.5); padding: 5px 0; font-size: 0.8rem; color: #fff;">
                            <i class="fas fa-camera"></i> Change
                        </div>
                    </label>
                    <form id="headerProfilePicForm" style="display: none;">
                        <input type="file" id="header_profile_picture" name="profile_picture" accept="image/*" onchange="uploadHeaderProfilePicture(this)">
                    </form>
                    
                    <div class="profile-header-info">
                        <h2>{{ ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname)) }}</h2>
                        <p><i class="fas fa-id-badge me-1"></i> {{ $student->student_id }} &nbsp;|&nbsp; <i class="fas fa-envelope me-1"></i> {{ $student->email }}</p>
                        <div class="mt-2 text-white-50 small">Profile Completion: <strong class="text-white">{{ $completionPercent }}%</strong></div>
                    </div>
                </div>
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
                <div class="info-section-title"><i class="fas fa-user-circle"></i> Personal Information</div>
                <div class="info-grid">
                    <div class="info-item"><label>First Name</label><span>{{ $student->first_name }}</span></div>
                    <div class="info-item"><label>Middle Name</label><span>{{ $student->middle_name ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Last Name (Surname)</label><span>{{ $student->surname }}</span></div>
                    <div class="info-item"><label>Preferred Institute</label><span><span class="badge bg-primary">{{ $student->institute ? $student->institute->name : 'N/A' }}</span></span></div>
                    <div class="info-item"><label>Date of Birth</label><span>{{ $student->dob ? $student->dob->format('d M Y') : 'N/A' }}</span></div>
                    <div class="info-item"><label>Gender</label><span>{{ $student->gender ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Country of Nationality</label><span>{{ $student->nationality ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Country of Birth</label><span>{{ $student->country_of_birth ?? 'N/A' }}</span></div>
                    <div class="info-item"><label>Country of Residence</label><span>{{ $student->country ? $student->country->name : 'N/A' }}</span></div>
                    <div class="info-item"><label>Phone</label><span>{{ $student->phone ?? 'N/A' }}</span></div>
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
            </div>

            <!-- Documents -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-folder-open"></i> Uploaded Documents</div>
                @if($documents->count() > 0)
                <div class="list-group">
                    @foreach($documents as $doc)
                    <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div>
                            <i class="fas fa-file-pdf text-danger me-2 fs-2 align-middle"></i>
                            <strong>{{ $doc->document_type }}</strong>
                            <div class="text-muted small mt-1">Uploaded: {{ $doc->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info" title="View Document">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ Storage::url($doc->file_path) }}" class="btn btn-sm btn-outline-primary" download title="Download Document">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted mb-0">No documents uploaded.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@push('scripts')
<script>
    function uploadHeaderProfilePicture(input) {
        if (!input.files || !input.files[0]) return;
        
        let formData = new FormData();
        formData.append('profile_picture', input.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        // Show a loading state or toast if you have one
        const imgEl = document.getElementById('header-avatar-img');
        const originalSrc = imgEl.src;
        
        // Optional: show a quick preview locally while uploading
        const reader = new FileReader();
        reader.onload = function(e) {
            if(imgEl.tagName === 'IMG') {
                imgEl.src = e.target.result;
            } else {
                imgEl.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;" />`;
            }
        }
        reader.readAsDataURL(input.files[0]);

        fetch('{{ route('student.profile.personal') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.profile_picture_url) {
                // Success: The image is already updated via FileReader preview, 
                // but we can set it to the real URL just in case
                if(imgEl.tagName === 'IMG') {
                    imgEl.src = data.profile_picture_url;
                }
                
                // Update navbars too if they exist
                const navAvatars = document.querySelectorAll('.avatar img');
                navAvatars.forEach(img => {
                    img.src = data.profile_picture_url;
                });
                
                // Optionally reload to refresh all avatars perfectly
                // location.reload();
            } else {
                alert('Failed to upload picture.');
                if(imgEl.tagName === 'IMG') imgEl.src = originalSrc;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during upload.');
            if(imgEl.tagName === 'IMG') imgEl.src = originalSrc;
        });
    }
</script>
<script>
    function copyInviteLink() {
        var copyText = document.getElementById("inviteLinkInput");
        var textToCopy = copyText.value;

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(textToCopy).then(function() {
                alert("link copied");
            });
        } else {
            var textArea = document.createElement("textarea");
            textArea.value = textToCopy;
            textArea.style.position = "absolute";
            textArea.style.left = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
                alert("link copied");
            } catch (err) {
                console.error('Fallback copy failed', err);
            }
            document.body.removeChild(textArea);
        }
    }
</script>
@endpush
@endsection

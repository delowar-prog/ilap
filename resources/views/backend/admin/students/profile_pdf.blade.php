<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Profile - {{ $student->student_id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #2c3e7a;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header table {
            width: 100%;
        }
        .logo-text {
            font-size: 22px;
            font-weight: bold;
            color: #2c3e7a;
        }
        .student-id {
            font-size: 13px;
            font-weight: bold;
            color: #666;
            text-align: right;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            color: #1a9fd4;
            margin-bottom: 12px;
            text-transform: uppercase;
        }
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f0f4ff;
            color: #2c3e7a;
            font-size: 11px;
            font-weight: bold;
            padding: 5px 8px;
            margin-bottom: 8px;
            border-left: 4px solid #2c3e7a;
            text-transform: uppercase;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
        }
        .info-table td.label {
            font-weight: bold;
            color: #555;
            width: 25%;
        }
        .info-table td.value {
            color: #222;
            width: 25%;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        .data-table th {
            background-color: #2c3e7a;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 5px 6px;
            font-size: 9px;
            border: 1px solid #ddd;
        }
        .data-table td {
            padding: 5px 6px;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 8px;
            color: #777;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 4px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="vertical-align: middle;">
                    <span class="logo-text">iLap</span><br>
                    <span style="font-size: 9px; color: #666;">International Learning & Assessment Portal</span>
                    <div style="margin-top: 10px; font-size: 13px; font-weight: bold; color: #2c3e7a;">
                        STUDENT RECORD: {{ $student->student_id }}
                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle; width: 85px;">
                    @if($student->profile_picture && file_exists(public_path($student->profile_picture)))
                        <img src="{{ public_path($student->profile_picture) }}" style="width: 75px; height: 75px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover; display: block; float: right;">
                    @else
                        <div style="width: 75px; height: 75px; border-radius: 6px; border: 1px solid #ddd; background-color: #f0f4ff; text-align: center; line-height: 75px; color: #2c3e7a; font-weight: bold; font-size: 20px; float: right; display: block;">
                            {{ strtoupper(substr($student->first_name, 0, 1)) }}{{ strtoupper(substr($student->surname, 0, 1)) }}
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        {{ ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname)) }}
    </div>

    <!-- Personal Information -->
    <div class="section">
        <div class="section-title">Personal Information</div>
        <table class="info-table">
            <tr>
                <td class="label">First Name:</td>
                <td class="value" colspan="3">{{ $student->first_name }}</td>
            </tr>
            <tr>
                <td class="label">Middle Name:</td>
                <td class="value" colspan="3">{{ $student->middle_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Last Name (Surname):</td>
                <td class="value" colspan="3">{{ $student->surname }}</td>
            </tr>
            <tr>
                <td class="label">Date of Birth:</td>
                <td class="value">{{ $student->dob ? $student->dob->format('d M Y') : 'N/A' }}</td>
                <td class="label">Gender:</td>
                <td class="value">{{ $student->gender ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Country of Nationality:</td>
                <td class="value">{{ $student->nationality ?? 'N/A' }}</td>
                <td class="label">Country of Birth:</td>
                <td class="value">{{ $student->country_of_birth ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Email Address:</td>
                <td class="value">{{ $student->email }}</td>
                <td class="label">Phone Number:</td>
                <td class="value">{{ $student->phone ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">WhatsApp Available:</td>
                <td class="value">{{ $student->has_whatsapp ? 'Yes' : 'No' }}</td>
                <td class="label">Native Language:</td>
                <td class="value">{{ $student->native_language ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Preferred Institute:</td>
                <td class="value" colspan="3">{{ $student->institute ? $student->institute->name : 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- Passport Details -->
    <div class="section">
        <div class="section-title">Passport Details</div>
        <table class="info-table">
            <tr>
                <td class="label">Name in Passport:</td>
                <td class="value">{{ $student->name_in_passport ?? 'N/A' }}</td>
                <td class="label">Passport Number:</td>
                <td class="value">{{ $student->passport_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Issue Location:</td>
                <td class="value">{{ $student->passport_issue_location ?? 'N/A' }}</td>
                <td class="label">Issue Date:</td>
                <td class="value">{{ $student->passport_issue_date ? \Carbon\Carbon::parse($student->passport_issue_date)->format('d M Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Expiry Date:</td>
                <td class="value" colspan="3">{{ $student->passport_expiry_date ? \Carbon\Carbon::parse($student->passport_expiry_date)->format('d M Y') : 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <!-- Addresses & Emergency Contact -->
    <div class="section">
        <div class="section-title">Addresses & Emergency Contact</div>
        <table class="info-table">
            <tr>
                <td class="label">Permanent Address:</td>
                <td class="value" colspan="3">
                    {{ $student->permanent_address ?? 'N/A' }}<br>
                    State: {{ $student->permanent_state ?? 'N/A' }}, City: {{ $student->permanent_city ?? 'N/A' }} - {{ $student->permanent_postcode ?? 'N/A' }}<br>
                    Country: {{ $student->permanent_country ?? 'N/A' }}
                </td>
            </tr>
            @if($student->current_address)
            <tr>
                <td class="label">Current Address:</td>
                <td class="value" colspan="3">
                    {{ $student->current_address }}<br>
                    State: {{ $student->current_state ?? 'N/A' }}, City: {{ $student->current_city ?? 'N/A' }} - {{ $student->current_postcode ?? 'N/A' }}<br>
                    Country: {{ $student->current_country ?? 'N/A' }}
                </td>
            </tr>
            @endif
            <tr>
                <td class="label" style="border-top: 1px solid #ddd; padding-top: 6px; margin-top: 5px;">Emergency Contact:</td>
                <td class="value" colspan="3" style="border-top: 1px solid #ddd; padding-top: 6px; margin-top: 5px;">
                    <strong>{{ $student->emergency_contact_name ?? 'N/A' }}</strong> ({{ $student->emergency_contact_relationship ?? 'N/A' }})<br>
                    Mobile: {{ $student->emergency_contact_mobile ?? 'N/A' }} | Email: {{ $student->emergency_contact_email ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Travel & Immigration History -->
    <div class="section">
        <div class="section-title">Travel & Immigration History</div>
        @php
            $travel = $student->travel_history;
            $immigration = $student->immigration_history;
            $refusal = $student->visa_refusals;
        @endphp
        <table class="info-table">
            <tr>
                <td class="label">UK Travel History:</td>
                <td class="value" colspan="3">
                    @if(($travel['has_history'] ?? 'no') === 'yes')
                        Yes (Arrival: {{ $travel['arrival_date'] ?? 'N/A' }} to {{ $travel['departure_date'] ?? 'N/A' }}, Visa Type: {{ $travel['visa_type'] ?? 'N/A' }}, Purpose: {{ $travel['purpose_of_visit'] ?? 'N/A' }} in {{ $travel['country'] ?? 'N/A' }})
                    @else
                        No UK Travel History in the past 10 years.
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Study Destination Visas:</td>
                <td class="value" colspan="3">
                    Needs visa for: {{ implode(', ', $immigration['countries'] ?? ['None']) }}
                </td>
            </tr>
            <tr>
                <td class="label">Visa Refusals:</td>
                <td class="value" colspan="3">
                    @if(($refusal['has_refusal'] ?? 'no') === 'yes')
                        Yes (Refusal Type: {{ $refusal['refusal_type'] ?? 'N/A' }}, Date: {{ $refusal['refusal_date'] ?? 'N/A' }}, Country: {{ $refusal['country'] ?? 'N/A' }}, Visa: {{ $refusal['visa_type'] ?? 'N/A' }})<br>
                        Reason: {{ $refusal['details'] ?? 'N/A' }}
                    @else
                        No prior visa refusals or deportations.
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Academic History -->
    <div class="section">
        <div class="section-title">Academic History</div>
        @if($academics && $academics->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Education Level</th>
                    <th>Institution & Address</th>
                    <th>Course / Subject</th>
                    <th>Dates (Start - End)</th>
                    <th>Result / GPA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($academics as $aca)
                <tr>
                    <td>{{ $aca->education_level }}</td>
                    <td>
                        <strong>{{ $aca->institution_name }}</strong><br>
                        {{ implode(', ', array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country])) }}
                    </td>
                    <td>{{ $aca->course_subject }}</td>
                    <td>{{ $aca->start_date ? \Carbon\Carbon::parse($aca->start_date)->format('M Y') : 'N/A' }} - {{ $aca->end_date ? \Carbon\Carbon::parse($aca->end_date)->format('M Y') : 'N/A' }}</td>
                    <td>{{ $aca->result }} {{ $aca->result_type === 'gpa' ? 'GPA' : '%' }} {{ $aca->out_of ? '(Out of ' . $aca->out_of . ')' : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="padding-left: 5px; color: #777; margin: 0;">No academic records uploaded.</p>
        @endif
    </div>

    <!-- English Language Proficiency -->
    <div class="section">
        <div class="section-title">English Language Proficiency</div>
        @if($englishTests && $englishTests->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Date of Exam</th>
                    <th>Overall Score</th>
                    <th>Listening</th>
                    <th>Reading</th>
                    <th>Writing</th>
                    <th>Speaking</th>
                    <th>TRF / UKVI Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($englishTests as $test)
                <tr>
                    <td><strong>{{ $test->test_name }}</strong></td>
                    <td>{{ $test->date_of_exam ? \Carbon\Carbon::parse($test->date_of_exam)->format('d M Y') : 'N/A' }}</td>
                    <td><strong>{{ $test->overall_score }}</strong></td>
                    <td>{{ $test->listening ?? 'N/A' }}</td>
                    <td>{{ $test->reading ?? 'N/A' }}</td>
                    <td>{{ $test->writing ?? 'N/A' }}</td>
                    <td>{{ $test->speaking ?? 'N/A' }}</td>
                    <td>
                        TRF: {{ $test->trf_number ?? 'N/A' }}<br>
                        UKVI: {{ $test->ukvi_number ?? 'N/A' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="padding-left: 5px; color: #777; margin: 0;">No English test scores or native language specified.</p>
        @endif
    </div>

    <!-- References -->
    <div class="section">
        <div class="section-title">References</div>
        @if($referees && $referees->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Referee Name</th>
                    <th>Type / Relationship</th>
                    <th>Designation & Organization</th>
                    <th>Contact Information</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referees as $ref)
                <tr>
                    <td><strong>{{ $ref->name }}</strong></td>
                    <td>{{ $ref->type }}</td>
                    <td>{{ $ref->designation }} at {{ $ref->company_name }}</td>
                    <td>
                        Email: {{ $ref->email }}<br>
                        Phone: {{ $ref->phone }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="padding-left: 5px; color: #777; margin: 0;">No references listed.</p>
        @endif
    </div>

    <div class="footer">
        Generated automatically by iLap Portal on {{ date('d M Y H:i:s') }}
    </div>

</body>
</html>

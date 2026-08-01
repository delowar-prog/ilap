<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Profile - <?php echo e($student->student_id); ?></title>
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
                        STUDENT RECORD: <?php echo e($student->student_id); ?>

                    </div>
                </td>
                <td style="text-align: right; vertical-align: middle; width: 85px;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->profile_picture && file_exists(public_path($student->profile_picture))): ?>
                        <img src="<?php echo e(public_path($student->profile_picture)); ?>" style="width: 75px; height: 75px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover; display: block; float: right;">
                    <?php else: ?>
                        <div style="width: 75px; height: 75px; border-radius: 6px; border: 1px solid #ddd; background-color: #f0f4ff; text-align: center; line-height: 75px; color: #2c3e7a; font-weight: bold; font-size: 20px; float: right; display: block;">
                            <?php echo e(strtoupper(substr($student->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($student->surname, 0, 1))); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        <?php echo e(ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname))); ?>

    </div>

    <!-- Personal Information -->
    <div class="section">
        <div class="section-title">Personal Information</div>
        <table class="info-table">
            <tr>
                <td class="label">First Name:</td>
                <td class="value" colspan="3"><?php echo e($student->first_name); ?></td>
            </tr>
            <tr>
                <td class="label">Middle Name:</td>
                <td class="value" colspan="3"><?php echo e($student->middle_name ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">Last Name (Surname):</td>
                <td class="value" colspan="3"><?php echo e($student->surname); ?></td>
            </tr>
            <tr>
                <td class="label">Date of Birth:</td>
                <td class="value"><?php echo e($student->dob ? $student->dob->format('d M Y') : 'N/A'); ?></td>
                <td class="label">Gender:</td>
                <td class="value"><?php echo e($student->gender ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">Country of Nationality:</td>
                <td class="value"><?php echo e($student->nationality ?? 'N/A'); ?></td>
                <td class="label">Country of Birth:</td>
                <td class="value"><?php echo e($student->country_of_birth ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">Email Address:</td>
                <td class="value"><?php echo e($student->email); ?></td>
                <td class="label">Phone Number:</td>
                <td class="value"><?php echo e($student->phone ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">WhatsApp Available:</td>
                <td class="value"><?php echo e($student->has_whatsapp ? 'Yes' : 'No'); ?></td>
                <td class="label">Native Language:</td>
                <td class="value"><?php echo e($student->native_language ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">Preferred Institute:</td>
                <td class="value" colspan="3"><?php echo e($student->institute ? $student->institute->name : 'N/A'); ?></td>
            </tr>
        </table>
    </div>

    <!-- Passport Details -->
    <div class="section">
        <div class="section-title">Passport Details</div>
        <table class="info-table">
            <tr>
                <td class="label">Name in Passport:</td>
                <td class="value"><?php echo e($student->name_in_passport ?? 'N/A'); ?></td>
                <td class="label">Passport Number:</td>
                <td class="value"><?php echo e($student->passport_number ?? 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">Issue Location:</td>
                <td class="value"><?php echo e($student->passport_issue_location ?? 'N/A'); ?></td>
                <td class="label">Issue Date:</td>
                <td class="value"><?php echo e($student->passport_issue_date ? \Carbon\Carbon::parse($student->passport_issue_date)->format('d M Y') : 'N/A'); ?></td>
            </tr>
            <tr>
                <td class="label">Expiry Date:</td>
                <td class="value" colspan="3"><?php echo e($student->passport_expiry_date ? \Carbon\Carbon::parse($student->passport_expiry_date)->format('d M Y') : 'N/A'); ?></td>
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
                    <?php echo e($student->permanent_address ?? 'N/A'); ?><br>
                    State: <?php echo e($student->permanent_state ?? 'N/A'); ?>, City: <?php echo e($student->permanent_city ?? 'N/A'); ?> - <?php echo e($student->permanent_postcode ?? 'N/A'); ?><br>
                    Country: <?php echo e($student->permanent_country ?? 'N/A'); ?>

                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->current_address): ?>
            <tr>
                <td class="label">Current Address:</td>
                <td class="value" colspan="3">
                    <?php echo e($student->current_address); ?><br>
                    State: <?php echo e($student->current_state ?? 'N/A'); ?>, City: <?php echo e($student->current_city ?? 'N/A'); ?> - <?php echo e($student->current_postcode ?? 'N/A'); ?><br>
                    Country: <?php echo e($student->current_country ?? 'N/A'); ?>

                </td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <tr>
                <td class="label" style="border-top: 1px solid #ddd; padding-top: 6px; margin-top: 5px;">Emergency Contact:</td>
                <td class="value" colspan="3" style="border-top: 1px solid #ddd; padding-top: 6px; margin-top: 5px;">
                    <strong><?php echo e($student->emergency_contact_name ?? 'N/A'); ?></strong> (<?php echo e($student->emergency_contact_relationship ?? 'N/A'); ?>)<br>
                    Mobile: <?php echo e($student->emergency_contact_mobile ?? 'N/A'); ?> | Email: <?php echo e($student->emergency_contact_email ?? 'N/A'); ?>

                </td>
            </tr>
        </table>
    </div>

    <!-- Travel & Immigration History -->
    <div class="section">
        <div class="section-title">Travel & Immigration History</div>
        <?php
            $travel = $student->travel_history;
            $immigration = $student->immigration_history;
            $refusal = $student->visa_refusals;
        ?>
        <table class="info-table">
            <tr>
                <td class="label">UK Travel History:</td>
                <td class="value" colspan="3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($travel['has_history'] ?? 'no') === 'yes'): ?>
                        Yes (Arrival: <?php echo e($travel['arrival_date'] ?? 'N/A'); ?> to <?php echo e($travel['departure_date'] ?? 'N/A'); ?>, Visa Type: <?php echo e($travel['visa_type'] ?? 'N/A'); ?>, Purpose: <?php echo e($travel['purpose_of_visit'] ?? 'N/A'); ?> in <?php echo e($travel['country'] ?? 'N/A'); ?>)
                    <?php else: ?>
                        No UK Travel History in the past 10 years.
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="label">Study Destination Visas:</td>
                <td class="value" colspan="3">
                    Needs visa for: <?php echo e(implode(', ', $immigration['countries'] ?? ['None'])); ?>

                </td>
            </tr>
            <tr>
                <td class="label">Visa Refusals:</td>
                <td class="value" colspan="3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($refusal['has_refusal'] ?? 'no') === 'yes'): ?>
                        Yes (Refusal Type: <?php echo e($refusal['refusal_type'] ?? 'N/A'); ?>, Date: <?php echo e($refusal['refusal_date'] ?? 'N/A'); ?>, Country: <?php echo e($refusal['country'] ?? 'N/A'); ?>, Visa: <?php echo e($refusal['visa_type'] ?? 'N/A'); ?>)<br>
                        Reason: <?php echo e($refusal['details'] ?? 'N/A'); ?>

                    <?php else: ?>
                        No prior visa refusals or deportations.
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Academic History -->
    <div class="section">
        <div class="section-title">Academic History</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($academics && $academics->count() > 0): ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $academics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td><?php echo e($aca->education_level); ?></td>
                    <td>
                        <strong><?php echo e($aca->institution_name); ?></strong><br>
                        <?php echo e(implode(', ', array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country]))); ?>

                    </td>
                    <td><?php echo e($aca->course_subject); ?></td>
                    <td><?php echo e($aca->start_date ? \Carbon\Carbon::parse($aca->start_date)->format('M Y') : 'N/A'); ?> - <?php echo e($aca->end_date ? \Carbon\Carbon::parse($aca->end_date)->format('M Y') : 'N/A'); ?></td>
                    <td><?php echo e($aca->result); ?> <?php echo e($aca->result_type === 'gpa' ? 'GPA' : '%'); ?> <?php echo e($aca->out_of ? '(Out of ' . $aca->out_of . ')' : ''); ?></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p style="padding-left: 5px; color: #777; margin: 0;">No academic records uploaded.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- English Language Proficiency -->
    <div class="section">
        <div class="section-title">English Language Proficiency</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($englishTests && $englishTests->count() > 0): ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $englishTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td><strong><?php echo e($test->test_name); ?></strong></td>
                    <td><?php echo e($test->date_of_exam ? \Carbon\Carbon::parse($test->date_of_exam)->format('d M Y') : 'N/A'); ?></td>
                    <td><strong><?php echo e($test->overall_score); ?></strong></td>
                    <td><?php echo e($test->listening ?? 'N/A'); ?></td>
                    <td><?php echo e($test->reading ?? 'N/A'); ?></td>
                    <td><?php echo e($test->writing ?? 'N/A'); ?></td>
                    <td><?php echo e($test->speaking ?? 'N/A'); ?></td>
                    <td>
                        TRF: <?php echo e($test->trf_number ?? 'N/A'); ?><br>
                        UKVI: <?php echo e($test->ukvi_number ?? 'N/A'); ?>

                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p style="padding-left: 5px; color: #777; margin: 0;">No English test scores or native language specified.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- References -->
    <div class="section">
        <div class="section-title">References</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referees && $referees->count() > 0): ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $referees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td><strong><?php echo e($ref->name); ?></strong></td>
                    <td><?php echo e($ref->type); ?></td>
                    <td><?php echo e($ref->designation); ?> at <?php echo e($ref->company_name); ?></td>
                    <td>
                        Email: <?php echo e($ref->email); ?><br>
                        Phone: <?php echo e($ref->phone); ?>

                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p style="padding-left: 5px; color: #777; margin: 0;">No references listed.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="footer">
        Generated automatically by iLap Portal on <?php echo e(date('d M Y H:i:s')); ?>

    </div>

</body>
</html>
<?php /**PATH C:\laragon\www\iLap\resources\views\backend\admin\students\profile_pdf.blade.php ENDPATH**/ ?>
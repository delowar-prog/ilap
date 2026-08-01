<?php $__env->startSection('title', 'Assessment Details'); ?>

<?php $__env->startPush('css'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('admin_contents'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex justify-content-between align-items-center">
            <h4 class="page-title">Assessment Details: <?php echo e($assessment->full_name); ?></h4>
            <a href="<?php echo e(route('admin.pre.assessments.index', ['status' => $assessment->assessment_status])); ?>" class="btn btn-secondary btn-sm">
                <i class="mdi mdi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
<div class="profile-card">
            
            <!-- Header Section -->
            <div class="profile-header">

                <div class="profile-avatar-container">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->profile_picture): ?>
                        <img src="<?php echo e(asset($student->profile_picture)); ?>" alt="Profile" class="profile-avatar">
                    <?php else: ?>
                        <div class="profile-avatar">
                            <?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->surname,0,1))); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="profile-header-info">
                        <h2><?php echo e(ucwords(trim($student->title . ' ' . $student->first_name . ' ' . $student->middle_name . ' ' . $student->surname))); ?></h2>
                        <p><i class="fas fa-id-badge me-1"></i> <?php echo e($student->student_id); ?> &nbsp;|&nbsp; <i class="fas fa-envelope me-1"></i> <?php echo e($student->email); ?></p>
                        <div class="mt-2 text-white-50 small">Profile Completion: <strong class="text-white"><?php echo e($completionPercent); ?>%</strong></div>
                    </div>
                </div>
            </div>

            <!-- Referral Info (Only visible to the owner and enrolled students) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(Auth::id() == $student->user_id && $student->enrolment_status === 'enrolled'): ?>
            <div class="info-section bg-light" style="border-bottom: 2px solid #e1e8f1;">
                <div class="info-section-title"><i class="fas fa-bullhorn text-primary"></i> Invite Friends</div>
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <p class="text-muted mb-2">Share this invite link for new registrations.</p>
                        <div class="input-group mb-3 shadow-sm">
                            <span class="input-group-text bg-white"><i class="fas fa-link text-primary"></i></span>
                            <input type="text" class="form-control bg-white" id="inviteLinkInput" value="<?php echo e(url('/register/' . ($student->user_id ?? ''))); ?>" readonly>
                            <button class="btn btn-primary" type="button" onclick="copyInviteLink()"><i class="fas fa-copy"></i> Copy</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="info-grid" style="grid-template-columns: 1fr 1fr;">
                            <div class="info-item">
                                <label>Your Promo Code</label>
                                <span class="badge bg-success" style="font-size: 1rem; padding: 8px 12px;"><?php echo e($student->user->referral_code ?? 'N/A'); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Your Campus Code</label>
                                <span class="badge bg-info text-dark" style="font-size: 1rem; padding: 8px 12px;"><?php echo e($student->campus ? $student->campus->campus_code : 'N/A'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Personal Info -->
            <!-- Personal Info -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-user-circle"></i> Personal Information</div>
                <div class="info-grid">
                    <div class="info-item"><label>First Name</label><span><?php echo e($assessment->first_name ?? $student->first_name); ?></span></div>
                    <div class="info-item"><label>Middle Name</label><span><?php echo e($assessment->middle_name ?? $student->middle_name ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Last Name (Surname)</label><span><?php echo e($assessment->surname ?? $student->surname); ?></span></div>
                    <div class="info-item">
                        <label>Preferred Institute</label>
                        <span>
                            <span class="badge bg-primary">
                                <?php echo e($assessment->institute_name ?? ($student->institute ? $student->institute->name : 'N/A')); ?>

                            </span>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <span>
                            <?php
                                $dobVal = $assessment->dob ?? $student->dob;
                            ?>
                            <?php echo e($dobVal ? ($dobVal instanceof \DateTimeInterface ? $dobVal->format('d M Y') : date('d M Y', strtotime($dobVal))) : 'N/A'); ?>

                        </span>
                    </div>
                    <div class="info-item"><label>Gender</label><span><?php echo e($assessment->gender ?? $student->gender ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Country of Nationality</label><span><?php echo e($assessment->nationality ?? $student->nationality ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Country of Birth</label><span><?php echo e($student->country_of_birth ?? $assessment->country ?? 'N/A'); ?></span></div>
                    <div class="info-item">
                        <label>Country of Residence</label>
                        <span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->country): ?>
                                <?php echo e($assessment->country); ?>

                            <?php elseif($student->country): ?>
                                <?php echo e($student->country->name); ?>

                            <?php else: ?>
                                N/A
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                    </div>
                    <div class="info-item"><label>Phone</label><span><?php echo e($assessment->contact_number ?? $student->phone ?? 'N/A'); ?></span></div>
                    <div class="info-item">
                        <label>WhatsApp Status</label>
                        <span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->has_whatsapp): ?>
                                <span class="badge bg-success"><i class="fab fa-whatsapp me-1"></i> Available on <?php echo e($student->phone); ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Not Marked</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Address Info -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-map-marker-alt"></i> Contact & Address</div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Contact Address (Pre-Assessment)</h6>
                        <div class="info-grid" style="grid-template-columns: 1fr;">
                            <div class="info-item"><label>Address</label><span><?php echo e($assessment->contact_address ?? $student->permanent_address ?? 'N/A'); ?></span></div>
                            <div class="info-item">
                                <label>City, State & Postcode</label>
                                <span>
                                    <?php
                                        $addrParts = array_filter([$assessment->city, $assessment->state, $assessment->postal_code]);
                                        $permCityZip = trim(($student->permanent_city ?? '').' '.($student->permanent_postcode ?? ''));
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($addrParts)): ?>
                                        <?php echo e(implode(', ', $addrParts)); ?>

                                    <?php elseif($permCityZip !== ''): ?>
                                        <?php echo e($permCityZip); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </span>
                            </div>
                            <div class="info-item"><label>Country</label><span><?php echo e($assessment->country ?? $student->permanent_country ?? 'N/A'); ?></span></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase mb-3" style="font-size: 0.8rem;">Permanent / Current Address (Student Profile)</h6>
                        <div class="info-grid" style="grid-template-columns: 1fr;">
                            <div class="info-item"><label>Address</label><span><?php echo e($student->current_address ?? $student->permanent_address ?? 'N/A'); ?></span></div>
                            <div class="info-item">
                                <label>City & Postcode</label>
                                <span>
                                    <?php
                                        $currCityZip = trim(($student->current_city ?? $student->permanent_city ?? '').' '.($student->current_postcode ?? $student->permanent_postcode ?? ''));
                                    ?>
                                    <?php echo e($currCityZip !== '' ? $currCityZip : 'N/A'); ?>

                                </span>
                            </div>
                            <div class="info-item"><label>Country</label><span><?php echo e($student->current_country ?? $student->permanent_country ?? 'N/A'); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passport & Travel Info -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-passport"></i> Passport & Travel History</div>
                <div class="info-grid mb-4">
                    <div class="info-item"><label>Name in Passport</label><span><?php echo e($student->name_in_passport ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Passport Number</label><span><?php echo e($assessment->passport_number ?? $student->passport_number ?? 'N/A'); ?></span></div>
                    <div class="info-item"><label>Issue Date</label><span><?php echo e($student->passport_issue_date ? $student->passport_issue_date->format('d M Y') : 'N/A'); ?></span></div>
                    <div class="info-item"><label>Expiry Date</label><span><?php echo e($student->passport_expiry_date ? $student->passport_expiry_date->format('d M Y') : 'N/A'); ?></span></div>
                    <div class="info-item"><label>Issue Location</label><span><?php echo e($student->passport_issue_location ?? 'N/A'); ?></span></div>
                </div>
                
                <?php
                    $travelHistory = $assessment->travel_history ?? $student->travel_history ?? [];
                    $immigrationHistory = $assessment->immigration_history ?? $student->immigration_history ?? [];
                    $visaRefusals = $assessment->visa_refusals ?? $student->visa_refusals ?? [];
                    $takenTbTest = $student->taken_tb_test ?? 'N/A';
                ?>
                <h6 class="text-muted text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">Travel & Immigration History</h6>
                <div class="row g-3">
                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Permission to remain in past 10 years:</strong> 
                            <span class="badge <?php echo e(($travelHistory['has_history'] ?? '') === 'yes' ? 'bg-primary' : 'bg-secondary'); ?>">
                                <?php echo e(strtoupper($travelHistory['has_history'] ?? 'No')); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($travelHistory['has_history'] ?? '') === 'yes'): ?>
                                <?php
                                    $tEntries = $travelHistory['entries'] ?? [];
                                    if (empty($tEntries) && (!empty($travelHistory['country']) || !empty($travelHistory['arrival_date']))) {
                                        $tEntries = [$travelHistory];
                                    }
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $tEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="mt-2 ps-3 border-start border-3 border-primary mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($tEntries) > 1): ?><div class="fw-bold text-primary mb-1 font-12">Travel Entry #<?php echo e($idx + 1); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="row g-2">
                                            <div class="col-md-6"><strong>Country:</strong> <?php echo e($tEntry['country'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Visa Type:</strong> <?php echo e($tEntry['visa_type'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Purpose:</strong> <?php echo e($tEntry['purpose_of_visit'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Arrival Date:</strong> <?php echo e($tEntry['arrival_date'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Departure Date:</strong> <?php echo e($tEntry['departure_date'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Visa Validity:</strong> <?php echo e($tEntry['visa_start_date'] ?? 'N/A'); ?> to <?php echo e($tEntry['visa_expiry_date'] ?? 'N/A'); ?></div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Needs visa for:</strong> 
                            <?php
                                $immCountries = $immigrationHistory['countries'] ?? [];
                            ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($immCountries) || in_array('None', $immCountries)): ?>
                                <span class="badge bg-secondary">None</span>
                            <?php else: ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $immCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <span class="badge bg-success me-1"><?php echo e($country); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>Refused visa/asylum/deported:</strong> 
                            <span class="badge <?php echo e(($visaRefusals['has_refusal'] ?? '') === 'yes' ? 'bg-danger' : 'bg-secondary'); ?>">
                                <?php echo e(strtoupper($visaRefusals['has_refusal'] ?? 'No')); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($visaRefusals['has_refusal'] ?? '') === 'yes'): ?>
                                <?php
                                    $rEntries = $visaRefusals['entries'] ?? [];
                                    if (empty($rEntries) && (!empty($visaRefusals['country']) || !empty($visaRefusals['refusal_type']))) {
                                        $rEntries = [$visaRefusals];
                                    }
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $rEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="mt-2 ps-3 border-start border-3 border-danger mb-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($rEntries) > 1): ?><div class="fw-bold text-danger mb-1 font-12">Refusal Entry #<?php echo e($idx + 1); ?></div><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="row g-2">
                                            <div class="col-md-6"><strong>Country:</strong> <?php echo e($rEntry['country'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Visa Type:</strong> <?php echo e($rEntry['visa_type'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Refusal Type:</strong> <?php echo e($rEntry['refusal_type'] ?? 'N/A'); ?></div>
                                            <div class="col-md-6"><strong>Date of Refusal:</strong> <?php echo e($rEntry['refusal_date'] ?? 'N/A'); ?></div>
                                            <div class="col-md-12"><strong>Details/Reason:</strong> <?php echo e($rEntry['details'] ?? 'N/A'); ?></div>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    
                    <div class="col-md-12">
                        <div class="p-3 border rounded bg-light font-13">
                            <strong>TB Test Details:</strong> <?php echo e($takenTbTest); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Academics -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-graduation-cap"></i> Academic History</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($academics->count() > 0): ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $academics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($aca->education_level); ?></td>
                                <td>
                                    <?php echo e($aca->institution_name); ?><br>
                                    <small class="text-muted">
                                        <?php echo e(array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country]) ? implode(', ', array_filter([$aca->institution_address, $aca->city, $aca->zip_code, $aca->country])) : 'N/A'); ?>

                                    </small>
                                </td>
                                <td><?php echo e($aca->course_name); ?></td>
                                <td><?php echo e($aca->start_date ? $aca->start_date->format('M Y') : 'N/A'); ?> to <?php echo e($aca->end_date ? $aca->end_date->format('M Y') : 'N/A'); ?></td>
                                <td>
                                    <span class="badge bg-success">
                                        <?php echo e($aca->result_type == 'Others' ? $aca->other_result_type : $aca->result_type); ?>: <?php echo e($aca->result_percentage); ?><?php echo e($aca->result_out_of ? ' / ' . $aca->result_out_of : ''); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No academic history provided.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- English Test -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-language"></i> English Language Proficiency</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($englishTests->count() > 0): ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $englishTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($test->test_type); ?></td>
                                <td><?php echo e($test->test_date); ?></td>
                                <td><span class="badge bg-primary fs--1"><?php echo e($test->overall_score); ?></span></td>
                                <td>L: <?php echo e($test->listening_score); ?>, R: <?php echo e($test->reading_score); ?>, W: <?php echo e($test->writing_score); ?>, S: <?php echo e($test->speaking_score); ?></td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No English tests recorded.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Referees -->
            <div class="info-section bg-light">
                <div class="info-section-title"><i class="fas fa-users"></i> References</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($referees->count() > 0): ?>
                <div class="row g-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $referees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="col-md-6">
                        <div class="card shadow-none border h-100">
                            <div class="card-body p-3">
                                <h6 class="mb-1"><?php echo e($ref->name); ?> <small class="text-muted fw-normal">(<?php echo e($ref->type); ?>)</small></h6>
                                <p class="mb-1 small"><i class="fas fa-briefcase text-muted me-1"></i> <?php echo e($ref->designation); ?>, <?php echo e($ref->company_name); ?></p>
                                <p class="mb-1 small"><i class="fas fa-envelope text-muted me-1"></i> <?php echo e($ref->email); ?></p>
                                <p class="mb-0 small"><i class="fas fa-phone text-muted me-1"></i> <?php echo e($ref->phone); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No referees provided.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Documents -->
            <div class="info-section">
                <div class="info-section-title"><i class="fas fa-folder-open"></i> Uploaded Documents</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($documents->count() > 0): ?>
                <div class="list-group">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <div>
                            <i class="fas fa-file-pdf text-danger me-2 fs-2 align-middle"></i>
                            <strong><?php echo e($doc->document_type); ?></strong>
                            <div class="text-muted small mt-1">Uploaded: <?php echo e($doc->created_at->format('d M Y H:i')); ?></div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(Storage::url($doc->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="View Document">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="<?php echo e(Storage::url($doc->file_path)); ?>" class="btn btn-sm btn-outline-primary" download title="Download Document">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
                <?php else: ?>
                <p class="text-muted mb-0">No documents uploaded.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>
    
</div><div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3">Approval Status</h4>
                
                <div class="mb-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->isPending()): ?>
                        <div class="alert alert-warning border-0 rounded-0">
                            <strong>Status:</strong> Pending Review
                        </div>
                    <?php elseif($assessment->isApproved()): ?>
                        <div class="alert alert-success border-0 rounded-0">
                            <strong>Status:</strong> Approved
                            <p class="mb-0 mt-2 font-13">
                                By: <?php echo e($assessment->approvedBy->name ?? 'Admin'); ?><br>
                                Date: <?php echo e($assessment->approved_at->format('d M Y, h:i A')); ?>

                            </p>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->selected_form): ?>
                            <div class="mt-2 pt-2 border-top border-success">
                                <strong>Department:</strong> <span class="badge bg-success"><?php echo e($assessment->selected_form); ?></span>
                            </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->mandatory_documents && count($assessment->mandatory_documents) > 0): ?>
                                <?php
                                    $hasMandatory = false;
                                    $hasOptional = false;
                                    $mandatoryList = [];
                                    $optionalList = [];
                                    
                                    if (is_array($assessment->mandatory_documents)) {
                                        foreach ($assessment->mandatory_documents as $key => $val) {
                                            if (is_numeric($key)) {
                                                // Old style array, default to Mandatory
                                                $mandatoryList[] = $val;
                                                $hasMandatory = true;
                                            } else {
                                                // New style associative array
                                                if ($val === 'M') {
                                                    $mandatoryList[] = $key;
                                                    $hasMandatory = true;
                                                } elseif ($val === 'N') {
                                                    $optionalList[] = $key;
                                                    $hasOptional = true;
                                                }
                                            }
                                        }
                                    }
                                ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasMandatory): ?>
                                <div class="mt-2 pt-1">
                                    <strong>Mandatory Docs:</strong>
                                    <div class="mt-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $mandatoryList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <span class="badge bg-danger me-1"><?php echo e($doc); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hasOptional): ?>
                                <div class="mt-2 pt-1 border-top pt-2">
                                    <strong>Non-Mandatory Docs:</strong>
                                    <div class="mt-1">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $optionalList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <span class="badge bg-warning text-dark me-1"><?php echo e($doc); ?></span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$assessment->student || !$assessment->student->enrolment_status): ?>
                        <form action="<?php echo e(route('admin.pre.assessments.send_to_pre_enrolment', $assessment->id)); ?>" method="POST" class="mt-3">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary w-100" onclick="return confirm('Send this student to Pre-Enrolment?');">
                                <i class="mdi mdi-send"></i> Send to Pre-Enrolment
                            </button>
                        </form>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php elseif($assessment->isRejected()): ?>
                        <div class="alert alert-danger border-0 rounded-0">
                            <strong>Status:</strong> Rejected
                            <p class="mb-0 mt-2 font-13">
                                By: <?php echo e($assessment->approvedBy->name ?? 'Admin'); ?><br>
                                Date: <?php echo e($assessment->approved_at->format('d M Y, h:i A')); ?>

                            </p>
                        </div>
                        <div class="mt-2 p-2 bg-light border">
                            <strong class="font-13">Reason:</strong>
                            <p class="mb-0 font-13"><?php echo e($assessment->rejection_note); ?></p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($assessment->isPending()): ?>
                    <form action="<?php echo e(route('admin.pre.assessments.approve', $assessment->id)); ?>" method="POST" class="mb-3">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label font-13 fw-bold">Select Department <span class="text-danger">*</span></label>
                            <select name="selected_form" class="form-select form-select-sm" required>
                                <option value="">-- Choose Department --</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($dept); ?>"><?php echo e($dept); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3 border p-2 bg-light">
                            <label class="form-label font-13 fw-bold mb-2">Document Requirements</label>
                            <p class="font-12 text-muted mb-2">Select requirement status: <strong>M</strong> (Mandatory) or <strong>N</strong> (Non-Mandatory).</p>
                            
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $docOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td class="font-13 fw-semibold py-1 align-middle" style="width: 50%;"><?php echo e($docType); ?></td>
                                            <td class="py-1 align-middle">
                                                <div class="d-flex gap-3">
                                                    <div class="form-check form-check-inline mb-0">
                                                        <input class="form-check-input" type="checkbox" name="mandatory_documents[<?php echo e($docType); ?>]" value="M" id="doc_m_<?php echo e($loop->index); ?>" onclick="toggleDocRequirement(this, 'doc_n_<?php echo e($loop->index); ?>')">
                                                        <label class="form-check-label font-12 fw-bold text-danger" for="doc_m_<?php echo e($loop->index); ?>">M</label>
                                                    </div>
                                                    <div class="form-check form-check-inline mb-0">
                                                        <input class="form-check-input" type="checkbox" name="mandatory_documents[<?php echo e($docType); ?>]" value="N" id="doc_n_<?php echo e($loop->index); ?>" onclick="toggleDocRequirement(this, 'doc_m_<?php echo e($loop->index); ?>')">
                                                        <label class="form-check-label font-12 fw-bold text-warning" for="doc_n_<?php echo e($loop->index); ?>">N</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-2" onclick="return confirm('Are you sure you want to approve this student?')">
                            <i class="mdi mdi-check-all"></i> Approve Application
                        </button>
                    </form>

                    <hr>

                    <form action="<?php echo e(route('admin.pre.assessments.reject', $assessment->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-2">
                            <label for="rejection_note" class="form-label font-13 text-danger">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea name="rejection_note" id="rejection_note" class="form-control" rows="3" placeholder="Provide a reason for rejection..." required></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['rejection_note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <small class="text-danger"><?php echo e($message); ?></small>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('Are you sure you want to reject this student?')">
                            <i class="mdi mdi-close"></i> Reject Application
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div>
    <script>
    function toggleDocRequirement(current, pairId) {
        if (current.checked) {
            document.getElementById(pairId).checked = false;
        }
    }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\pre_assessment\show.blade.php ENDPATH**/ ?>
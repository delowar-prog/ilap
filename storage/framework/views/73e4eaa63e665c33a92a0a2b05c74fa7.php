<?php $__env->startSection('title', 'Pre-Assessment Form'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row justify-content-center">
    <div class="col-12 col-xl-11">
        


        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-white"><i class="mdi mdi-clipboard-text-outline me-1"></i> Student Pre-Assessment</h4>
                <p class="mb-0 font-13 mt-1 text-white-50">Please complete all required fields accurately. This information will be reviewed by our admissions team.</p>
            </div>
            
            <div class="card-body p-4">
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-alert-circle font-22 me-2"></i>
                            <div>
                                <h6 class="alert-heading mb-1 fw-bold">Form Submission Failed!</h6>
                                <p class="mb-1 font-13">Please correct the following errors and try submitting again:</p>
                            </div>
                        </div>
                        <hr class="my-2">
                        <ul class="mb-0 ps-3 font-13">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <li><?php echo e($error); ?></li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <form method="POST" action="<?php echo e(route('pre.assessment.update')); ?>" id="assessForm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-justified bg-light p-1 rounded mb-4" id="assessmentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                <span class="d-none d-sm-block">1. Personal Info</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(($assessment->exists ?? false) ? '' : 'disabled'); ?>" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                <span class="d-none d-sm-block">2. Academic Background</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?php echo e(($assessment->exists ?? false) ? '' : 'disabled'); ?>" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="mdi mdi-earth"></i></span>
                                <span class="d-none d-sm-block">3. Study Plan</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        
                        
                        <div class="tab-pane active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle me-1"></i> Personal Information</h5>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e(old('first_name', $assessment->first_name ?? $student->first_name)); ?>" placeholder="First Name" required />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="middle_name" class="form-label">Middle Name <small class="text-muted">(Optional)</small></label>
                                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="<?php echo e(old('middle_name', $assessment->middle_name ?? $student->middle_name)); ?>" placeholder="Middle Name" />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="surname" class="form-label">Surname / Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="surname" id="surname" value="<?php echo e(old('surname', $assessment->surname ?? $student->surname)); ?>" placeholder="Surname" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="contact_number" id="contact_number" value="<?php echo e(old('contact_number', $assessment->contact_number ?? $student->phone)); ?>" placeholder="+44 7700 900077" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address (Read Only)</label>
                                    <input type="email" class="form-control" value="<?php echo e($student->email); ?>" disabled />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <?php
                                        $dobValue = old('dob');
                                        if (!$dobValue) {
                                            $rawDob = $assessment->dob ?? $student->dob;
                                            if (!empty($rawDob)) {
                                                $dobValue = $rawDob instanceof \DateTimeInterface ? $rawDob->format('Y-m-d') : date('Y-m-d', strtotime($rawDob));
                                            }
                                        }
                                    ?>
                                    <input type="date" class="form-control" name="dob" id="dob" value="<?php echo e($dobValue); ?>" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="passport_number" class="form-label">Passport Number <small class="text-muted">(Optional)</small></label>
                                    <input type="text" class="form-control" name="passport_number" id="passport_number" value="<?php echo e(old('passport_number', $assessment->passport_number)); ?>" placeholder="e.g. A0123456" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">Select Gender...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Male','Female','Prefer not to say']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('gender', $assessment->gender ?? $student->gender) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nationality" class="form-label">Country of Nationality <span class="text-danger">*</span></label>
                                    <select class="form-select select2-tags" name="nationality" id="nationality" data-placeholder="Select or type country of nationality..." required>
                                        <option value=""></option>
                                        <?php
                                            $activeCountries = \App\Models\Country::where('status', 'active')->orderBy('name')->get();
                                            $natVal = old('nationality', $assessment->nationality ?? $student->nationality);
                                        ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($c->name); ?>" <?php echo e($natVal == $c->name ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($natVal && !$activeCountries->contains('name', $natVal)): ?>
                                            <option value="<?php echo e($natVal); ?>" selected><?php echo e($natVal); ?></option>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label mb-2">Full Contact Address <span class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="contact_address" class="form-label">Street Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="contact_address" id="contact_address" value="<?php echo e(old('contact_address', $assessment->contact_address)); ?>" placeholder="Street Address (e.g. 123 Main St, Apt 4B)" required />
                                        </div>
                                        <div class="col-md-12">
                                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('geo.location-selector', ['initialCountry' => old('country', $assessment->country ?? $student->country?->name),'initialState' => old('state', $assessment->state),'initialCity' => old('city', $assessment->city),'showPostCode' => true,'initialPostCode' => old('postal_code', $assessment->postal_code),'postCodeField' => 'postal_code','cityColClass' => 'col-md-6','stateColClass' => 'col-md-6','countryColClass' => 'col-md-6']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4153720639-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-primary next-step" data-next="#step2-tab">Next Step <i class="mdi mdi-arrow-right ms-1"></i></button>
                            </div>
                        </div>

                        
                        <div class="tab-pane" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-school me-1"></i> Academic Background</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <?php
                                        $currentQual = old('highest_qualification', $assessment->highest_qualification);
                                        $isOther = !empty($currentQual) && !in_array($currentQual, $qualificationOptions);
                                    ?>
                                    <label class="form-label">Highest Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select" name="highest_qualification" id="highest_qualification_select" required>
                                        <option value="">Select Qualification...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $qualificationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e($currentQual == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <option value="Other" <?php echo e((old('highest_qualification') == 'Other' || $isOther) ? 'selected' : ''); ?>>Other</option>
                                    </select>
                                    <div id="highest_qualification_other_div" class="mt-2" style="display: <?php echo e((old('highest_qualification') == 'Other' || $isOther) ? 'block' : 'none'); ?>;">
                                        <label for="highest_qualification_other" class="form-label font-12 text-muted mb-1">Please specify qualification <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="highest_qualification_other" id="highest_qualification_other" value="<?php echo e(old('highest_qualification_other', $isOther ? $currentQual : '')); ?>" placeholder="Enter your qualification" />
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name_of_institution" class="form-label">Name of Institution <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_of_institution" id="name_of_institution" value="<?php echo e(old('name_of_institution', $assessment->name_of_institution)); ?>" placeholder="e.g. Cardiff High School" required />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="year_of_passing" class="form-label">Year of Passing <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="year_of_passing" id="year_of_passing" value="<?php echo e(old('year_of_passing', $assessment->year_of_passing)); ?>" placeholder="e.g. 2022" required />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="grades_gpa" class="form-label">Grade / GPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="grades_gpa" id="grades_gpa" value="<?php echo e(old('grades_gpa', $assessment->grades_gpa)); ?>" placeholder="e.g. 3.8 / 4.0 or A,B,C" required />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="field_of_study" class="form-label">Field of Study</label>
                                    <input type="text" class="form-control" name="field_of_study" id="field_of_study" value="<?php echo e(old('field_of_study', $assessment->field_of_study)); ?>" placeholder="e.g. Computer Science" />
                                </div>

                                <?php
                                    $additionalQuals = old('additional_qualifications', $assessment->additional_qualifications);
                                    if (empty($additionalQuals)) {
                                        if (!empty($assessment->second_qualification)) {
                                            $additionalQuals = [
                                                [
                                                    'qualification' => $assessment->second_qualification,
                                                    'institution' => $assessment->second_institution,
                                                    'year_of_passing' => $assessment->second_year_of_passing,
                                                ]
                                            ];
                                        } else {
                                            $additionalQuals = [];
                                        }
                                    }
                                ?>

                                <div id="additional_qualifications_container" class="w-100 row p-0 m-0">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $additionalQuals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $qual): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <div class="row p-0 m-0 qualification-row mb-3" id="qualification_row_<?php echo e($index); ?>">
                                            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">Additional Educational Qualification</h6>
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQualificationRow(<?php echo e($index); ?>)">
                                                    <i class="mdi mdi-close me-1"></i> Remove
                                                </button>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="additional_qualifications_<?php echo e($index); ?>_qualification" class="form-label">Qualification Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[<?php echo e($index); ?>][qualification]" id="additional_qualifications_<?php echo e($index); ?>_qualification" value="<?php echo e(old('additional_qualifications.' . $index . '.qualification', $qual['qualification'] ?? '')); ?>" placeholder="e.g. GCSE / A-Level" required />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="additional_qualifications_<?php echo e($index); ?>_institution" class="form-label">Institution Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[<?php echo e($index); ?>][institution]" id="additional_qualifications_<?php echo e($index); ?>_institution" value="<?php echo e(old('additional_qualifications.' . $index . '.institution', $qual['institution'] ?? '')); ?>" placeholder="e.g. High School" required />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="additional_qualifications_<?php echo e($index); ?>_year" class="form-label">Year of Passing <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[<?php echo e($index); ?>][year_of_passing]" id="additional_qualifications_<?php echo e($index); ?>_year" value="<?php echo e(old('additional_qualifications.' . $index . '.year_of_passing', $qual['year_of_passing'] ?? '')); ?>" placeholder="e.g. 2020" required />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="additional_qualifications_<?php echo e($index); ?>_grades_gpa" class="form-label">Grade / GPA <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="additional_qualifications[<?php echo e($index); ?>][grades_gpa]" id="additional_qualifications_<?php echo e($index); ?>_grades_gpa" value="<?php echo e(old('additional_qualifications.' . $index . '.grades_gpa', $qual['grades_gpa'] ?? '')); ?>" placeholder="e.g. 3.8 / 4.0 or A,B,C" required />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="additional_qualifications_<?php echo e($index); ?>_field" class="form-label">Field of Study</label>
                                                <input type="text" class="form-control" name="additional_qualifications[<?php echo e($index); ?>][field_of_study]" id="additional_qualifications_<?php echo e($index); ?>_field" value="<?php echo e(old('additional_qualifications.' . $index . '.field_of_study', $qual['field_of_study'] ?? '')); ?>" placeholder="e.g. Computer Science" />
                                            </div>
                                            <div class="col-12"><hr class="mt-2 mb-4"></div>
                                        </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addQualificationRow()">
                                        <i class="mdi mdi-plus me-1"></i> Add More Educational Qualification
                                    </button>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">English Language Proficiency <span class="text-danger">*</span></label>
                                    <select class="form-select" name="english_proficiency" data-current-value="<?php echo e(old('english_proficiency', $assessment->english_proficiency)); ?>" required>
                                        <option value="">Select Proficiency...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $englishProficiencyOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('english_proficiency', $assessment->english_proficiency) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="english_score" class="form-label">English Test Score (if applicable)</label>
                                    <input type="text" class="form-control" name="english_score" id="english_score" value="<?php echo e(old('english_score', $assessment->english_score)); ?>" placeholder="e.g. IELTS 6.5 Overall" />
                                </div>


                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button type="button" class="btn btn-light prev-step" data-prev="#step1-tab"><i class="mdi mdi-arrow-left me-1"></i> Back</button>
                                <button type="button" class="btn btn-primary next-step" data-next="#step3-tab">Next Step <i class="mdi mdi-arrow-right ms-1"></i></button>
                            </div>
                        </div>

                        
                        <div class="tab-pane" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Study Plan</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Study Destination <span class="text-danger">*</span></label>
                                    <select class="form-select" name="study_destination" data-current-value="<?php echo e(old('study_destination', $assessment->study_destination)); ?>" required>
                                        <option value="">Select Destination...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $studyDestinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('study_destination', $assessment->study_destination) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Study Method <span class="text-danger">*</span></label>
                                    <select class="form-select" name="study_method" data-current-value="<?php echo e(old('study_method', $assessment->study_method)); ?>" required>
                                        <option value="">Select Method...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $studyMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('study_method', $assessment->study_method) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Level of Study <span class="text-danger">*</span></label>
                                    <select class="form-select" name="level_of_study" data-current-value="<?php echo e(old('level_of_study', $assessment->level_of_study)); ?>" required>
                                        <option value="">Select Level...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $levelOfStudyOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('level_of_study', $assessment->level_of_study) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="intended_course" class="form-label">Intended Course / Program of Study <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="intended_course" id="intended_course" value="<?php echo e(old('intended_course', $assessment->intended_course)); ?>" placeholder="e.g. BSc Computer Science" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="preferred_intake" class="form-label">Preferred Intake / Start Date <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="preferred_intake" id="preferred_intake" value="<?php echo e(old('preferred_intake', $assessment->preferred_intake)); ?>" placeholder="e.g. September 2026" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="course_link" class="form-label">Course URL / Link <small class="text-muted">(Optional)</small></label>
                                    <input type="url" class="form-control" name="course_link" id="course_link" value="<?php echo e(old('course_link', $assessment->course_link)); ?>" placeholder="https://university.ac.uk/..." />
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">How do you plan to fund your studies? <span class="text-danger">*</span></label>
                                    <select class="form-select" name="financial_source" data-current-value="<?php echo e(old('financial_source', $assessment->financial_source)); ?>" required>
                                        <option value="">Select Source...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $financialSourceOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('financial_source', $assessment->financial_source) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <h5 class="text-uppercase bg-light p-2"><i class="mdi mdi-plane me-1"></i> Travel History & Immigration</h5>
                                </div>

                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Has this student applied for permission to remain in any of the following countries in the past ten years? <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        <input type="radio" class="btn-check" name="travel_history[has_history]" id="travel_yes" value="yes" <?php echo e((old('travel_history.has_history', $assessment->travel_history['has_history'] ?? '') == 'yes') ? 'checked' : ''); ?> onclick="toggleTravelHistoryFields(true)">
                                        <label class="btn btn-outline-primary px-4" for="travel_yes">Yes</label>

                                        <input type="radio" class="btn-check" name="travel_history[has_history]" id="travel_no" value="no" <?php echo e((old('travel_history.has_history', $assessment->travel_history['has_history'] ?? 'no') == 'no') ? 'checked' : ''); ?> onclick="toggleTravelHistoryFields(false)">
                                        <label class="btn btn-outline-secondary px-4" for="travel_no">No</label>
                                    </div>
                                </div>

                                <div class="col-md-12" id="travel_history_fields" style="display: <?php echo e((old('travel_history.has_history', $assessment->travel_history['has_history'] ?? '') == 'yes') ? 'block' : 'none'); ?>;">
                                    <?php
                                        $travelData = old('travel_history', $assessment->travel_history ?? []);
                                        $travelEntries = $travelData['entries'] ?? [];
                                        if (empty($travelEntries) && ($travelData['has_history'] ?? '') === 'yes') {
                                            if (!empty($travelData['country']) || !empty($travelData['arrival_date'])) {
                                                $travelEntries = [
                                                    [
                                                        'arrival_date' => $travelData['arrival_date'] ?? '',
                                                        'departure_date' => $travelData['departure_date'] ?? '',
                                                        'visa_start_date' => $travelData['visa_start_date'] ?? '',
                                                        'visa_expiry_date' => $travelData['visa_expiry_date'] ?? '',
                                                        'purpose_of_visit' => $travelData['purpose_of_visit'] ?? '',
                                                        'country' => $travelData['country'] ?? '',
                                                        'visa_type' => $travelData['visa_type'] ?? '',
                                                    ]
                                                ];
                                            } else {
                                                $travelEntries = [[]];
                                            }
                                        }
                                    ?>

                                    <div id="travel_history_container">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $travelEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tIndex => $tEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="travel-row bg-light p-3 border rounded-3 mb-3" id="travel_row_<?php echo e($tIndex); ?>">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 fw-semibold text-primary"><i class="mdi mdi-plane-car me-1"></i> Travel Entry #<span class="travel-entry-num"><?php echo e($loop->iteration); ?></span></h6>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-travel-btn" onclick="removeTravelRow(<?php echo e($tIndex); ?>)" style="<?php echo e(count($travelEntries) > 1 ? '' : 'display:none;'); ?>">
                                                        <i class="mdi mdi-close me-1"></i> Remove
                                                    </button>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date of Arrival <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][arrival_date]" value="<?php echo e($tEntry['arrival_date'] ?? ''); ?>" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Date of Departure <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][departure_date]" value="<?php echo e($tEntry['departure_date'] ?? ''); ?>" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Visa Start Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][visa_start_date]" value="<?php echo e($tEntry['visa_start_date'] ?? ''); ?>" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Visa Expiry Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][visa_expiry_date]" value="<?php echo e($tEntry['visa_expiry_date'] ?? ''); ?>" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Purpose of Visit <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][purpose_of_visit]" value="<?php echo e($tEntry['purpose_of_visit'] ?? ''); ?>" placeholder="e.g. Tourism, Study, Work" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                                        <select class="form-select select2-tags" name="travel_history[entries][<?php echo e($tIndex); ?>][country]" data-placeholder="Select country" required>
                                                            <option value="">Select Country...</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Country::where('status', 'active')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                <option value="<?php echo e($c->name); ?>" <?php echo e(($tEntry['country'] ?? '') == $c->name ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($tEntry['country']) && !\App\Models\Country::where('name', $tEntry['country'])->exists()): ?>
                                                                <option value="<?php echo e($tEntry['country']); ?>" selected><?php echo e($tEntry['country']); ?></option>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="travel_history[entries][<?php echo e($tIndex); ?>][visa_type]" required>
                                                            <option value="">Select Visa Type...</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Tourist Visa','Student Visa','Work Visa','Business Visa','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                <option value="<?php echo e($vt); ?>" <?php echo e(($tEntry['visa_type'] ?? '') == $vt ? 'selected' : ''); ?>><?php echo e($vt); ?></option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="addTravelRow()">
                                            <i class="mdi mdi-plus me-1"></i> Add More Travel Entry
                                        </button>
                                    </div>
                                </div>

                                
                                <div class="col-md-12 mb-3">
                                    <div class="bg-light p-3 border rounded-3">
                                        <label class="form-label fw-bold">Does this student need a visa to stay in any of the following countries? Please tick all that apply. <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="immigration_history[countries][]" value="<?php echo e(old('study_destination', $assessment->study_destination ?? '')); ?>" id="imm_country_chk" onclick="toggleImmigrationNone(false)" <?php echo e((in_array(old('study_destination', $assessment->study_destination ?? ''), old('immigration_history.countries', $assessment->immigration_history['countries'] ?? []))) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="imm_country_chk" id="imm_country_label">
                                                    <?php echo e(old('study_destination', $assessment->study_destination ?? 'Selected Study Destination')); ?>

                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="immigration_history[countries][]" value="None" id="imm_none_chk" onclick="toggleImmigrationNone(true)" <?php echo e((in_array('None', old('immigration_history.countries', $assessment->immigration_history['countries'] ?? ['None']))) ? 'checked' : ''); ?>>
                                                <label class="form-check-label fw-semibold" for="imm_none_chk">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">For any country has this student ever been refused permission to stay or remain, refused asylum or deported? <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2">
                                        <input type="radio" class="btn-check" name="visa_refusals[has_refusal]" id="refusal_yes" value="yes" <?php echo e((old('visa_refusals.has_refusal', $assessment->visa_refusals['has_refusal'] ?? '') == 'yes') ? 'checked' : ''); ?> onclick="toggleVisaRefusalFields(true)">
                                        <label class="btn btn-outline-danger px-4" for="refusal_yes">Yes</label>

                                        <input type="radio" class="btn-check" name="visa_refusals[has_refusal]" id="refusal_no" value="no" <?php echo e((old('visa_refusals.has_refusal', $assessment->visa_refusals['has_refusal'] ?? 'no') == 'no') ? 'checked' : ''); ?> onclick="toggleVisaRefusalFields(false)">
                                        <label class="btn btn-outline-secondary px-4" for="refusal_no">No</label>
                                    </div>
                                </div>

                                <div class="col-md-12" id="visa_refusal_fields" style="display: <?php echo e((old('visa_refusals.has_refusal', $assessment->visa_refusals['has_refusal'] ?? '') == 'yes') ? 'block' : 'none'); ?>;">
                                    <?php
                                        $refusalData = old('visa_refusals', $assessment->visa_refusals ?? []);
                                        $refusalEntries = $refusalData['entries'] ?? [];
                                        if (empty($refusalEntries) && ($refusalData['has_refusal'] ?? '') === 'yes') {
                                            if (!empty($refusalData['country']) || !empty($refusalData['refusal_type'])) {
                                                $refusalEntries = [
                                                    [
                                                        'refusal_type' => $refusalData['refusal_type'] ?? '',
                                                        'refusal_date' => $refusalData['refusal_date'] ?? '',
                                                        'country' => $refusalData['country'] ?? '',
                                                        'visa_type' => $refusalData['visa_type'] ?? '',
                                                        'details' => $refusalData['details'] ?? '',
                                                    ]
                                                ];
                                            } else {
                                                $refusalEntries = [[]];
                                            }
                                        }
                                    ?>

                                    <div id="visa_refusals_container">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $refusalEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rIndex => $rEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <div class="refusal-row bg-light p-3 border rounded-3 mb-3" id="refusal_row_<?php echo e($rIndex); ?>">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 fw-semibold text-danger"><i class="mdi mdi-alert-circle me-1"></i> Refusal Entry #<span class="refusal-entry-num"><?php echo e($loop->iteration); ?></span></h6>
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-refusal-btn" onclick="removeRefusalRow(<?php echo e($rIndex); ?>)" style="<?php echo e(count($refusalEntries) > 1 ? '' : 'display:none;'); ?>">
                                                        <i class="mdi mdi-close me-1"></i> Remove
                                                    </button>
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Refusal Type <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="visa_refusals[entries][<?php echo e($rIndex); ?>][refusal_type]" required>
                                                            <option value="">Select Refusal Type...</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Visa Refusal','Refused Entry','Deported','Refused Leave to Remain','Refused Asylum']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                <option value="<?php echo e($rt); ?>" <?php echo e(($rEntry['refusal_type'] ?? '') == $rt ? 'selected' : ''); ?>><?php echo e($rt); ?></option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Date of Refusal <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" name="visa_refusals[entries][<?php echo e($rIndex); ?>][refusal_date]" value="<?php echo e($rEntry['refusal_date'] ?? ''); ?>" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                                        <select class="form-select select2-tags" name="visa_refusals[entries][<?php echo e($rIndex); ?>][country]" data-placeholder="Select country" required>
                                                            <option value="">Select Country...</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = \App\Models\Country::where('status', 'active')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                <option value="<?php echo e($c->name); ?>" <?php echo e(($rEntry['country'] ?? '') == $c->name ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rEntry['country']) && !\App\Models\Country::where('name', $rEntry['country'])->exists()): ?>
                                                                <option value="<?php echo e($rEntry['country']); ?>" selected><?php echo e($rEntry['country']); ?></option>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="visa_refusals[entries][<?php echo e($rIndex); ?>][visa_type]" required>
                                                            <option value="">Select Visa Type...</option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Tourist Visa','Student Visa','Work Visa','Business Visa','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                                <option value="<?php echo e($vt); ?>" <?php echo e(($rEntry['visa_type'] ?? '') == $vt ? 'selected' : ''); ?>><?php echo e($vt); ?></option>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label class="form-label">Details / Reason <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="visa_refusals[entries][<?php echo e($rIndex); ?>][details]" rows="2" placeholder="Provide details or reason for refusal..." required><?php echo e($rEntry['details'] ?? ''); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="addRefusalRow()">
                                            <i class="mdi mdi-plus me-1"></i> Add More Refusal Entry
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="purpose_of_study" class="form-label">Why do you want to study abroad? <small class="text-muted">(Optional)</small></label>
                                    <textarea class="form-control" name="purpose_of_study" id="purpose_of_study" rows="3" placeholder="Briefly describe your motivation..."><?php echo e(old('purpose_of_study', $assessment->purpose_of_study)); ?></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                <button type="button" class="btn btn-light prev-step" data-prev="#step2-tab"><i class="mdi mdi-arrow-left me-1"></i> Back</button>
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="mdi mdi-send me-1"></i> Submit Assessment
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    let qualificationIndex = <?php echo e(count($additionalQuals)); ?>;

    function addQualificationRow() {
        const container = document.getElementById('additional_qualifications_container');
        const rowHtml = `
            <div class="row p-0 m-0 qualification-row mb-3" id="qualification_row_${qualificationIndex}">
                <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Additional Educational Qualification</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQualificationRow(${qualificationIndex})">
                        <i class="mdi mdi-close me-1"></i> Remove
                    </button>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_qualification" class="form-label">Qualification Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][qualification]" id="additional_qualifications_${qualificationIndex}_qualification" placeholder="e.g. GCSE / A-Level" required />
                </div>
                <div class="col-md-6 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_institution" class="form-label">Institution Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][institution]" id="additional_qualifications_${qualificationIndex}_institution" placeholder="e.g. High School" required />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_year" class="form-label">Year of Passing <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][year_of_passing]" id="additional_qualifications_${qualificationIndex}_year" placeholder="e.g. 2020" required />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_grades_gpa" class="form-label">Grade / GPA <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][grades_gpa]" id="additional_qualifications_${qualificationIndex}_grades_gpa" placeholder="e.g. 3.8 / 4.0 or A,B,C" required />
                </div>
                <div class="col-md-4 mb-3">
                    <label for="additional_qualifications_${qualificationIndex}_field" class="form-label">Field of Study</label>
                    <input type="text" class="form-control" name="additional_qualifications[${qualificationIndex}][field_of_study]" id="additional_qualifications_${qualificationIndex}_field" placeholder="e.g. Computer Science" />
                </div>
                <div class="col-12"><hr class="mt-2 mb-4"></div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);
        
        // Re-attach change event listener to new inputs to clear invalid class if needed
        const newInputs = document.querySelectorAll(`#qualification_row_${qualificationIndex} input`);
        newInputs.forEach(input => {
            input.addEventListener('change', function() {
                if(this.value) this.classList.remove('is-invalid');
            });
        });

        qualificationIndex++;
    }

    function removeQualificationRow(index) {
        const row = document.getElementById(`qualification_row_${index}`);
        if (row) {
            row.remove();
        }
    }

    let travelIndex = <?php echo e(count($travelEntries)); ?>;
    let refusalIndex = <?php echo e(count($refusalEntries)); ?>;
    const activeCountriesList = <?php echo json_encode(\App\Models\Country::where('status', 'active')->orderBy('name')->pluck('name')->toArray(), 512) ?>;

    function addTravelRow() {
        const container = document.getElementById('travel_history_container');
        if (!container) return;
        let countryOptions = '<option value="">Select Country...</option>';
        activeCountriesList.forEach(c => {
            countryOptions += `<option value="${c}">${c}</option>`;
        });

        const rowHtml = `
            <div class="travel-row bg-light p-3 border rounded-3 mb-3" id="travel_row_${travelIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 fw-semibold text-primary"><i class="mdi mdi-plane-car me-1"></i> Travel Entry #<span class="travel-entry-num">1</span></h6>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-travel-btn" onclick="removeTravelRow(${travelIndex})">
                        <i class="mdi mdi-close me-1"></i> Remove
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Date of Arrival <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="travel_history[entries][${travelIndex}][arrival_date]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date of Departure <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="travel_history[entries][${travelIndex}][departure_date]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Visa Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="travel_history[entries][${travelIndex}][visa_start_date]" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Visa Expiry Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="travel_history[entries][${travelIndex}][visa_expiry_date]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Purpose of Visit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="travel_history[entries][${travelIndex}][purpose_of_visit]" placeholder="e.g. Tourism, Study, Work" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select select2-tags" name="travel_history[entries][${travelIndex}][country]" data-placeholder="Select country" required>
                            ${countryOptions}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="travel_history[entries][${travelIndex}][visa_type]" required>
                            <option value="">Select Visa Type...</option>
                            <option value="Tourist Visa">Tourist Visa</option>
                            <option value="Student Visa">Student Visa</option>
                            <option value="Work Visa">Work Visa</option>
                            <option value="Business Visa">Business Visa</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);

        $(`#travel_row_${travelIndex} .select2-tags`).select2({
            tags: true,
            placeholder: "Select country",
            allowClear: true,
            width: '100%'
        });

        travelIndex++;
        updateTravelRowNumbers();
    }

    function removeTravelRow(index) {
        const row = document.getElementById(`travel_row_${index}`);
        if (row) {
            row.remove();
            updateTravelRowNumbers();
        }
    }

    function updateTravelRowNumbers() {
        const rows = document.querySelectorAll('.travel-row');
        rows.forEach((row, i) => {
            const numSpan = row.querySelector('.travel-entry-num');
            if (numSpan) numSpan.textContent = i + 1;
            const removeBtn = row.querySelector('.remove-travel-btn');
            if (removeBtn) {
                removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
            }
        });
    }

    function addRefusalRow() {
        const container = document.getElementById('visa_refusals_container');
        if (!container) return;
        let countryOptions = '<option value="">Select Country...</option>';
        activeCountriesList.forEach(c => {
            countryOptions += `<option value="${c}">${c}</option>`;
        });

        const rowHtml = `
            <div class="refusal-row bg-light p-3 border rounded-3 mb-3" id="refusal_row_${refusalIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 fw-semibold text-danger"><i class="mdi mdi-alert-circle me-1"></i> Refusal Entry #<span class="refusal-entry-num">1</span></h6>
                    <button type="button" class="btn btn-outline-danger btn-sm remove-refusal-btn" onclick="removeRefusalRow(${refusalIndex})">
                        <i class="mdi mdi-close me-1"></i> Remove
                    </button>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Refusal Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="visa_refusals[entries][${refusalIndex}][refusal_type]" required>
                            <option value="">Select Refusal Type...</option>
                            <option value="Visa Refusal">Visa Refusal</option>
                            <option value="Refused Entry">Refused Entry</option>
                            <option value="Deported">Deported</option>
                            <option value="Refused Leave to Remain">Refused Leave to Remain</option>
                            <option value="Refused Asylum">Refused Asylum</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date of Refusal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="visa_refusals[entries][${refusalIndex}][refusal_date]" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select select2-tags" name="visa_refusals[entries][${refusalIndex}][country]" data-placeholder="Select country" required>
                            ${countryOptions}
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Visa Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="visa_refusals[entries][${refusalIndex}][visa_type]" required>
                            <option value="">Select Visa Type...</option>
                            <option value="Tourist Visa">Tourist Visa</option>
                            <option value="Student Visa">Student Visa</option>
                            <option value="Work Visa">Work Visa</option>
                            <option value="Business Visa">Business Visa</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Details / Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="visa_refusals[entries][${refusalIndex}][details]" rows="2" placeholder="Provide details or reason for refusal..." required></textarea>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', rowHtml);

        $(`#refusal_row_${refusalIndex} .select2-tags`).select2({
            tags: true,
            placeholder: "Select country",
            allowClear: true,
            width: '100%'
        });

        refusalIndex++;
        updateRefusalRowNumbers();
    }

    function removeRefusalRow(index) {
        const row = document.getElementById(`refusal_row_${index}`);
        if (row) {
            row.remove();
            updateRefusalRowNumbers();
        }
    }

    function updateRefusalRowNumbers() {
        const rows = document.querySelectorAll('.refusal-row');
        rows.forEach((row, i) => {
            const numSpan = row.querySelector('.refusal-entry-num');
            if (numSpan) numSpan.textContent = i + 1;
            const removeBtn = row.querySelector('.remove-refusal-btn');
            if (removeBtn) {
                removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
            }
        });
    }

    function toggleTravelHistoryFields(show) {
        const fieldsDiv = document.getElementById('travel_history_fields');
        fieldsDiv.style.display = show ? 'block' : 'none';
        const container = document.getElementById('travel_history_container');
        
        if (show && container && container.children.length === 0) {
            addTravelRow();
        }
        
        const inputs = fieldsDiv.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (show) {
                input.setAttribute('required', 'required');
            } else {
                input.removeAttribute('required');
                input.value = '';
                input.classList.remove('is-invalid');
            }
        });
    }

    function toggleVisaRefusalFields(show) {
        const fieldsDiv = document.getElementById('visa_refusal_fields');
        fieldsDiv.style.display = show ? 'block' : 'none';
        const container = document.getElementById('visa_refusals_container');

        if (show && container && container.children.length === 0) {
            addRefusalRow();
        }
        
        const inputs = fieldsDiv.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (show) {
                input.setAttribute('required', 'required');
            } else {
                input.removeAttribute('required');
                input.value = '';
                input.classList.remove('is-invalid');
            }
        });
    }

    const immCountryChk = document.getElementById('imm_country_chk');
    function toggleImmigrationNone(isNoneChecked) {
        if (isNoneChecked) {
            if (immCountryChk) immCountryChk.checked = false;
        } else {
            const noneChk = document.getElementById('imm_none_chk');
            if (noneChk) noneChk.checked = false;
        }
    }

    function toggleHighestQualificationOther() {
        const select = document.getElementById('highest_qualification_select');
        const otherDiv = document.getElementById('highest_qualification_other_div');
        const otherInput = document.getElementById('highest_qualification_other');
        
        if (select && select.value === 'Other') {
            otherDiv.style.display = 'block';
            otherInput.setAttribute('required', 'required');
        } else if (otherDiv) {
            otherDiv.style.display = 'none';
            otherInput.removeAttribute('required');
            otherInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initial sync for travel and visa refusal required attributes
        const travelYes = document.getElementById('travel_yes');
        if (travelYes) {
            toggleTravelHistoryFields(travelYes.checked);
        }
        const refusalYes = document.getElementById('refusal_yes');
        if (refusalYes) {
            toggleVisaRefusalFields(refusalYes.checked);
        }

        // Toggle highest qualification other on load and change
        const highestQualSelect = document.getElementById('highest_qualification_select');
        if (highestQualSelect) {
            highestQualSelect.addEventListener('change', toggleHighestQualificationOther);
            toggleHighestQualificationOther();
        }

        // Travel History & Immigration setup
        const studyDestSelect = document.querySelector('select[name="study_destination"]');
        const immCountryLabel = document.getElementById('imm_country_label');
        const immCountryChk = document.getElementById('imm_country_chk');

        function updateImmigrationCheckboxes() {
            if (!studyDestSelect) return;
            const val = studyDestSelect.value;
            if (val) {
                if (immCountryLabel) immCountryLabel.textContent = val;
                if (immCountryChk) {
                    immCountryChk.value = val;
                    immCountryChk.closest('.form-check').style.display = 'block';
                }
            } else {
                if (immCountryLabel) immCountryLabel.textContent = 'Selected Study Destination';
                if (immCountryChk) {
                    immCountryChk.value = '';
                    immCountryChk.closest('.form-check').style.display = 'none';
                }
            }
        }

        if (studyDestSelect) {
            studyDestSelect.addEventListener('change', updateImmigrationCheckboxes);
            updateImmigrationCheckboxes();
        }

        // Next Button Click
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-next');
                const targetTab = document.querySelector(targetId);
                
                // Basic HTML5 validation before moving next
                const currentPane = this.closest('.tab-pane');
                let isValid = true;
                currentPane.querySelectorAll('[required]').forEach(input => {
                    if (input.offsetParent === null) {
                        return;
                    }
                    if(!input.value) {
                        isValid = false;
                        input.classList.add('is-invalid');
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if(isValid) {
                    targetTab.classList.remove('disabled');
                    var tab = new bootstrap.Tab(targetTab);
                    tab.show();
                    window.scrollTo({top: 0, behavior: 'smooth'});
                }
            });
        });

        // Prev Button Click
        document.querySelectorAll('.prev-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-prev');
                const targetTab = document.querySelector(targetId);
                var tab = new bootstrap.Tab(targetTab);
                tab.show();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        });

        // Remove invalid class on change
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', function() {
                if(this.value) this.classList.remove('is-invalid');
            });
        });

        // Submit smart validation & loading state
        const assessForm = document.getElementById('assessForm');
        if (assessForm) {
            assessForm.addEventListener('submit', function(e) {
                let isValid = true;
                let firstInvalidInput = null;
                let invalidPaneId = null;

                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.querySelectorAll('input[required], select[required], textarea[required]').forEach(input => {
                        if (input.closest('#travel_history_fields[style*="display: none"]') || 
                            input.closest('#visa_refusal_fields[style*="display: none"]') ||
                            input.closest('#highest_qualification_other_div[style*="display: none"]')) {
                            return;
                        }

                        if (!input.value || input.value.trim() === '') {
                            isValid = false;
                            input.classList.add('is-invalid');
                            if (!firstInvalidInput) {
                                firstInvalidInput = input;
                                invalidPaneId = '#' + pane.id;
                            }
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });
                });

                if (!isValid) {
                    e.preventDefault();
                    e.stopPropagation();

                    const btn = document.getElementById('submitBtn');
                    if (btn) {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="mdi mdi-send me-1"></i> Submit Assessment';
                    }

                    if (invalidPaneId) {
                        const tabBtn = document.querySelector(`[data-bs-target="${invalidPaneId}"]`);
                        if (tabBtn) {
                            tabBtn.classList.remove('disabled');
                            var tab = new bootstrap.Tab(tabBtn);
                            tab.show();
                            setTimeout(() => {
                                if (firstInvalidInput) {
                                    firstInvalidInput.focus();
                                    firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            }, 200);
                        }
                    }
                    return false;
                }

                const btn = document.getElementById('submitBtn');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Submitting...';
                }
            });
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-tags').each(function() {
            const el = $(this);
            el.select2({
                tags: true,
                placeholder: el.attr('data-placeholder') || "Select from dropdown or type to add if not found...",
                allowClear: true,
                width: '100%'
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        padding-left: 12px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\student\pre_assessment_form.blade.php ENDPATH**/ ?>
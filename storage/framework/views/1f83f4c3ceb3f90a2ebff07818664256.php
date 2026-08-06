<?php $__env->startSection('title', 'Pre-Assessment Form'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row justify-content-center">
    <div class="col-12 col-xl-11">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success border-0 rounded-0 mt-3">
                <i class="mdi mdi-check-circle me-1"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger border-0 rounded-0 mt-3">
                <ul class="mb-0 ps-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($e); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-white"><i class="mdi mdi-clipboard-text-outline me-1"></i> Student Pre-Assessment</h4>
                <p class="mb-0 font-13 mt-1 text-white-50">Please complete all required fields accurately. This information will be reviewed by our admissions team.</p>
            </div>
            
            <div class="card-body p-4">
                
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
                            <button class="nav-link disabled" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="mdi mdi-school"></i></span>
                                <span class="d-none d-sm-block">2. Academic Background</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link disabled" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">
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
                                <div class="col-md-12 mb-3">
                                    <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo e(old('full_name', $assessment->full_name ?? $student->first_name . ' ' . $student->surname)); ?>" placeholder="As it appears on your passport" required />
                                    <small class="form-text text-muted">Please provide your full legal name.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="contact_number" id="contact_number" value="<?php echo e(old('contact_number', $assessment->contact_number ?? $student->phone)); ?>" placeholder="+880 1XXX XXXXXX" required />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email Address (Read Only)</label>
                                    <input type="email" class="form-control" value="<?php echo e($student->email); ?>" disabled />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" id="dob" value="<?php echo e(old('dob', optional($assessment->dob ?? $student->dob)->format('Y-m-d'))); ?>" required />
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
                                    <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nationality" id="nationality" value="<?php echo e(old('nationality', $assessment->nationality ?? $student->nationality)); ?>" placeholder="e.g. Bangladeshi" required />
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label class="form-label mb-2">Full Contact Address <span class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="contact_address" id="contact_address" value="<?php echo e(old('contact_address', $assessment->contact_address)); ?>" placeholder="Street Address (e.g. 123 Main St, Apt 4B)" required />
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="city" id="city" value="<?php echo e(old('city', $assessment->city)); ?>" placeholder="City" required />
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="state" id="state" value="<?php echo e(old('state', $assessment->state)); ?>" placeholder="State / Province" required />
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="postal_code" id="postal_code" value="<?php echo e(old('postal_code', $assessment->postal_code)); ?>" placeholder="Postal / Zip Code" required />
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="country" id="country" value="<?php echo e(old('country', $assessment->country)); ?>" placeholder="Country" required />
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
                                    <label class="form-label">Highest Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select" name="highest_qualification" required>
                                        <option value="">Select Qualification...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['GCSE / O-Level','A-Level / Higher Secondary','Foundation / Access Course','Higher National Diploma (HND)','Bachelor\'s Degree','Master\'s Degree','PhD / Doctorate','Professional Qualification','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('highest_qualification', $assessment->highest_qualification) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="name_of_institution" class="form-label">Name of Institution / College <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_of_institution" id="name_of_institution" value="<?php echo e(old('name_of_institution', $assessment->name_of_institution)); ?>" placeholder="e.g. Dhaka College" required />
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

                                <hr class="mt-2 mb-4">
                                <h6 class="mb-3">Second Educational Qualification <small class="text-muted">(Optional)</small></h6>

                                <div class="col-md-4 mb-3">
                                    <label for="second_qualification" class="form-label">Qualification Name</label>
                                    <input type="text" class="form-control" name="second_qualification" id="second_qualification" value="<?php echo e(old('second_qualification', $assessment->second_qualification)); ?>" placeholder="e.g. SSC / O-Level" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="second_institution" class="form-label">Institution Name</label>
                                    <input type="text" class="form-control" name="second_institution" id="second_institution" value="<?php echo e(old('second_institution', $assessment->second_institution)); ?>" placeholder="e.g. High School" />
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="second_year_of_passing" class="form-label">Year of Passing</label>
                                    <input type="text" class="form-control" name="second_year_of_passing" id="second_year_of_passing" value="<?php echo e(old('second_year_of_passing', $assessment->second_year_of_passing)); ?>" placeholder="e.g. 2020" />
                                </div>

                                <hr class="mt-2 mb-4">

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">English Language Proficiency <span class="text-danger">*</span></label>
                                    <select class="form-select" name="english_proficiency" required>
                                        <option value="">Select Proficiency...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['English is my native language','IELTS','TOEFL','PTE Academic','Duolingo English Test','Other English Qualification','No English qualification yet']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('english_proficiency', $assessment->english_proficiency) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="english_score" class="form-label">English Test Score (if applicable)</label>
                                    <input type="text" class="form-control" name="english_score" id="english_score" value="<?php echo e(old('english_score', $assessment->english_score)); ?>" placeholder="e.g. IELTS 6.5 Overall" />
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="work_experience" class="form-label">Work Experience <small class="text-muted">(If any - Job Title, Company, Duration)</small></label>
                                    <textarea class="form-control" name="work_experience" id="work_experience" rows="2" placeholder="e.g. Software Engineer, XYZ Corp, Jan 2023 - Present"><?php echo e(old('work_experience', $assessment->work_experience)); ?></textarea>
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
                                    <select class="form-select" name="study_destination" required>
                                        <option value="">Select Destination...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['United Kingdom (UK)','United States (USA)','Canada','Australia','New Zealand','Republic of Ireland','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('study_destination', $assessment->study_destination) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Study Method <span class="text-danger">*</span></label>
                                    <select class="form-select" name="study_method" required>
                                        <option value="">Select Method...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Full-time (On Campus)','Part-time (On Campus)','Online / Distance Learning','Blended (Online + On Campus)']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('study_method', $assessment->study_method) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Level of Study <span class="text-danger">*</span></label>
                                    <select class="form-select" name="level_of_study" required>
                                        <option value="">Select Level...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Foundation / Access','Higher National Certificate (HNC)','Higher National Diploma (HND)','Bachelor\'s Degree (Undergraduate)','Postgraduate Certificate','Master\'s Degree','PhD / Doctorate','Short Course / Professional Training']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
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
                                    <select class="form-select" name="financial_source" required>
                                        <option value="">Select Source...</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Self-funded (Personal Savings)','Family / Sponsor','Bank Loan','Government / Public Funding','Scholarship','Employer Sponsorship','Combination of the above']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($opt); ?>" <?php echo e(old('financial_source', $assessment->financial_source) == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="visa_refusal_history" class="form-label">Any Visa Refusal History? <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="visa_refusal_history" id="visa_refusal_history" rows="2" placeholder="If yes, which country and why? If no, write 'None'." required><?php echo e(old('visa_refusal_history', $assessment->visa_refusal_history)); ?></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="previous_uk_study_history" class="form-label">Previous UK study history? <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="previous_uk_study_history" id="previous_uk_study_history" rows="2" placeholder="If yes, specify details. If no, write 'None'." required><?php echo e(old('previous_uk_study_history', $assessment->previous_uk_study_history)); ?></textarea>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Next Button Click
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-next');
                const targetTab = document.querySelector(targetId);
                
                // Basic HTML5 validation before moving next
                const currentPane = this.closest('.tab-pane');
                let isValid = true;
                currentPane.querySelectorAll('[required]').forEach(input => {
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

        // Submit loading state
        document.getElementById('assessForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Submitting...';
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/student/pre_assessment_form.blade.php ENDPATH**/ ?>
<?php $__env->startSection('admin_contents'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Create Course</h5>
        <a href="<?php echo e(route('courses.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?php echo e(route('courses.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="card-body">
            
            
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Course Type:</strong> Select whether this is an iLAP own course or from an external institute.
            </div>

            <div class="row g-3">
                
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Course Ownership <span class="text-danger">*</span></label>
                    <select name="is_ilap_course" id="is_ilap_course" 
                            class="form-select <?php $__errorArgs = ['is_ilap_course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="1" <?php echo e(old('is_ilap_course') == '1' ? 'selected' : ''); ?>>
                            🏠 iLAP Own Course
                        </option>
                        <option value="0" <?php echo e(old('is_ilap_course') == '0' ? 'selected' : ''); ?>>
                            🏫 External Institute Course
                        </option>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['is_ilap_course'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="col-md-6" id="partner_institute_div">
                    <label class="form-label fw-semibold" id="institute_label_text">Partner Institute <span class="text-danger" id="partner_asterisk">*</span></label>
                    <select name="partner_institute" id="partner_institute_input"
                            class="form-select select2-tags partner-select2 <?php $__errorArgs = ['partner_institute'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Select or type an institute</option>
                        
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['partner_institute'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-md-6" id="institute_country_div">
                    <label class="form-label">Institute Country</label>
                    <input type="text" name="institute_country" id="institute_country_input"
                           class="form-control <?php $__errorArgs = ['institute_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('institute_country')); ?>" 
                           placeholder="e.g., United Kingdom">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['institute_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-md-6" id="institute_website_div">
                    <label class="form-label">Institute Website</label>
                    <input type="url" name="institute_website" id="institute_website_input"
                           class="form-control <?php $__errorArgs = ['institute_website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('institute_website')); ?>" 
                           placeholder="https://www.ox.ac.uk">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['institute_website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">📚 Course Details</h6></div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Course Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('name')); ?>" required>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Course Code</label>
                    <input type="text" name="course_code" 
                           class="form-control <?php $__errorArgs = ['course_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('course_code')); ?>" 
                           placeholder="Auto-generated if empty">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['course_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              rows="3"><?php echo e(old('description')); ?></textarea>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-12 mt-4"><hr><h6 class="fw-bold">📚 Course Modules</h6></div>
                <div class="col-12">
                    <div id="course_modules_container">
                        <div class="row g-2 mb-2 align-items-center module-row">
                            <div class="col-md-2">
                                <label class="form-label mb-0">Code</label>
                                <input type="text" name="modules[0][code]" class="form-control form-control-sm" placeholder="Module Code">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0">Title</label>
                                <input type="text" name="modules[0][title]" class="form-control form-control-sm" placeholder="Module Title">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label mb-0">Credit</label>
                                <input type="text" name="modules[0][credit]" class="form-control form-control-sm" placeholder="Credit">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label mb-0" title="Guided Learning Hours">GLH</label>
                                <input type="text" name="modules[0][glh]" class="form-control form-control-sm" placeholder="GLH">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0">Type</label><br>
                                <div class="form-check form-check-inline mt-1" title="Mandatory">
                                    <input class="form-check-input" type="radio" name="modules[0][is_mandatory]" id="mand_0" value="1" checked>
                                    <label class="form-check-label" for="mand_0">M</label>
                                </div>
                                <div class="form-check form-check-inline mt-1" title="Optional">
                                    <input class="form-check-input" type="radio" name="modules[0][is_mandatory]" id="opt_0" value="0">
                                    <label class="form-check-label" for="opt_0">O</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label mb-0">Priority</label>
                                <input type="number" name="modules[0][priority]" class="form-control form-control-sm" placeholder="Priority" value="0">
                            </div>
                            <div class="col-md-1 text-center">
                                <label class="form-label mb-0 d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm remove-module-btn"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add_more_module_btn" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Add More Module</button>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="">-- Select --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($cat); ?>" <?php echo e(old('category') == $cat ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst($cat)); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select">
                        <option value="">-- Select --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($lvl); ?>" <?php echo e(old('level') == $lvl ? 'selected' : ''); ?>>
                                <?php echo e(ucfirst(str_replace('_', ' ', $lvl))); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Subject Area</label>
                    <input type="text" name="subject_area" class="form-control" 
                           value="<?php echo e(old('subject_area')); ?>" placeholder="e.g., Business, IT">
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">⏱️ Duration & Mode</h6></div>

                <div class="col-md-4">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" 
                           value="<?php echo e(old('duration')); ?>" placeholder="e.g., 1 year, 6 months">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Duration (Months)</label>
                    <input type="number" name="duration_months" class="form-control" 
                           value="<?php echo e(old('duration_months')); ?>" min="1">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Study Method</label>
                    <select name="study_method" class="form-select">
                        <option value="">-- Select --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $studyMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($method); ?>" <?php echo e(old('study_method') == $method ? 'selected' : ''); ?>>
                                <?php echo e($method); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">💰 Fees</h6></div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Course Fee <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="fee" 
                           class="form-control <?php $__errorArgs = ['fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('fee', 0)); ?>" required>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Currency <span class="text-danger">*</span></label>
                    <select name="currency" class="form-select" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($cur); ?>" <?php echo e(old('currency') == $cur ? 'selected' : ''); ?>>
                                <?php echo e($cur); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Application Fee</label>
                    <input type="number" step="0.01" name="application_fee" 
                           class="form-control" value="<?php echo e(old('application_fee')); ?>">
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">📅 Intake & Requirements</h6></div>

                <div class="col-md-4">
                    <label class="form-label">Intake</label>
                    <select name="intake" class="form-select">
                        <option value="">-- Select --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $intakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $intake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($intake); ?>" <?php echo e(old('intake') == $intake ? 'selected' : ''); ?>>
                                <?php echo e($intake); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="application_deadline" class="form-control" 
                           value="<?php echo e(old('application_deadline')); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Course Start Date</label>
                    <input type="date" name="start_date" class="form-control" 
                           value="<?php echo e(old('start_date')); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Course End Date</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="<?php echo e(old('end_date')); ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">English Test Required</label>
                    <select name="english_test" class="form-select">
                        <option value="">Select English Test</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $englishTests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($test); ?>" <?php echo e(old('english_test') == $test ? 'selected' : ''); ?>>
                                <?php echo e($test); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Score</label>
                    <input type="text" name="english_test_score" class="form-control" 
                           value="<?php echo e(old('english_test_score')); ?>" placeholder="e.g., 6.5 or 100">
                </div>

                <div class="col-12">
                    <label class="form-label">Entry Requirements</label>
                    <textarea name="entry_requirements" class="form-control" rows="2"><?php echo e(old('entry_requirements')); ?></textarea>
                </div>

                <div class="col-12"><hr><h6 class="fw-bold">📁 Media & Visibility</h6></div>

                <div class="col-md-6">
                    <label class="form-label">Thumbnail Image</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                </div>

                <div class="col-md-12 mt-3">
                    <label class="form-label fw-bold">Course Brochures</label>
                    <div id="course_brochures_container">
                        <div class="row g-2 mb-2 align-items-center brochure-row">
                            <div class="col-md-5">
                                <label class="form-label mb-0">Brochure Title</label>
                                <input type="text" name="brochures[0][title]" class="form-control form-control-sm" placeholder="e.g. Course Syllabus">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label mb-0">Upload PDF</label>
                                <input type="file" name="brochures[0][file]" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                            </div>
                            <div class="col-md-1 text-center">
                                <label class="form-label mb-0 d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm remove-brochure-btn"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add_more_brochure_btn" class="btn btn-success btn-sm mt-2"><i class="fas fa-plus"></i> Add More Brochure</button>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" 
                           value="<?php echo e(old('sort_order', 0)); ?>">
                </div>

                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <input type="checkbox" name="is_featured" value="1" 
                               class="form-check-input" id="is_featured"
                               <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_featured">
                            Featured Course
                        </label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check form-switch mt-4">
                        <input type="checkbox" name="is_available_for_admission" value="1" 
                               class="form-check-input" id="is_available" checked
                               <?php echo e(old('is_available_for_admission', true) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_available">
                            Available for Admission
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Course
            </button>
        </div>
    </form>
</div>

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

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    const courseType = document.getElementById('is_ilap_course');
    const partnerDiv = document.getElementById('partner_institute_div');
    const countryDiv = document.getElementById('institute_country_div');
    const websiteDiv = document.getElementById('institute_website_div');

    const partnerInstitutes = <?php echo json_encode($partnerInstitutes, 15, 512) ?>;
    const ilapInstitutes = <?php echo json_encode($ilapInstitutes, 15, 512) ?>;
    const partnerInput = $('#partner_institute_input');
    const countryInput = document.getElementById('institute_country_input');
    const websiteInput = document.getElementById('institute_website_input');
    const instituteLabel = document.getElementById('institute_label_text');
    const oldInstitute = "<?php echo e(old('partner_institute')); ?>";

    function togglePartnerFields() {
        const isExternal = courseType.value === '0';
        
        // Update label
        if (isExternal) {
            instituteLabel.innerHTML = 'Partner Institute <span class="text-danger" id="partner_asterisk">*</span>';
        } else {
            instituteLabel.innerHTML = 'iLAP Institute <span class="text-danger" id="partner_asterisk">*</span>';
        }

        // Destroy select2 if initialized
        if (partnerInput.hasClass("select2-hidden-accessible")) {
            partnerInput.select2('destroy');
        }

        // Repopulate options
        partnerInput.empty();
        partnerInput.append(new Option("", "", false, false));
        
        const list = isExternal ? partnerInstitutes : ilapInstitutes;
        list.forEach(inst => {
            const instName = inst.name || inst.label;
            const isSelected = (instName === oldInstitute);
            partnerInput.append(new Option(instName, instName, isSelected, isSelected));
        });

        if (oldInstitute && !list.find(i => (i.name || i.label) === oldInstitute)) {
            partnerInput.append(new Option(oldInstitute, oldInstitute, true, true));
        }

        // Re-initialize select2
        if($.fn.select2) {
            partnerInput.select2({
                tags: true,
                placeholder: "Select or type an institute",
                allowClear: true,
                width: '100%'
            });
        }

        // Always require it now, since both need an institute
        document.getElementById('partner_institute_input').setAttribute('required', 'required');
    }

    courseType.addEventListener('change', togglePartnerFields);
    togglePartnerFields(); // Call on load

    partnerInput.on('change', function() {
        const selectedVal = $(this).val();
        const isExternal = courseType.value === '0';
        const list = isExternal ? partnerInstitutes : ilapInstitutes;
        
        const match = list.find(i => (i.name || i.label) === selectedVal);
        if (match) {
            countryInput.value = match.country || '';
            websiteInput.value = match.website || '';
        } else {
            countryInput.value = '';
            websiteInput.value = '';
        }
    });

    // Module dynamic rows
    let moduleIndex = 1;
    document.getElementById('add_more_module_btn').addEventListener('click', function() {
        const container = document.getElementById('course_modules_container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center module-row mt-2';
        row.innerHTML = `
            <div class="col-md-2">
                <input type="text" name="modules[${moduleIndex}][code]" class="form-control form-control-sm" placeholder="Module Code">
            </div>
            <div class="col-md-4">
                <input type="text" name="modules[${moduleIndex}][title]" class="form-control form-control-sm" placeholder="Module Title">
            </div>
            <div class="col-md-1">
                <input type="text" name="modules[${moduleIndex}][credit]" class="form-control form-control-sm" placeholder="Credit">
            </div>
            <div class="col-md-1">
                <input type="text" name="modules[${moduleIndex}][glh]" class="form-control form-control-sm" placeholder="GLH">
            </div>
            <div class="col-md-2">
                <div class="form-check form-check-inline" title="Mandatory">
                    <input class="form-check-input" type="radio" name="modules[${moduleIndex}][is_mandatory]" id="mand_${moduleIndex}" value="1" checked>
                    <label class="form-check-label" for="mand_${moduleIndex}">M</label>
                </div>
                <div class="form-check form-check-inline" title="Optional">
                    <input class="form-check-input" type="radio" name="modules[${moduleIndex}][is_mandatory]" id="opt_${moduleIndex}" value="0">
                    <label class="form-check-label" for="opt_${moduleIndex}">O</label>
                </div>
            </div>
            <div class="col-md-1">
                <input type="number" name="modules[${moduleIndex}][priority]" class="form-control form-control-sm" placeholder="Priority" value="${moduleIndex}">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-module-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        moduleIndex++;
    });

    document.getElementById('course_modules_container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-module-btn') || e.target.closest('.remove-module-btn')) {
            const btn = e.target.classList.contains('remove-module-btn') ? e.target : e.target.closest('.remove-module-btn');
            btn.closest('.module-row').remove();
        }
    });

    // Brochure dynamic rows
    let brochureIndex = 1;
    document.getElementById('add_more_brochure_btn').addEventListener('click', function() {
        const container = document.getElementById('course_brochures_container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center brochure-row mt-2';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="brochures[${brochureIndex}][title]" class="form-control form-control-sm" placeholder="e.g. Course Syllabus">
            </div>
            <div class="col-md-6">
                <input type="file" name="brochures[${brochureIndex}][file]" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
            </div>
            <div class="col-md-1 text-center">
                <button type="button" class="btn btn-danger btn-sm remove-brochure-btn"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        brochureIndex++;
    });

    document.getElementById('course_brochures_container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-brochure-btn') || e.target.closest('.remove-brochure-btn')) {
            const btn = e.target.classList.contains('remove-brochure-btn') ? e.target : e.target.closest('.remove-brochure-btn');
            btn.closest('.brochure-row').remove();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\courses\create.blade.php ENDPATH**/ ?>
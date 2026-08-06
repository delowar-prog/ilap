<?php $__env->startPush('css'); ?>
<style>
    /* ─── Profile Wizard Styles ─── */
    .student-wizard-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,.08);
        overflow: hidden;
    }
    .student-wizard-header {
        background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%);
        padding: 28px 32px;
        color: #fff;
    }
    .student-wizard-header .badge-id {
        background: rgba(255,255,255,.2);
        color: #fff;
        font-size: .75rem;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: .5px;
    }
    .student-wizard-header h4 { color: #fff; font-weight: 700; margin-bottom: 4px; }
    .student-wizard-header p  { color: rgba(255,255,255,.75); font-size: .85rem; margin:0; }

    /* ─── Step Nav ─── */
    .step-nav { display: flex; flex-direction: column; gap: 4px; padding: 20px 12px; }
    .step-nav-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 16px; border-radius: 10px; cursor: pointer;
        font-size: .85rem; font-weight: 500; color: #6e7891;
        border: none; background: transparent; text-align: left; width: 100%;
        transition: all .2s ease;
    }
    .step-nav-item:hover { background: #f0f4ff; color: #2c3e7a; }
    .step-nav-item.active { background: linear-gradient(135deg, #2c3e7a 0%, #1a9fd4 100%); color: #fff; box-shadow: 0 4px 12px rgba(44,62,122,.3); }
    .step-nav-item .step-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: .85rem; flex-shrink:0; background: rgba(0,0,0,.06); }
    .step-nav-item.active .step-icon { background: rgba(255,255,255,.25); color: #fff; }
    .step-nav-item .step-number { width: 20px; height: 20px; border-radius: 50%; background: #e8ecf5; color: #6e7891; font-size: .7rem; font-weight: 700; display: flex; align-items:center; justify-content:center; flex-shrink:0; }
    .step-nav-item.active .step-number { background: rgba(255,255,255,.3); color: #fff; }
    .step-nav-item.completed .step-number { background: #2ecc71; color: #fff; }

    /* ─── Tab Content ─── */
    .tab-pane { display: none; } .tab-pane.show.active { display: block; }
    .section-title { font-size: .9rem; font-weight: 700; color: #2c3e7a; text-transform: uppercase; letter-spacing: .8px; margin-bottom: 16px; display: flex; align-items:center; gap: 8px; }
    .section-title::after { content:''; flex:1; height:1px; background: linear-gradient(90deg,#d8e0f0,transparent); }
    .form-label { font-size: .8rem; font-weight: 600; color: #5a6278; margin-bottom: 5px; }
    .form-control, .form-select { border: 1.5px solid #e8ecf5; border-radius: 8px; font-size: .85rem; padding: 8px 14px; transition: border-color .2s; }
    .form-control:focus, .form-select:focus { border-color: #1a9fd4; box-shadow: 0 0 0 3px rgba(26,159,212,.1); }

    /* ─── Academic Row Card ─── */
    .academic-row { background: #fff; border: 1.5px solid #e8ecf5; border-radius: 12px; padding: 18px; margin-bottom: 14px; position:relative; }
    .academic-row.new-row { background: #f8fbff; border-style: dashed; }
    .remove-row-btn { position:absolute; top:10px; right:12px; color:#e74c3c; cursor:pointer; background:none; border:none; font-size: .9rem; }

    /* ─── Referee Card ─── */
    .referee-card { background: #fff; border: 1.5px solid #e8ecf5; border-radius: 12px; overflow:hidden; margin-bottom: 18px; }
    .referee-card .referee-header { background: linear-gradient(135deg, #f0f4ff, #e8f4fb); padding: 12px 18px; font-weight: 700; font-size: .85rem; color: #2c3e7a; display: flex; align-items:center; gap: 8px; }

    /* ─── Document Upload ─── */
    .doc-upload-area { border: 2px dashed #c5d0e8; border-radius: 12px; padding: 28px; text-align: center; cursor: pointer; transition: all .2s; }
    .doc-upload-area:hover { border-color: #1a9fd4; background: #f0f8ff; }
    .doc-badge { font-size: .78rem; padding: 5px 10px; border-radius: 6px; }

    /* ─── Save Button ─── */
    .btn-save { background: linear-gradient(135deg, #2c3e7a, #1a9fd4); border: none; color: #fff; padding: 10px 28px; border-radius: 8px; font-weight: 600; font-size: .88rem; transition: all .2s; }
    .btn-save:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(44,62,122,.3); color:#fff; }
    .btn-add-more { border: 1.5px dashed #1a9fd4; color: #1a9fd4; background: transparent; padding: 8px 20px; border-radius: 8px; font-size: .83rem; font-weight: 600; cursor:pointer; transition: all .2s; }
    .btn-add-more:hover { background: #f0f8ff; }

    /* ─── Toast ─── */
    #save-toast { position:fixed; bottom:24px; right:24px; z-index:9999; min-width:280px; }
    .toast-success { background: linear-gradient(135deg, #27ae60, #2ecc71); color:#fff; border:none; border-radius: 12px; }
    .toast-error   { background: linear-gradient(135deg, #c0392b, #e74c3c); color:#fff; border:none; border-radius: 12px; }

    /* Progress bar */
    .wizard-progress { height: 4px; background: #e8ecf5; border-radius: 2px; margin: 0 20px 0; }
    .wizard-progress-bar { height: 4px; background: linear-gradient(90deg, #2c3e7a, #1a9fd4); border-radius: 2px; transition: width .4s ease; }

    /* ─── Sidebar active tab link ─── */
    .student-tab-link.active {
        color: #2c3e7a !important;
        font-weight: 600;
        background: rgba(44, 62, 122, 0.08);
        border-radius: 6px;
    }
    .student-tab-link.active i { color: #2c3e7a !important; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row g-3 mb-4">
  <div class="col-12">
    <div class="student-wizard-card">

      <!-- Header -->
      <div class="student-wizard-header d-flex align-items-center gap-3">
        <div class="avatar avatar-3xl">
          <div class="avatar-name rounded-circle" style="background:rgba(255,255,255,.2);color:#fff;font-size:1.4rem;">
            <?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->surname,0,1))); ?>

          </div>
        </div>
        <div>
          <span class="badge-id"><?php echo e($student->student_id); ?></span>
          <h4 class="mt-1"><?php echo e($student->first_name); ?> <?php echo e($student->surname); ?></h4>
          <p><?php echo e($student->email); ?> &bull; <?php echo e($student->phone ?? 'Phone not set'); ?></p>
        </div>
        <div class="ms-auto text-end">
          <div class="text-white-50 fs--2 mb-1">Profile Completion</div>
          <div style="font-size:1.6rem;font-weight:700;"><?php echo e($completionPercent ?? 20); ?>%</div>
        </div>
      </div>

      <!-- Progress Bar -->
      <div class="wizard-progress mx-0">
        <div class="wizard-progress-bar" id="mainProgressBar" style="width:<?php echo e($completionPercent ?? 20); ?>%"></div>
      </div>

      <!-- Hidden nav markers for JS (sidebar links use these) -->
      <span id="nav-0" class="d-none"></span>
      <span id="nav-1" class="d-none"></span>
      <span id="nav-2" class="d-none"></span>
      <span id="nav-3" class="d-none"></span>
      <span id="nav-4" class="d-none"></span>
      <span id="nav-5" class="d-none"></span>
      <span id="nav-6" class="d-none"></span>

      <div class="row g-0">
        <!-- ─── Tab Content ─── -->
        <div class="col-md-12">
          <div class="p-4" id="tab-content-area">

            <!-- ═══════════ TAB 0: Personal Info ═══════════ -->
            <div class="tab-section show active" id="tab-0">
              <form id="form-personal">
                <?php echo csrf_field(); ?>
                <div class="section-title"><i class="fas fa-user text-primary"></i> Personal Information</div>
                <div class="row g-3">
                  <div class="col-md-2">
                    <label class="form-label">Title</label>
                    <select class="form-select" name="title">
                      <option value="">Select</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Mr','Mrs','Miss','Ms','Dr','Prof']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($t); ?>" <?php echo e($student->title==$t?'selected':''); ?>><?php echo e($t); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label">First Name (Given name) <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="first_name" value="<?php echo e($student->first_name); ?>" required>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label">Middle Name</label>
                    <input class="form-control" type="text" name="middle_name" value="<?php echo e($student->middle_name); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Family Name (Surname) <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="surname" value="<?php echo e($student->surname); ?>" required>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Date of Birth</label>
                    <input class="form-control" type="date" name="dob" value="<?php echo e($student->dob ? $student->dob->format('Y-m-d') : ''); ?>">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Male','Female','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($g); ?>" <?php echo e($student->gender==$g?'selected':''); ?>><?php echo e($g); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Nationality</label>
                    <input class="form-control" type="text" name="nationality" value="<?php echo e($student->nationality); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country of Birth</label>
                    <input class="form-control" type="text" name="country_of_birth" value="<?php echo e($student->country_of_birth); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Native Language</label>
                    <input class="form-control" type="text" name="native_language" value="<?php echo e($student->native_language); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input class="form-control" type="email" name="email" value="<?php echo e($student->email); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input class="form-control" type="text" name="phone" value="<?php echo e($student->phone); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Skype ID</label>
                    <input class="form-control" type="text" name="skype_id" value="<?php echo e($student->skype_id); ?>">
                  </div>
                  <div class="col-md-8">
                    <label class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" name="profile_picture" accept="image/*">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->profile_picture): ?>
                      <div class="mt-2 text-muted small">Current: <a href="<?php echo e(asset($student->profile_picture)); ?>" target="_blank">View Picture</a></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  </div>

                  <div class="col-12 mt-2"><div class="section-title"><i class="fas fa-passport text-primary"></i> Passport Details</div></div>
                  <div class="col-md-6">
                    <label class="form-label">Name in Passport</label>
                    <input class="form-control" type="text" name="name_in_passport" value="<?php echo e($student->name_in_passport); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Passport Number</label>
                    <input class="form-control" type="text" name="passport_number" value="<?php echo e($student->passport_number); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Issue Location</label>
                    <input class="form-control" type="text" name="passport_issue_location" value="<?php echo e($student->passport_issue_location); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Issue Date</label>
                    <input class="form-control" type="date" name="passport_issue_date" value="<?php echo e($student->passport_issue_date ? $student->passport_issue_date->format('Y-m-d') : ''); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Expiry Date</label>
                    <input class="form-control" type="date" name="passport_expiry_date" value="<?php echo e($student->passport_expiry_date ? $student->passport_expiry_date->format('Y-m-d') : ''); ?>">
                  </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-personal', '<?php echo e(route('student.profile.personal')); ?>', 1)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 1: Address & Emergency ═══════════ -->
            <div class="tab-section d-none" id="tab-1">
              <form id="form-address">
                <?php echo csrf_field(); ?>
                <div class="section-title"><i class="fas fa-map-marker-alt text-primary"></i> Permanent Address</div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label">Full Address</label>
                    <input class="form-control" type="text" name="permanent_address" value="<?php echo e($student->permanent_address); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input class="form-control" type="text" name="permanent_city" value="<?php echo e($student->permanent_city); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Postcode</label>
                    <input class="form-control" type="text" name="permanent_postcode" value="<?php echo e($student->permanent_postcode); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <input class="form-control" type="text" name="permanent_country" value="<?php echo e($student->permanent_country); ?>">
                  </div>
                </div>

                <div class="section-title mt-4"><i class="fas fa-home text-primary"></i> Current Address <small class="text-muted fw-normal text-lowercase">(if different from permanent)</small></div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label">Full Address</label>
                    <input class="form-control" type="text" name="current_address" value="<?php echo e($student->current_address); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">City</label>
                    <input class="form-control" type="text" name="current_city" value="<?php echo e($student->current_city); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Postcode</label>
                    <input class="form-control" type="text" name="current_postcode" value="<?php echo e($student->current_postcode); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country</label>
                    <input class="form-control" type="text" name="current_country" value="<?php echo e($student->current_country); ?>">
                  </div>
                </div>

                <div class="section-title mt-4"><i class="fas fa-phone-alt text-primary"></i> Emergency Contact</div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" type="text" name="emergency_contact_name" value="<?php echo e($student->emergency_contact_name); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Relationship</label>
                    <input class="form-control" type="text" name="emergency_contact_relationship" value="<?php echo e($student->emergency_contact_relationship); ?>" placeholder="e.g. Father, Mother">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Mobile</label>
                    <input class="form-control" type="text" name="emergency_contact_mobile" value="<?php echo e($student->emergency_contact_mobile); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="emergency_contact_email" value="<?php echo e($student->emergency_contact_email); ?>">
                  </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(0)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-address', '<?php echo e(route('student.profile.personal')); ?>', 2)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 2: Travel & English ═══════════ -->
            <div class="tab-section d-none" id="tab-2">
              <form id="form-travel">
                <?php echo csrf_field(); ?>
                <div class="section-title"><i class="fas fa-plane text-primary"></i> Travel History & Immigration</div>
                <div class="row g-3">
                  <div class="col-12">
                    <div class="card border-0 bg-light rounded-3 p-3">
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Has this student applied for leave to remain in the UK in the past 10 years?</label>
                        <select class="form-select w-auto ms-3" name="applied_leave_to_remain_uk" style="min-width:80px;">
                          <option value="0" <?php echo e(!$student->applied_leave_to_remain_uk ? 'selected' : ''); ?>>No</option>
                          <option value="1" <?php echo e($student->applied_leave_to_remain_uk ? 'selected' : ''); ?>>Yes</option>
                        </select>
                      </div>
                      <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="form-label mb-0">Does this student need a visa to stay in the UK?</label>
                        <select class="form-select w-auto ms-3" name="need_visa_for_uk" style="min-width:80px;">
                          <option value="0" <?php echo e(!$student->need_visa_for_uk ? 'selected' : ''); ?>>No</option>
                          <option value="1" <?php echo e($student->need_visa_for_uk ? 'selected' : ''); ?>>Yes</option>
                        </select>
                      </div>
                      <div class="d-flex align-items-center justify-content-between">
                        <label class="form-label mb-0">Has the student ever been refused a visa or deported?</label>
                        <select class="form-select w-auto ms-3" name="refused_visa_or_deported" style="min-width:80px;">
                          <option value="0" <?php echo e(!$student->refused_visa_or_deported ? 'selected' : ''); ?>>No</option>
                          <option value="1" <?php echo e($student->refused_visa_or_deported ? 'selected' : ''); ?>>Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="form-label">TB Test Details</label>
                    <input class="form-control" type="text" name="taken_tb_test" value="<?php echo e($student->taken_tb_test); ?>" placeholder="e.g. Yes - Certificate No: TB2024...">
                  </div>
                </div>

                <div class="section-title mt-4"><i class="fas fa-language text-primary"></i> English Language Exams</div>
                <?php $test = $englishTests->first() ?? new \App\Models\StudentEnglishTest(); ?>
                <input type="hidden" name="english_tests[0][id]" value="<?php echo e($test->id); ?>">
                <div class="row g-3">
                  <div class="col-md-4">
                    <label class="form-label">Test Type</label>
                    <select class="form-select" name="english_tests[0][test_name]">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['UKVI-IELTS','IELTS','TOEFL','PTE','Duolingo','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $en): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($en); ?>" <?php echo e($test->test_name==$en?'selected':''); ?>><?php echo e($en); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Date of Exam</label>
                    <input class="form-control" type="date" name="english_tests[0][date_of_exam]" value="<?php echo e($test->date_of_exam ? $test->date_of_exam->format('Y-m-d') : ''); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Overall Band / Score</label>
                    <input class="form-control" type="text" name="english_tests[0][overall_score]" value="<?php echo e($test->overall_score); ?>" placeholder="e.g. 6.5">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Listening</label>
                    <input class="form-control" type="text" name="english_tests[0][listening]" value="<?php echo e($test->listening); ?>" placeholder="e.g. 7.0">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Reading</label>
                    <input class="form-control" type="text" name="english_tests[0][reading]" value="<?php echo e($test->reading); ?>" placeholder="e.g. 6.5">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Writing</label>
                    <input class="form-control" type="text" name="english_tests[0][writing]" value="<?php echo e($test->writing); ?>" placeholder="e.g. 6.0">
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Speaking</label>
                    <input class="form-control" type="text" name="english_tests[0][speaking]" value="<?php echo e($test->speaking); ?>" placeholder="e.g. 6.5">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">TRF Number</label>
                    <input class="form-control" type="text" name="english_tests[0][trf_number]" value="<?php echo e($test->trf_number); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">UKVI Number</label>
                    <input class="form-control" type="text" name="english_tests[0][ukvi_number]" value="<?php echo e($test->ukvi_number); ?>">
                  </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(1)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-travel', '<?php echo e(route('student.profile.english')); ?>', 3)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 3: Academic History ═══════════ -->
            <div class="tab-section d-none" id="tab-3">
              <form id="form-academic">
                <?php echo csrf_field(); ?>
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <div class="section-title mb-0"><i class="fas fa-graduation-cap text-primary"></i> Academic History</div>
                  <button type="button" class="btn-add-more" onclick="addAcademicRow()"><i class="fas fa-plus me-1"></i> Add More</button>
                </div>
                <p class="text-muted fs--1 mb-3">Add all your qualifications: 10th Grade, 12th Grade, Bachelor's, Master's, PhD, etc.</p>

                <div id="academics-container">
                  <?php $idx = 0; ?>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $academics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aca): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <div class="academic-row" id="aca-row-<?php echo e($idx); ?>">
                    <button type="button" class="remove-row-btn" onclick="removeAcademicRow(<?php echo e($idx); ?>)"><i class="fas fa-times-circle"></i></button>
                    <input type="hidden" name="academics[<?php echo e($idx); ?>][id]" value="<?php echo e($aca->id); ?>">
                    <div class="row g-2">
                      <div class="col-md-4">
                        <label class="form-label">Education Level</label>
                        <select class="form-select" name="academics[<?php echo e($idx); ?>][education_level]">
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['10th Grade','12th Grade/A-Level','Diploma','Bachelor\'s Degree','Master\'s Degree','PhD/Doctorate','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($el); ?>" <?php echo e($aca->education_level==$el?'selected':''); ?>><?php echo e($el); ?></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][country]" value="<?php echo e($aca->country); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Institution Name</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][institution_name]" value="<?php echo e($aca->institution_name); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Course / Subject</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][course_name]" value="<?php echo e($aca->course_name); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Start Date</label>
                        <input class="form-control" type="date" name="academics[<?php echo e($idx); ?>][start_date]" value="<?php echo e($aca->start_date ? $aca->start_date->format('Y-m-d') : ''); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input class="form-control" type="date" name="academics[<?php echo e($idx); ?>][end_date]" value="<?php echo e($aca->end_date ? $aca->end_date->format('Y-m-d') : ''); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Award Date</label>
                        <input class="form-control" type="date" name="academics[<?php echo e($idx); ?>][award_date]" value="<?php echo e($aca->award_date ? $aca->award_date->format('Y-m-d') : ''); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Result / %</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][result_percentage]" value="<?php echo e($aca->result_percentage); ?>" placeholder="e.g. 85%">
                      </div>
                    </div>
                  </div>
                  <?php $idx++; ?>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                  <!-- Empty placeholder row will be added by JS -->
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($academics->isEmpty()): ?>
                <script>
                  document.addEventListener('DOMContentLoaded', function() { addAcademicRow(); });
                </script>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(2)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-academic', '<?php echo e(route('student.profile.academic')); ?>', 4)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 4: Course Preferences ═══════════ -->
            <div class="tab-section d-none" id="tab-4">
              <form id="form-preferences">
                <?php echo csrf_field(); ?>
                <div class="section-title"><i class="fas fa-book-open text-primary"></i> Academic Interest</div>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Discipline / Field of Study</label>
                    <input class="form-control" type="text" name="field_of_study" value="<?php echo e($preAssessment->field_of_study); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Level of Study</label>
                    <select class="form-select" name="level_of_study">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Foundation','Undergraduate','Postgraduate Taught','Postgraduate Research','PhD','Professional']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($ls); ?>" <?php echo e($preAssessment->level_of_study==$ls?'selected':''); ?>><?php echo e($ls); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Preferred Course 1</label>
                    <input class="form-control" type="text" name="intended_course" value="<?php echo e($preAssessment->intended_course); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Preferred Course 2</label>
                    <input class="form-control" type="text" name="preferred_course_2" value="<?php echo e($preAssessment->preferred_course_2); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Preferred Course 3</label>
                    <input class="form-control" type="text" name="preferred_course_3" value="<?php echo e($preAssessment->preferred_course_3); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Preferred University 1</label>
                    <select class="form-select" name="institute_id" required>
                      <option value="">Select University/College...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $institutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $institute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($institute->id); ?>" <?php echo e(($student->institute_id == $institute->id) ? 'selected' : ''); ?>><?php echo e($institute->name); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Preferred University 2</label>
                    <input class="form-control" type="text" name="preferred_university_2" value="<?php echo e($preAssessment->preferred_university_2); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Preferred University 3</label>
                    <input class="form-control" type="text" name="preferred_university_3" value="<?php echo e($preAssessment->preferred_university_3); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country of Choice</label>
                    <input class="form-control" type="text" name="country_of_choice" value="<?php echo e($preAssessment->country_of_choice); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Intake Date</label>
                    <input class="form-control" type="date" name="intake_date" value="<?php echo e($preAssessment->intake_date ?? ''); ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Study Method</label>
                    <select class="form-select" name="study_method">
                      <option value="">Select...</option>
                      <option value="on_campus" <?php echo e($preAssessment->study_method=='on_campus'?'selected':''); ?>>On Campus</option>
                      <option value="online" <?php echo e($preAssessment->study_method=='online'?'selected':''); ?>>Online</option>
                      <option value="blended" <?php echo e($preAssessment->study_method=='blended'?'selected':''); ?>>Blended</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Source of Funding</label>
                    <select class="form-select" name="source_of_funding">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Self-funded','Family Sponsor','Scholarship','Government Sponsor','Bank Loan','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($sf); ?>" <?php echo e($preAssessment->source_of_funding==$sf?'selected':''); ?>><?php echo e($sf); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Purpose of Study / Personal Statement</label>
                    <textarea class="form-control" name="purpose_of_study" rows="4" placeholder="Briefly explain your motivation for studying abroad..."><?php echo e($preAssessment->purpose_of_study); ?></textarea>
                  </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(3)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-preferences', '<?php echo e(route('student.profile.preferences')); ?>', 5)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 5: Referees ═══════════ -->
            <div class="tab-section d-none" id="tab-5">
              <form id="form-referees">
                <?php echo csrf_field(); ?>
                <div class="section-title"><i class="fas fa-users text-primary"></i> Referee Details</div>
                <p class="text-muted fs--1 mb-4">Please provide at least 2 referees (academic or professional).</p>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i=0; $i<2; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <?php $ref = $referees[$i] ?? new \App\Models\StudentReferee(); ?>
                  <div class="referee-card">
                    <div class="referee-header">
                      <i class="fas fa-user-tie text-primary"></i> Referee <?php echo e($i+1); ?> <?php echo e($i==0?'(Academic / Work)':'(Academic / Personal)'); ?>

                    </div>
                    <div class="p-3 row g-2">
                      <input type="hidden" name="referees[<?php echo e($i); ?>][id]" value="<?php echo e($ref->id); ?>">
                      <div class="col-md-4">
                        <label class="form-label">Full Name</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][full_name]" value="<?php echo e($ref->full_name); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Job Title</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][job_title]" value="<?php echo e($ref->job_title); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Relationship</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][relationship]" value="<?php echo e($ref->relationship); ?>" placeholder="e.g. Lecturer, Manager">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" name="referees[<?php echo e($i); ?>][email]" value="<?php echo e($ref->email); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Mobile / Phone</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][mobile]" value="<?php echo e($ref->mobile); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">How Long Known?</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][how_long_known]" value="<?php echo e($ref->how_long_known); ?>" placeholder="e.g. 3 years">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Organization Name</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][organization_name]" value="<?php echo e($ref->organization_name); ?>">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Organization Address</label>
                        <input class="form-control" type="text" name="referees[<?php echo e($i); ?>][organization_address]" value="<?php echo e($ref->organization_address); ?>">
                      </div>
                    </div>
                  </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                <div class="section-title mt-3"><i class="fas fa-info-circle text-primary"></i> Additional Information</div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="form-label">Bank Balance / Financial Details</label>
                    <textarea class="form-control" name="bank_balance_info" rows="3" placeholder="Optional: Provide bank balance or sponsorship details..."><?php echo e($student->bank_balance_info); ?></textarea>
                  </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                  <button type="button" class="btn btn-outline-secondary" onclick="switchTab(4)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                  <button type="button" class="btn btn-save" onclick="saveAndContinue('form-referees', '<?php echo e(route('student.profile.referees')); ?>', 6)">Save & Continue <i class="fas fa-arrow-right ms-1"></i></button>
                </div>
              </form>
            </div>

            <!-- ═══════════ TAB 6: Documents ═══════════ -->
            <div class="tab-section d-none" id="tab-6">
              <div class="section-title"><i class="fas fa-folder-open text-primary"></i> Document Upload</div>
              <p class="text-muted fs--1 mb-3">Accepted formats: PDF, JPG, PNG, DOC. Max 5MB per file.</p>
              
              <div class="row g-3 mb-4">
                <div class="col-md-4">
                  <label class="form-label">Document Type</label>
                  <select class="form-select" id="doc_type">
                    <option value="CV">CV / Resume</option>
                    <option value="Passport">Passport Copy</option>
                    <option value="Certificate">Academic Certificates</option>
                    <option value="Transcript">Academic Transcripts</option>
                    <option value="EnglishResult">English Test Result</option>
                    <option value="SOP">Statement of Purpose</option>
                    <option value="LOR">Letter of Reference</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label">Document Title</label>
                  <input class="form-control" type="text" id="doc_title" placeholder="e.g. IELTS Report 2023">
                </div>
                <div class="col-md-3">
                  <label class="form-label">Select File</label>
                  <input class="form-control" type="file" id="doc_file">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                  <button type="button" class="btn btn-save w-100 px-2" onclick="uploadDoc()" title="Upload"><i class="fas fa-upload"></i></button>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Uploaded Documents</h6>
                <form action="<?php echo e(route('student.profile.edit')); ?>" method="GET" class="d-flex" style="max-width: 300px;">
                  <input type="hidden" name="tab" value="6">
                  <input type="text" name="doc_search" class="form-control form-control-sm me-2" placeholder="Search..." value="<?php echo e(request('doc_search')); ?>">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('doc_search')): ?>
                    <a href="<?php echo e(route('student.profile.edit')); ?>?tab=6#tab-6" class="btn btn-sm btn-outline-secondary ms-1"><i class="fas fa-times"></i></a>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
              </div>
              <div id="docs-list">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border">
                    <div class="d-flex align-items-center gap-3">
                      <i class="fas fa-file-pdf text-danger fs-5"></i>
                      <div>
                        <div class="fw-600 fs--1"><?php echo e($doc->document_type); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc->title): ?> - <?php echo e($doc->title); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                        <div class="text-500 fs--2"><?php echo e($doc->created_at->format('d M Y')); ?></div>
                      </div>
                    </div>
                    <a href="<?php echo e(Storage::url($doc->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-download me-1"></i> View</a>
                  </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                  <div class="text-center text-muted py-4"><i class="fas fa-inbox fs-3 mb-2 d-block"></i>No documents uploaded yet.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
              
              <div class="mt-3">
                <?php echo e($documents->appends(request()->query())->fragment('tab-6')->links('pagination::bootstrap-5')); ?>

              </div>

              <div class="mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="switchTab(5)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                <button type="button" class="btn btn-primary ms-2" onclick="switchTab(7)">Next <i class="fas fa-arrow-right ms-1"></i></button>
              </div>
            </div>

            <!-- ═══════════ TAB 7: Download Documents (Admin Uploaded) ═══════════ -->
            <div class="tab-section d-none" id="tab-7">
              <div class="section-title"><i class="fas fa-download text-primary"></i> Download Documents</div>
              <p class="text-muted fs--1 mb-3">Documents uploaded by the administration for you.</p>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Admin Documents</h6>
                <form action="<?php echo e(route('student.profile.edit')); ?>" method="GET" class="d-flex" style="max-width: 300px;">
                  <input type="hidden" name="tab" value="7">
                  <input type="text" name="admin_doc_search" class="form-control form-control-sm me-2" placeholder="Search..." value="<?php echo e(request('admin_doc_search')); ?>">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('admin_doc_search')): ?>
                    <a href="<?php echo e(route('student.profile.edit')); ?>?tab=7#tab-7" class="btn btn-sm btn-outline-secondary ms-1"><i class="fas fa-times"></i></a>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
              </div>

              <div id="admin-docs-list">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $adminDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border">
                    <div class="d-flex align-items-center gap-3">
                      <i class="fas fa-file-alt text-success fs-5"></i>
                      <div>
                        <div class="fw-600 fs--1"><?php echo e($doc->document_type); ?> <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($doc->title): ?> - <?php echo e($doc->title); ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?></div>
                        <div class="text-500 fs--2"><?php echo e($doc->created_at->format('d M Y')); ?></div>
                      </div>
                    </div>
                    <a href="<?php echo e(Storage::url($doc->file_path)); ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill" download><i class="fas fa-download me-1"></i> Download</a>
                  </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                  <div class="text-center text-muted py-4"><i class="fas fa-inbox fs-3 mb-2 d-block"></i>No documents from admin yet.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>

              <div class="mt-3">
                <?php echo e($adminDocuments->appends(request()->query())->fragment('tab-7')->links('pagination::bootstrap-5')); ?>

              </div>

              <div class="mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="switchTab(6)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-success ms-2"><i class="fas fa-check-circle me-1"></i> Finish & Submit</a>
              </div>
            </div>

          </div><!-- /p-4 -->
        </div><!-- /col-md-9 -->
      </div><!-- /row -->
    </div><!-- /student-wizard-card -->
  </div>
</div>

<!-- Toast Notification -->
<div id="save-toast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
  <div class="d-flex">
    <div class="toast-body" id="toast-message">Saved!</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let currentTab = 0;
let academicRowCount = <?php echo e($academics->count()); ?>;

function switchTab(index) {
    // Hide all
    document.querySelectorAll('.tab-section').forEach(s => s.classList.add('d-none'));
    document.querySelectorAll('.step-nav-item').forEach(n => n.classList.remove('active'));
    // Show selected
    document.getElementById('tab-' + index).classList.remove('d-none');
    
    let navItem = document.getElementById('nav-' + index);
    if(navItem) navItem.classList.add('active');
    
    currentTab = index;
    // Update progress bar (8 steps)
    document.getElementById('mainProgressBar').style.width = (((index + 1) / 8) * 100) + '%';
    // Update URL hash without scroll
    history.replaceState(null, '', '#tab-' + index);
}

// ─── Sidebar active link highlight ───
function updateSidebarActiveLink(index) {
    document.querySelectorAll('.student-tab-link').forEach(link => {
        link.classList.remove('active');
        if (parseInt(link.getAttribute('data-tab')) === index) {
            link.classList.add('active');
        }
    });
}

// ─── Handle sidebar link click (works on same page) ───
function handleStudentTabClick(event, index) {
    // If we are already on the student dashboard, switch tab without navigation
    if (document.getElementById('tab-content-area')) {
        event.preventDefault();
        switchTab(index);
        updateSidebarActiveLink(index);
    }
    // Otherwise let the link navigate normally (hash will be read on load)
}

// ─── Auto-switch based on URL hash or query param on page load ───
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    let hash = window.location.hash;

    let targetTab = null;

    if (hash && hash.startsWith('#tab-')) {
        targetTab = parseInt(hash.replace('#tab-', ''));
    } else if (tabParam !== null) {
        targetTab = parseInt(tabParam);
    }

    if (targetTab !== null && !isNaN(targetTab) && targetTab >= 0 && targetTab <= 7) {
        switchTab(targetTab);
        updateSidebarActiveLink(targetTab);
    } else {
        updateSidebarActiveLink(0); // default: Personal Info active
    }

    // Also handle hash change if user navigates via browser back/forward
    window.addEventListener('hashchange', function() {
        const h = window.location.hash;
        if (h && h.startsWith('#tab-')) {
            const i = parseInt(h.replace('#tab-', ''));
            if (!isNaN(i) && i >= 0 && i <= 6) {
                switchTab(i);
                updateSidebarActiveLink(i);
            }
        }
    });
});

function showToast(message, isSuccess) {
    const toast = document.getElementById('save-toast');
    const msg = document.getElementById('toast-message');
    msg.textContent = message;
    toast.className = 'toast align-items-center border-0 ' + (isSuccess ? 'toast-success' : 'toast-error');
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
}

function saveAndContinue(formId, url, nextTab) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);

    // Disable button
    const btns = form.querySelectorAll('button[type=button]');
    btns.forEach(b => { b.disabled = true; });

    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, true);
            // Mark nav item as completed
            document.getElementById('nav-' + currentTab).classList.add('completed');
            if (nextTab !== undefined) setTimeout(() => switchTab(nextTab), 600);
        } else {
            showToast(data.message || 'Failed to save. Please try again.', false);
        }
    })
    .catch(err => {
        showToast('Network error. Please check your connection.', false);
        console.error(err);
    })
    .finally(() => {
        btns.forEach(b => { b.disabled = false; });
    });
}

function addAcademicRow() {
    const idx = academicRowCount++;
    const container = document.getElementById('academics-container');
    const html = `
    <div class="academic-row new-row" id="aca-row-${idx}">
        <button type="button" class="remove-row-btn" onclick="removeAcademicRow(${idx})"><i class="fas fa-times-circle"></i></button>
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label">Education Level</label>
                <select class="form-select" name="academics[${idx}][education_level]">
                    <option value="">Select...</option>
                    <option value="10th Grade">10th Grade</option>
                    <option value="12th Grade/A-Level">12th Grade / A-Level</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Bachelor's Degree">Bachelor's Degree</option>
                    <option value="Master's Degree">Master's Degree</option>
                    <option value="PhD/Doctorate">PhD / Doctorate</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <input class="form-control" type="text" name="academics[${idx}][country]" placeholder="Country of institution">
            </div>
            <div class="col-md-4">
                <label class="form-label">Institution Name</label>
                <input class="form-control" type="text" name="academics[${idx}][institution_name]" placeholder="University / School name">
            </div>
            <div class="col-md-4">
                <label class="form-label">Course / Subject</label>
                <input class="form-control" type="text" name="academics[${idx}][course_name]" placeholder="e.g. BSc Computer Science">
            </div>
            <div class="col-md-2">
                <label class="form-label">Start Date</label>
                <input class="form-control" type="date" name="academics[${idx}][start_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input class="form-control" type="date" name="academics[${idx}][end_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Award Date</label>
                <input class="form-control" type="date" name="academics[${idx}][award_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Result / %</label>
                <input class="form-control" type="text" name="academics[${idx}][result_percentage]" placeholder="e.g. 85%">
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function removeAcademicRow(idx) {
    const row = document.getElementById('aca-row-' + idx);
    if (row) row.remove();
}

function uploadDoc() {
    const fileInput = document.getElementById('doc_file');
    const docType   = document.getElementById('doc_type').value;
    const docTitle  = document.getElementById('doc_title') ? document.getElementById('doc_title').value : '';
    if (!fileInput.files.length) { showToast('Please select a file first.', false); return; }

    const fd = new FormData();
    fd.append('document', fileInput.files[0]);
    fd.append('document_type', docType);
    fd.append('title', docTitle);
    fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);

    fetch('<?php echo e(route('student.profile.upload')); ?>', {
        method: 'POST',
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, true);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(data.message, false);
        }
    })
    .catch(() => showToast('Upload failed. Try again.', false));
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ilap\resources\views/backend/student/student_profile.blade.php ENDPATH**/ ?>
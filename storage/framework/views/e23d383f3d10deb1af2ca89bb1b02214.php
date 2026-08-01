<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <div class="position-relative" style="width: 200px; height: 200px; flex-shrink: 0;">
          <label for="header_profile_picture" class="d-block h-100 w-100 rounded-circle position-relative overflow-hidden shadow-sm" style="cursor: pointer; border: 5px solid rgba(255,255,255,0.5);">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->profile_picture): ?>
              <img id="header-avatar-img" class="rounded-circle w-100 h-100" src="<?php echo e(asset($student->profile_picture)); ?>" alt="Profile Picture" style="object-fit: cover;">
            <?php else: ?>
              <div id="header-avatar-placeholder" class="rounded-circle w-100 h-100 d-flex align-items-center justify-content-center" style="background:rgba(255,255,255,.2);color:#fff;font-size:2rem;">
                <?php echo e(strtoupper(substr($student->first_name,0,1))); ?><?php echo e(strtoupper(substr($student->surname,0,1))); ?>

              </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center rounded-circle" style="background: rgba(0,0,0,0.4); opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                <i class="fas fa-camera text-white fs-4"></i>
            </div>
          </label>
          <input type="file" id="header_profile_picture" class="d-none" accept="image/*" onchange="uploadHeaderProfilePicture(this)">
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
              <form id="form-personal" enctype="multipart/form-data">
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
                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
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
                    <label class="form-label">Country of Nationality <span class="text-danger">*</span></label>
                    <select class="form-select select2-tags" name="nationality" data-placeholder="Select or type country of nationality..." required>
                      <option value="">Select...</option>
                      <?php
                        $activeCountries = \App\Models\Country::where('status', 'active')->orderBy('name')->get();
                        $natVal = old('nationality', $student->nationality ?? '');
                      ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($c->name); ?>" <?php echo e($natVal == $c->name ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($natVal && !$activeCountries->contains('name', $natVal)): ?>
                        <option value="<?php echo e($natVal); ?>" selected><?php echo e($natVal); ?></option>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country of Birth</label>
                    <select class="form-select select2-tags" name="country_of_birth" data-placeholder="Select or type country of birth...">
                      <option value="">Select...</option>
                      <?php
                        $activeCountries = \App\Models\Country::where('status', 'active')->orderBy('name')->get();
                        $cobVal = old('country_of_birth', $student->country_of_birth ?? '');
                      ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($c->name); ?>" <?php echo e($cobVal == $c->name ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cobVal && !$activeCountries->contains('name', $cobVal)): ?>
                        <option value="<?php echo e($cobVal); ?>" selected><?php echo e($cobVal); ?></option>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Country of Residence</label>
                    <select class="form-select select2-tags" name="country_id" data-placeholder="Select country" required>
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($country->id); ?>" <?php echo e(($student->country_id ?? '') == $country->id ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input class="form-control" type="email" name="email" value="<?php echo e($student->email); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="phone" value="<?php echo e($student->phone); ?>" required>
                    <div class="form-check mt-2">
                      <input class="form-check-input" type="checkbox" name="has_whatsapp" value="1" id="hasWhatsappChk" <?php echo e(old('has_whatsapp', $student->has_whatsapp ?? false) ? 'checked' : ''); ?>>
                      <label class="form-check-label font-13 text-muted fw-medium" for="hasWhatsappChk">
                        <i class="fab fa-whatsapp text-success me-1 font-16"></i> WhatsApp available on this number
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
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
                <div class="row g-4">
                  <!-- LEFT COLUMN: Current Address -->
                  <div class="col-lg-6">
                    <div class="card h-100 border shadow-sm" style="border-radius: 8px;">
                      <div class="card-header bg-light py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-home me-2"></i> Current / Present Address</h6>
                      </div>
                      <div class="card-body">
                        <div class="row g-3">
                          <div class="col-12">
                            <label class="form-label">Full Address</label>
                            <input class="form-control" type="text" name="current_address" value="<?php echo e(old('current_address', $student->current_address ?? $preAssessment->contact_address)); ?>" placeholder="Street address...">
                          </div>
                          <div class="col-12">
                            <label class="form-label">Postcode</label>
                            <input class="form-control" type="text" name="current_postcode" value="<?php echo e(old('current_postcode', $student->current_postcode ?? $preAssessment->postal_code)); ?>" placeholder="Postal / Zip Code">
                          </div>
                          <div class="col-12">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('geo.location-selector', ['initialCountry' => old('current_country', $student->current_country ?? $preAssessment->country),'initialState' => old('current_state', $student->current_state ?? $preAssessment->state ?? ''),'initialCity' => old('current_city', $student->current_city ?? $preAssessment->city),'countryField' => 'current_country','stateField' => 'current_state','cityField' => 'current_city','countryColClass' => 'col-12','stateColClass' => 'col-md-6','cityColClass' => 'col-md-6']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-531646037-0', $__key);

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
                  </div>

                  <!-- RIGHT COLUMN: Permanent Address -->
                  <div class="col-lg-6">
                    <div class="card h-100 border shadow-sm" style="border-radius: 8px;">
                      <div class="card-header bg-light py-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-map-marker-alt me-2"></i> Permanent Address</h6>
                      </div>
                      <div class="card-body">
                        <!-- Prominent Checkbox Banner -->
                        <div class="p-2 px-3 mb-3 border rounded-3 bg-primary bg-opacity-10 border-primary border-opacity-25 d-flex align-items-center justify-content-between">
                          <div class="form-check font-14 mb-0 d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" id="sameAsCurrentAddress" style="width: 18px; height: 18px; cursor: pointer;">
                            <label class="form-check-label text-primary fw-bold font-14 cursor-pointer mb-0" for="sameAsCurrentAddress" style="cursor: pointer; user-select: none;">
                              <i class="fas fa-copy me-1"></i> Same as Current / Present Address
                            </label>
                          </div>
                        </div>

                        <div class="row g-3">
                          <div class="col-12">
                            <label class="form-label">Full Address <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="permanent_address" value="<?php echo e(old('permanent_address', $student->permanent_address)); ?>" placeholder="Street address...">
                          </div>
                          <div class="col-12">
                            <label class="form-label">Postcode <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="permanent_postcode" value="<?php echo e(old('permanent_postcode', $student->permanent_postcode)); ?>" placeholder="Postal / Zip Code">
                          </div>
                          <div class="col-12">
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('geo.location-selector', ['initialCountry' => old('permanent_country', $student->permanent_country),'initialState' => old('permanent_state', $student->permanent_state ?? ''),'initialCity' => old('permanent_city', $student->permanent_city),'countryField' => 'permanent_country','stateField' => 'permanent_state','cityField' => 'permanent_city','countryColClass' => 'col-12','stateColClass' => 'col-md-6','cityColClass' => 'col-md-6']);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-531646037-1', $__key);

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
                    <?php
                      $preAssessment = \App\Models\StudentPreAssessment::where('student_id', $student->id)->first();
                      $studyDest = $preAssessment ? $preAssessment->study_destination : 'United Kingdom (UK)';

                      $travelData = old('travel_history', $student->travel_history ?? $preAssessment->travel_history ?? []);
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

                      $refusalData = old('visa_refusals', $student->visa_refusals ?? $preAssessment->visa_refusals ?? []);
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

                    
                    <div class="card border-0 bg-light rounded-3 p-3 mb-3">
                      <div class="mb-3">
                        <label class="form-label fw-bold mb-2">Has this student applied for permission to remain in any of the following countries in the past ten years? <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                          <input type="radio" class="btn-check" name="travel_history[has_history]" id="student_travel_yes" value="yes" <?php echo e((old('travel_history.has_history', $travelData['has_history'] ?? '') == 'yes') ? 'checked' : ''); ?> onclick="toggleStudentTravelHistoryFields(true)">
                          <label class="btn btn-outline-primary px-4 btn-sm" for="student_travel_yes">Yes</label>

                          <input type="radio" class="btn-check" name="travel_history[has_history]" id="student_travel_no" value="no" <?php echo e((old('travel_history.has_history', $travelData['has_history'] ?? 'no') == 'no') ? 'checked' : ''); ?> onclick="toggleStudentTravelHistoryFields(false)">
                          <label class="btn btn-outline-secondary px-4 btn-sm" for="student_travel_no">No</label>
                        </div>
                      </div>

                      <div id="student_travel_history_fields" style="display: <?php echo e((old('travel_history.has_history', $travelData['has_history'] ?? '') == 'yes') ? 'block' : 'none'); ?>;">
                        <div id="student_travel_history_container">
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $travelEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tIndex => $tEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="student-travel-row bg-white p-3 border rounded-3 mb-3" id="student_travel_row_<?php echo e($tIndex); ?>">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-plane me-1"></i> Travel Entry #<span class="student-travel-entry-num"><?php echo e($loop->iteration); ?></span></h6>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-student-travel-btn" onclick="removeStudentTravelRow(<?php echo e($tIndex); ?>)" style="<?php echo e(count($travelEntries) > 1 ? '' : 'display:none;'); ?>">
                                  <i class="fas fa-times me-1"></i> Remove
                                </button>
                              </div>
                              <div class="row g-3">
                                <div class="col-md-3">
                                  <label class="form-label font-12">Date of Arrival <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][arrival_date]" value="<?php echo e($tEntry['arrival_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                  <label class="form-label font-12">Date of Departure <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][departure_date]" value="<?php echo e($tEntry['departure_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                  <label class="form-label font-12">Visa Start Date <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][visa_start_date]" value="<?php echo e($tEntry['visa_start_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-3">
                                  <label class="form-label font-12">Visa Expiry Date <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][visa_expiry_date]" value="<?php echo e($tEntry['visa_expiry_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                  <label class="form-label font-12">Purpose of Visit <span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" name="travel_history[entries][<?php echo e($tIndex); ?>][purpose_of_visit]" value="<?php echo e($tEntry['purpose_of_visit'] ?? ''); ?>" placeholder="e.g. Tourism, Study, Work">
                                </div>
                                <div class="col-md-4">
                                  <label class="form-label font-12">Country <span class="text-danger">*</span></label>
                                  <select class="form-select select2-tags" name="travel_history[entries][<?php echo e($tIndex); ?>][country]" data-placeholder="Select country">
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
                                  <label class="form-label font-12">Visa Type <span class="text-danger">*</span></label>
                                  <select class="form-select" name="travel_history[entries][<?php echo e($tIndex); ?>][visa_type]">
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

                        <div class="mb-2">
                          <button type="button" class="btn btn-outline-primary btn-sm" onclick="addStudentTravelRow()">
                            <i class="fas fa-plus me-1"></i> Add Another Travel Entry
                          </button>
                        </div>
                      </div>
                    </div>

                    
                    <div class="card border-0 bg-light rounded-3 p-3 mb-3">
                      <div class="mb-0">
                        <label class="form-label fw-bold mb-2">Does this student need a visa to stay in any of the following countries? Please tick all that apply. <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 mt-2">
                          <div class="form-check">
                            <?php
                              $immCountries = old('immigration_history.countries', $student->immigration_history['countries'] ?? $preAssessment->immigration_history['countries'] ?? []);
                            ?>
                            <input class="form-check-input" type="checkbox" name="immigration_history[countries][]" value="<?php echo e($studyDest); ?>" id="student_imm_country_chk" onclick="toggleStudentImmigrationNone(false)" <?php echo e((in_array($studyDest, $immCountries)) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-semibold font-13" for="student_imm_country_chk">
                              <?php echo e($studyDest); ?>

                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="immigration_history[countries][]" value="None" id="student_imm_none_chk" onclick="toggleStudentImmigrationNone(true)" <?php echo e((in_array('None', $immCountries) || empty($immCountries)) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-semibold font-13" for="student_imm_none_chk">None</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    
                    <div class="card border-0 bg-light rounded-3 p-3 mb-3">
                      <div class="mb-3">
                        <label class="form-label fw-bold mb-2">For any country has this student ever been refused permission to stay or remain, refused asylum or deported? <span class="text-danger">*</span></label>
                        <div class="d-flex gap-2">
                          <input type="radio" class="btn-check" name="visa_refusals[has_refusal]" id="student_refusal_yes" value="yes" <?php echo e((old('visa_refusals.has_refusal', $refusalData['has_refusal'] ?? '') == 'yes') ? 'checked' : ''); ?> onclick="toggleStudentVisaRefusalFields(true)">
                          <label class="btn btn-outline-danger px-4 btn-sm" for="student_refusal_yes">Yes</label>

                          <input type="radio" class="btn-check" name="visa_refusals[has_refusal]" id="student_refusal_no" value="no" <?php echo e((old('visa_refusals.has_refusal', $refusalData['has_refusal'] ?? 'no') == 'no') ? 'checked' : ''); ?> onclick="toggleStudentVisaRefusalFields(false)">
                          <label class="btn btn-outline-secondary px-4 btn-sm" for="student_refusal_no">No</label>
                        </div>
                      </div>

                      <div id="student_visa_refusal_fields" style="display: <?php echo e((old('visa_refusals.has_refusal', $refusalData['has_refusal'] ?? '') == 'yes') ? 'block' : 'none'); ?>;">
                        <div id="student_visa_refusal_container">
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $refusalEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rIndex => $rEntry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="student-refusal-row bg-white p-3 border rounded-3 mb-3" id="student_refusal_row_<?php echo e($rIndex); ?>">
                              <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-semibold text-danger"><i class="fas fa-ban me-1"></i> Refusal Entry #<span class="student-refusal-entry-num"><?php echo e($loop->iteration); ?></span></h6>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-student-refusal-btn" onclick="removeStudentRefusalRow(<?php echo e($rIndex); ?>)" style="<?php echo e(count($refusalEntries) > 1 ? '' : 'display:none;'); ?>">
                                  <i class="fas fa-times me-1"></i> Remove
                                </button>
                              </div>
                              <div class="row g-3">
                                <div class="col-md-4">
                                  <label class="form-label font-12">Refusal Type <span class="text-danger">*</span></label>
                                  <select class="form-select" name="visa_refusals[entries][<?php echo e($rIndex); ?>][refusal_type]">
                                    <option value="">Select Refusal Type...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Visa Refusal','Refused Entry','Deported','Refused Leave to Remain','Refused Asylum']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                      <option value="<?php echo e($rt); ?>" <?php echo e(($rEntry['refusal_type'] ?? '') == $rt ? 'selected' : ''); ?>><?php echo e($rt); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                  </select>
                                </div>
                                <div class="col-md-4">
                                  <label class="form-label font-12">Date of Refusal <span class="text-danger">*</span></label>
                                  <input type="date" class="form-control" name="visa_refusals[entries][<?php echo e($rIndex); ?>][refusal_date]" value="<?php echo e($rEntry['refusal_date'] ?? ''); ?>">
                                </div>
                                <div class="col-md-4">
                                  <label class="form-label font-12">Country <span class="text-danger">*</span></label>
                                  <select class="form-select select2-tags" name="visa_refusals[entries][<?php echo e($rIndex); ?>][country]" data-placeholder="Select country">
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
                                  <label class="form-label font-12">Visa Type <span class="text-danger">*</span></label>
                                  <select class="form-select" name="visa_refusals[entries][<?php echo e($rIndex); ?>][visa_type]">
                                    <option value="">Select Visa Type...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['Tourist Visa','Student Visa','Work Visa','Business Visa','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                      <option value="<?php echo e($vt); ?>" <?php echo e(($rEntry['visa_type'] ?? '') == $vt ? 'selected' : ''); ?>><?php echo e($vt); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                  </select>
                                </div>
                                <div class="col-md-8">
                                  <label class="form-label font-12">Details / Reason <span class="text-danger">*</span></label>
                                  <textarea class="form-control" name="visa_refusals[entries][<?php echo e($rIndex); ?>][details]" rows="2" placeholder="Provide details or reason for refusal..."><?php echo e($rEntry['details'] ?? ''); ?></textarea>
                                </div>
                              </div>
                            </div>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        <div class="mb-2">
                          <button type="button" class="btn btn-outline-danger btn-sm" onclick="addStudentRefusalRow()">
                            <i class="fas fa-plus me-1"></i> Add Another Refusal Entry
                          </button>
                        </div>
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
                        <select class="form-select select2-tags" name="academics[<?php echo e($idx); ?>][education_level]">
                          <option value=""></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $qualificationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($el); ?>" <?php echo e($aca->education_level==$el?'selected':''); ?>><?php echo e($el); ?></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
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
                        <input class="form-control" type="month" name="academics[<?php echo e($idx); ?>][start_date]" value="<?php echo e($aca->start_date ? $aca->start_date->format('Y-m') : ''); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">End Date</label>
                        <input class="form-control" type="month" name="academics[<?php echo e($idx); ?>][end_date]" value="<?php echo e($aca->end_date ? $aca->end_date->format('Y-m') : ''); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Award Date</label>
                        <input class="form-control" type="date" name="academics[<?php echo e($idx); ?>][award_date]" value="<?php echo e($aca->award_date ? $aca->award_date->format('Y-m-d') : ''); ?>">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Result Type</label>
                        <select class="form-select" name="academics[<?php echo e($idx); ?>][result_type]" onchange="toggleOtherResultType(this)">
                          <option value="">Select...</option>
                          <option value="GPA" <?php echo e($aca->result_type=='GPA'?'selected':''); ?>>GPA</option>
                          <option value="CGPA" <?php echo e($aca->result_type=='CGPA'?'selected':''); ?>>CGPA</option>
                          <option value="Percentage" <?php echo e($aca->result_type=='Percentage'?'selected':''); ?>>Percentage</option>
                          <option value="Others" <?php echo e($aca->result_type=='Others'?'selected':''); ?>>Others</option>
                        </select>
                      </div>
                      <div class="col-md-2 other-result-type-div" style="<?php echo e($aca->result_type=='Others' ? '' : 'display:none;'); ?>">
                        <label class="form-label">Other Type</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][other_result_type]" value="<?php echo e($aca->other_result_type); ?>" placeholder="Type here...">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Result</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][result_percentage]" value="<?php echo e($aca->result_percentage); ?>" placeholder="Value">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label">Out of</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][result_out_of]" value="<?php echo e($aca->result_out_of); ?>" placeholder="e.g. 100 or 4.0">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Country</label>
                        <select class="form-control select2-tags" name="academics[<?php echo e($idx); ?>][country]" data-placeholder="Select country">
                          <option value=""></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aca->country && !in_array($aca->country, $countriesList)): ?>
                            <option value="<?php echo e($aca->country); ?>" selected><?php echo e($aca->country); ?></option>
                          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countriesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($c); ?>" <?php echo e($aca->country == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select class="form-control select2-tags" name="academics[<?php echo e($idx); ?>][city]" data-placeholder="Select city">
                          <option value=""></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($aca->city && !in_array($aca->city, $citiesList)): ?>
                            <option value="<?php echo e($aca->city); ?>" selected><?php echo e($aca->city); ?></option>
                          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $citiesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($c); ?>" <?php echo e($aca->city == $c ? 'selected' : ''); ?>><?php echo e($c); ?></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Zip Code</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][zip_code]" value="<?php echo e($aca->zip_code); ?>">
                      </div>
                      <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" name="academics[<?php echo e($idx); ?>][institution_address]" value="<?php echo e($aca->institution_address); ?>">
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
                  <div class="col-md-4">
                    <label class="form-label">Country of Choice</label>
                    <select class="form-select select2-tags" name="country_of_choice" data-placeholder="Select or type country of choice...">
                      <option value="">Select...</option>
                      <?php
                        $activeCountries = \App\Models\Country::where('status', 'active')->orderBy('name')->get();
                        $cocVal = old('country_of_choice', $preAssessment->country_of_choice ?? '');
                      ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeCountries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($c->name); ?>" <?php echo e($cocVal == $c->name ? 'selected' : ''); ?>><?php echo e($c->name); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cocVal && !$activeCountries->contains('name', $cocVal)): ?>
                        <option value="<?php echo e($cocVal); ?>" selected><?php echo e($cocVal); ?></option>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Intake Date</label>
                    <input class="form-control" type="date" name="intake_date" value="<?php echo e($preAssessment->intake_date ?? ''); ?>">
                  </div>
                   <div class="col-md-4">
                    <label class="form-label">Study Method</label>
                    <select class="form-select" name="study_method" data-current-value="<?php echo e(old('study_method', $preAssessment->study_method ?? '')); ?>">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $studyMethods ?? \App\Models\DropdownOption::active('study_method'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($opt); ?>" <?php echo e($preAssessment->study_method == $opt ? 'selected' : ''); ?>><?php echo e($opt); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Discipline / Field of Study</label>
                    <input class="form-control" type="text" name="field_of_study" value="<?php echo e($preAssessment->field_of_study); ?>">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Level of Study</label>
                    <select class="form-select" name="level_of_study" data-current-value="<?php echo e(old('level_of_study', $preAssessment->level_of_study ?? '')); ?>">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $levelOfStudyOptions ?? \App\Models\DropdownOption::active('level_of_study'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($ls); ?>" <?php echo e($preAssessment->level_of_study == $ls ? 'selected' : ''); ?>><?php echo e($ls); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <?php
                    $allCourseList = collect();
                    if (isset($courses)) {
                        foreach ($courses as $cItem) {
                            $allCourseList->push($cItem->name);
                        }
                    }
                    if (!empty($preAssessment->intended_course)) $allCourseList->push($preAssessment->intended_course);
                    if (!empty($preAssessment->preferred_course_2)) $allCourseList->push($preAssessment->preferred_course_2);
                    if (!empty($preAssessment->preferred_course_3)) $allCourseList->push($preAssessment->preferred_course_3);
                    $allCourseList = $allCourseList->filter()->unique()->values();

                    $val_uni_1 = $preAssessment->institute_name ?: ($student->institute->name ?? '');
                    $allInstituteList = collect();
                    if (isset($institutes)) {
                        foreach ($institutes as $iItem) {
                            $allInstituteList->push($iItem->name);
                        }
                    }
                    if (!empty($val_uni_1)) $allInstituteList->push($val_uni_1);
                    if (!empty($preAssessment->preferred_university_2)) $allInstituteList->push($preAssessment->preferred_university_2);
                    if (!empty($preAssessment->preferred_university_3)) $allInstituteList->push($preAssessment->preferred_university_3);
                    $allInstituteList = $allInstituteList->filter()->unique()->values();
                  ?>

                  <div class="col-md-6">
                    <label class="form-label">Preferred Course 1</label>
                    <select class="form-control select2-tags" name="intended_course" data-placeholder="Select or type course">
                        <option value=""></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allCourseList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($cName); ?>" <?php echo e(($preAssessment->intended_course ?? '') == $cName ? 'selected' : ''); ?>><?php echo e($cName); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred University 1</label>
                    <select class="form-control select2-tags" name="institute_name" data-placeholder="Select or type university" required>
                        <option value=""></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allInstituteList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($iName); ?>" <?php echo e($val_uni_1 == $iName ? 'selected' : ''); ?>><?php echo e($iName); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label class="form-label">Course Link 1</label>
                    <input class="form-control" type="url" name="course_link" value="<?php echo e($preAssessment->course_link); ?>" placeholder="https://...">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred Course 2</label>
                    <select class="form-control select2-tags" name="preferred_course_2" data-placeholder="Select or type course">
                        <option value=""></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allCourseList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($cName); ?>" <?php echo e(($preAssessment->preferred_course_2 ?? '') == $cName ? 'selected' : ''); ?>><?php echo e($cName); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred University 2</label>
                    <select class="form-control select2-tags" name="preferred_university_2" data-placeholder="Select or type university">
                        <option value=""></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allInstituteList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($iName); ?>" <?php echo e(($preAssessment->preferred_university_2 ?? '') == $iName ? 'selected' : ''); ?>><?php echo e($iName); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label class="form-label">Course Link 2</label>
                    <input class="form-control" type="url" name="course_link_2" value="<?php echo e($preAssessment->course_link_2); ?>" placeholder="https://...">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred Course 3</label>
                    <select class="form-control select2-tags" name="preferred_course_3" data-placeholder="Select or type course">
                        <option value=""></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allCourseList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($cName); ?>" <?php echo e(($preAssessment->preferred_course_3 ?? '') == $cName ? 'selected' : ''); ?>><?php echo e($cName); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Preferred University 3</label>
                    <select class="form-control select2-tags" name="preferred_university_3" data-placeholder="Select or type university">
                        <option value=""></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $allInstituteList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($iName); ?>" <?php echo e(($preAssessment->preferred_university_3 ?? '') == $iName ? 'selected' : ''); ?>><?php echo e($iName); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label class="form-label">Course Link 3</label>
                    <input class="form-control" type="url" name="course_link_3" value="<?php echo e($preAssessment->course_link_3); ?>" placeholder="https://...">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Source of Funding</label>
                    <select class="form-select" name="source_of_funding" data-current-value="<?php echo e(old('source_of_funding', $preAssessment->source_of_funding ?? '')); ?>">
                      <option value="">Select...</option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $financialSourceOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($sf); ?>" <?php echo e($preAssessment->source_of_funding == $sf ? 'selected' : ''); ?>><?php echo e($sf); ?></option>
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                  </div>
                  <div class="col-12">
                    <label class="form-label">Bank Balance / Financial Details</label>
                    <textarea class="form-control" name="bank_balance_info" rows="3" placeholder="Optional: Provide bank balance or sponsorship details..."><?php echo e($student->bank_balance_info); ?></textarea>
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
                <?php $refCount = max(2, count($referees)); ?>
                <div id="referees-container">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i=0; $i<$refCount; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php $ref = $referees[$i] ?? new \App\Models\StudentReferee(); ?>
                    <div class="referee-card mb-3" id="ref-card-<?php echo e($i); ?>">
                      <div class="referee-header d-flex justify-content-between align-items-center">
                        <div>
                          <i class="fas fa-user-tie text-primary"></i> Referee <span class="ref-num"><?php echo e($i+1); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i >= 2): ?>
                          <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRefereeRow(<?php echo e($i); ?>)"><i class="fas fa-trash"></i></button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                      </div>
                      <div class="p-3 row g-2">
                        <input type="hidden" name="referees[<?php echo e($i); ?>][id]" value="<?php echo e($ref->id); ?>">
                        <div class="col-md-4">
                          <label class="form-label">Reference Type</label>
                          <select class="form-select" name="referees[<?php echo e($i); ?>][reference_type]">
                              <option value="" disabled <?php echo e(!$ref->reference_type ? 'selected' : ''); ?>>Select Type</option>
                              <option value="Academic" <?php echo e($ref->reference_type == 'Academic' ? 'selected' : ''); ?>>Academic</option>
                              <option value="Personal" <?php echo e($ref->reference_type == 'Personal' ? 'selected' : ''); ?>>Personal</option>
                              <option value="Professional" <?php echo e($ref->reference_type == 'Professional' ? 'selected' : ''); ?>>Professional</option>
                          </select>
                        </div>
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
                </div>
                <div class="text-end mb-4">
                  <button type="button" class="btn btn-sm btn-primary" onclick="addRefereeRow()"><i class="fas fa-plus me-1"></i> Add More Referee</button>
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
              
              <form id="form-documents">
                <?php echo csrf_field(); ?>
                <div id="documents-upload-container">
                  <?php
                    $mandatoryTypes = [];
                    $optionalTypes = [];
                    $selectedTypes = [];
                    if (is_array($mandatoryDocs)) {
                        foreach ($mandatoryDocs as $key => $val) {
                            if (is_numeric($key)) {
                                // Old style array
                                $mandatoryTypes[] = $val;
                                $selectedTypes[] = $val;
                            } else {
                                // New style associative array
                                if ($val === 'M') {
                                    $mandatoryTypes[] = $key;
                                    $selectedTypes[] = $key;
                                } elseif ($val === 'N') {
                                    $optionalTypes[] = $key;
                                    $selectedTypes[] = $key;
                                }
                            }
                        }
                    }
                    
                    // Filter out already uploaded types
                    $pendingMandatoryDocs = array_diff($mandatoryTypes, $uploadedDocTypes);
                    $pendingOptionalDocs = array_diff($optionalTypes, $uploadedDocTypes);
                    
                    // The add-more options are all docOptions EXCEPT those that were pre-populated (selected as M or N)
                    $addMoreOptions = array_diff($docOptions, $selectedTypes);
                    
                    $rowIndex = 0;
                  ?>

                  
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pendingMandatoryDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="row g-3 mb-3 doc-upload-row" id="doc-row-<?php echo e($rowIndex); ?>">
                      <div class="col-md-4">
                        <label class="form-label">Document Type</label>
                        <div class="form-control bg-light fw-bold text-dark" style="cursor: not-allowed;">
                            <?php echo e($docType); ?> <span class="text-danger">*</span>
                        </div>
                        <input type="hidden" name="documents[<?php echo e($rowIndex); ?>][type]" value="<?php echo e($docType); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Document Title</label>
                        <input class="form-control" type="text" name="documents[<?php echo e($rowIndex); ?>][title]" placeholder="e.g. My <?php echo e($docType); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Select File <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" name="documents[<?php echo e($rowIndex); ?>][file]" required>
                      </div>
                    </div>
                    <?php $rowIndex++; ?>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                  
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pendingOptionalDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="row g-3 mb-3 doc-upload-row" id="doc-row-<?php echo e($rowIndex); ?>">
                      <div class="col-md-4">
                        <label class="form-label">Document Type</label>
                        <div class="form-control bg-light text-dark" style="cursor: not-allowed;">
                            <?php echo e($docType); ?> <small class="text-muted">(Optional)</small>
                        </div>
                        <input type="hidden" name="documents[<?php echo e($rowIndex); ?>][type]" value="<?php echo e($docType); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Document Title</label>
                        <input class="form-control" type="text" name="documents[<?php echo e($rowIndex); ?>][title]" placeholder="e.g. My <?php echo e($docType); ?>">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Select File</label>
                        <input class="form-control" type="file" name="documents[<?php echo e($rowIndex); ?>][file]">
                      </div>
                    </div>
                    <?php $rowIndex++; ?>
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                  
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rowIndex === 0): ?>
                    <div class="row g-3 mb-3 doc-upload-row" id="doc-row-0">
                      <div class="col-md-4">
                        <label class="form-label">Document Type</label>
                        <select class="form-select" name="documents[0][type]">
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $addMoreOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Document Title</label>
                        <input class="form-control" type="text" name="documents[0][title]" placeholder="e.g. Additional Document">
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Select File</label>
                        <input class="form-control" type="file" name="documents[0][file]">
                      </div>
                    </div>
                    <?php $rowIndex = 1; ?>
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div class="mb-4">
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="addDocumentRow()"><i class="fas fa-plus"></i> Add More Document</button>
                  <button type="button" class="btn btn-sm btn-save ms-2" onclick="uploadMultipleDocs()">Upload Documents</button>
                </div>
              </form>

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
                <button type="button" class="btn btn-success ms-2" onclick="validateAndSubmitProfile()"><i class="fas fa-check-circle me-1"></i> Finish & Submit</button>
              </div>
            </div>

            <!-- ═══════════ TAB 7: Download Documents (Admin Uploaded) ═══════════ -->
            <div class="tab-section d-none" id="tab-7">
              <div class="section-title"><i class="fas fa-download text-primary"></i> Download Documents</div>
              <p class="text-muted fs--1 mb-3">Official letters, invoices and documents sent to you by the administration.</p>

              <!-- Section 1: Official Letters & Certificates -->
              <h6 class="fw-bold mb-3" style="color: #2c3e7a;"><i class="fas fa-envelope-open-text me-2 text-primary"></i>Official Letters & Certificates</h6>
              <div id="student-letters-list" class="mb-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $studentLetters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($letter->file_type === 'pdf'): ?>
                        <i class="fas fa-file-pdf text-danger fs-5"></i>
                      <?php else: ?>
                        <i class="fas fa-file-alt text-info fs-5"></i>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                      <div>
                        <div class="fw-600 fs--1"><?php echo e($letter->letter_title); ?></div>
                        <div class="text-500 fs--2">Sent: <?php echo e($letter->sent_at?->format('d M Y') ?? $letter->created_at->format('d M Y')); ?></div>
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($letter->file_type === 'pdf'): ?>
                        <a href="<?php echo e(route('student.letters.preview', $letter->id)); ?>" target="_blank" class="btn btn-xs btn-outline-info rounded-pill px-3">
                          <i class="fas fa-eye me-1"></i> Preview
                        </a>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                      <a href="<?php echo e(route('student.letters.download', $letter->id)); ?>" class="btn btn-xs btn-primary rounded-pill px-3" download>
                        <i class="fas fa-download me-1"></i> Download
                      </a>
                    </div>
                  </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                  <div class="text-center text-muted py-3 bg-light rounded-3 border"><i class="fas fa-inbox fs-4 mb-2 d-block"></i>No letters or certificates sent yet.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>

              <!-- Section 1.5: Official Invoices -->
              <h6 class="fw-bold mb-3 mt-4" style="color: #2c3e7a;"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>Official Invoices</h6>
              <div id="student-invoices-list" class="mb-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $studentInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->file_type === 'pdf'): ?>
                        <i class="fas fa-file-pdf text-danger fs-5"></i>
                      <?php else: ?>
                        <i class="fas fa-file-invoice text-success fs-5"></i>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                      <div>
                        <div class="fw-600 fs--1"><?php echo e($invoice->invoice_title); ?></div>
                        <div class="text-500 fs--2">Sent: <?php echo e($invoice->sent_at?->format('d M Y') ?? $invoice->created_at->format('d M Y')); ?></div>
                      </div>
                    </div>
                    <div class="d-flex gap-2">
                      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoice->file_type === 'pdf'): ?>
                        <a href="<?php echo e(route('student.invoices.preview', $invoice->id)); ?>" target="_blank" class="btn btn-xs btn-outline-info rounded-pill px-3">
                          <i class="fas fa-eye me-1"></i> Preview
                        </a>
                      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                      <a href="<?php echo e(route('student.invoices.download', $invoice->id)); ?>" class="btn btn-xs btn-primary rounded-pill px-3" download>
                        <i class="fas fa-download me-1"></i> Download
                      </a>
                    </div>
                  </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                  <div class="text-center text-muted py-3 bg-light rounded-3 border"><i class="fas fa-inbox fs-4 mb-2 d-block"></i>No invoices sent yet.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>

              <!-- Section 2: Other Admin Documents -->
              <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h6 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-folder-open me-2 text-success"></i>Admin Uploaded Files</h6>
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
                  <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-white rounded-3 border shadow-sm">
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
                  <div class="text-center text-muted py-3 bg-light rounded-3 border"><i class="fas fa-inbox fs-4 mb-2 d-block"></i>No files from admin yet.</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>

              <div class="mt-3">
                <?php echo e($adminDocuments->appends(request()->query())->fragment('tab-7')->links('pagination::bootstrap-5')); ?>

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
                <select class="form-select select2-tags" name="academics[${idx}][education_level]">
                    <option value="">Select...</option>
                    <?php $__currentLoopData = $qualificationOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($el); ?>"><?php echo e($el); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
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
                <input class="form-control" type="month" name="academics[${idx}][start_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">End Date</label>
                <input class="form-control" type="month" name="academics[${idx}][end_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Award Date</label>
                <input class="form-control" type="date" name="academics[${idx}][award_date]">
            </div>
            <div class="col-md-2">
                <label class="form-label">Result Type</label>
                <select class="form-select" name="academics[${idx}][result_type]" onchange="toggleOtherResultType(this)">
                    <option value="">Select...</option>
                    <option value="GPA">GPA</option>
                    <option value="CGPA">CGPA</option>
                    <option value="Percentage">Percentage</option>
                    <option value="Others">Others</option>
                </select>
            </div>
            <div class="col-md-2 other-result-type-div" style="display:none;">
                <label class="form-label">Other Type</label>
                <input class="form-control" type="text" name="academics[${idx}][other_result_type]" placeholder="Type here...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Result</label>
                <input class="form-control" type="text" name="academics[${idx}][result_percentage]" placeholder="Value">
            </div>
            <div class="col-md-2">
                <label class="form-label">Out of</label>
                <input class="form-control" type="text" name="academics[${idx}][result_out_of]" placeholder="e.g. 100 or 4.0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Country</label>
                <select class="form-control select2-tags" name="academics[${idx}][country]" data-placeholder="Select country">
                    <option value=""></option>
                    <?php $__currentLoopData = $countriesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c); ?>"><?php echo e($c); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">City</label>
                <select class="form-control select2-tags" name="academics[${idx}][city]" data-placeholder="Select city">
                    <option value=""></option>
                    <?php $__currentLoopData = $citiesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c); ?>"><?php echo e($c); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Zip Code</label>
                <input class="form-control" type="text" name="academics[${idx}][zip_code]">
            </div>
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <input class="form-control" type="text" name="academics[${idx}][institution_address]">
            </div>
        </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);

    // Initialize Select2 on the newly added row
    $(`#aca-row-${idx} .select2-tags`).select2({
        tags: true,
        placeholder: "Select from dropdown or type your own",
        allowClear: true,
        width: '100%'
    });
}

function removeAcademicRow(idx) {
    const row = document.getElementById('aca-row-' + idx);
    if (row) row.remove();
}

let refIdx = <?php echo e(max(2, count($referees))); ?>;
function addRefereeRow() {
    const container = document.getElementById('referees-container');
    const idx = refIdx++;
    const html = `
    <div class="referee-card mb-3" id="ref-card-${idx}">
      <div class="referee-header d-flex justify-content-between align-items-center">
        <div>
          <i class="fas fa-user-tie text-primary"></i> Referee <span class="ref-num">${idx + 1}</span>
        </div>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRefereeRow(${idx})"><i class="fas fa-trash"></i></button>
      </div>
      <div class="p-3 row g-2">
        <input type="hidden" name="referees[${idx}][id]" value="">
        <div class="col-md-4">
          <label class="form-label">Reference Type</label>
          <select class="form-select" name="referees[${idx}][reference_type]">
              <option value="" disabled selected>Select Type</option>
              <option value="Academic">Academic</option>
              <option value="Personal">Personal</option>
              <option value="Professional">Professional</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Full Name</label>
          <input class="form-control" type="text" name="referees[${idx}][full_name]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Job Title</label>
          <input class="form-control" type="text" name="referees[${idx}][job_title]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Relationship</label>
          <input class="form-control" type="text" name="referees[${idx}][relationship]" value="" placeholder="e.g. Lecturer, Manager">
        </div>
        <div class="col-md-4">
          <label class="form-label">Email</label>
          <input class="form-control" type="email" name="referees[${idx}][email]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Mobile / Phone</label>
          <input class="form-control" type="text" name="referees[${idx}][mobile]" value="">
        </div>
        <div class="col-md-4">
          <label class="form-label">How Long Known?</label>
          <input class="form-control" type="text" name="referees[${idx}][how_long_known]" value="" placeholder="e.g. 3 years">
        </div>
        <div class="col-md-6">
          <label class="form-label">Organization Name</label>
          <input class="form-control" type="text" name="referees[${idx}][organization_name]" value="">
        </div>
        <div class="col-md-6">
          <label class="form-label">Organization Address</label>
          <input class="form-control" type="text" name="referees[${idx}][organization_address]" value="">
        </div>
      </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    updateRefereeNumbers();
}

function removeRefereeRow(idx) {
    const row = document.getElementById('ref-card-' + idx);
    if (row) row.remove();
    updateRefereeNumbers();
}

function updateRefereeNumbers() {
    const cards = document.querySelectorAll('#referees-container .referee-card');
    cards.forEach((card, index) => {
        const numSpan = card.querySelector('.ref-num');
        if (numSpan) numSpan.textContent = index + 1;
    });
}

let docIdx = <?php echo e($rowIndex); ?>;
function addDocumentRow() {
    const container = document.getElementById('documents-upload-container');
    const idx = docIdx++;
    
    // Dynamic document options for Add More from PHP
    const addMoreOptions = <?php echo json_encode(array_values($addMoreOptions), 15, 512) ?>;
    
    let optionsHtml = '';
    addMoreOptions.forEach(opt => {
        optionsHtml += `<option value="${opt}">${opt}</option>`;
    });

    const html = `
    <div class="row g-3 mb-3 doc-upload-row" id="doc-row-${idx}">
      <div class="col-md-4">
        <label class="form-label">Document Type</label>
        <select class="form-select" name="documents[${idx}][type]">
          ${optionsHtml}
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Document Title</label>
        <input class="form-control" type="text" name="documents[${idx}][title]" placeholder="e.g. Additional Document">
      </div>
      <div class="col-md-3">
        <label class="form-label">Select File</label>
        <input class="form-control" type="file" name="documents[${idx}][file]">
      </div>
      <div class="col-md-1 d-flex align-items-end">
        <button type="button" class="btn btn-outline-danger w-100 px-2" onclick="removeDocumentRow(${idx})"><i class="fas fa-trash"></i></button>
      </div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}

function removeDocumentRow(idx) {
    const row = document.getElementById('doc-row-' + idx);
    if (row) row.remove();
}

function uploadMultipleDocs() {
    const form = document.getElementById('form-documents');
    const formData = new FormData(form);
    
    // Check if at least one file is selected
    let hasFile = false;
    for (let [key, value] of formData.entries()) {
        if (value instanceof File && value.name !== '') {
            hasFile = true;
            break;
        }
    }
    
    if (!hasFile) {
        showToast('Please select at least one file to upload.', false);
        return;
    }

    const btns = form.querySelectorAll('button');
    btns.forEach(b => b.disabled = true);

    fetch('<?php echo e(route('student.profile.upload')); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, true);
            setTimeout(() => {
                window.location.href = window.location.pathname + '?tab=6#tab-6';
                window.location.reload();
            }, 1000);
        } else {
            showToast(data.message, false);
        }
    })
    .catch(() => showToast('Upload failed. Try again.', false))
    .finally(() => {
        btns.forEach(b => b.disabled = false);
    });
}

function toggleOtherResultType(selectElement) {
    const row = selectElement.closest('.row');
    const otherDiv = row.querySelector('.other-result-type-div');
    if (selectElement.value === 'Others') {
        otherDiv.style.display = '';
    } else {
        otherDiv.style.display = 'none';
        otherDiv.querySelector('input').value = '';
    }
}

function uploadHeaderProfilePicture(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('profile_picture', input.files[0]);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        fetch('<?php echo e(route('student.profile.personal')); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Profile picture updated successfully!', true);
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('header-avatar-img');
                    if (img) {
                        img.src = e.target.result;
                    } else {
                        const placeholder = document.getElementById('header-avatar-placeholder');
                        if (placeholder) {
                            placeholder.outerHTML = '<img id="header-avatar-img" class="rounded-circle w-100 h-100" src="'+e.target.result+'" alt="Profile Picture" style="object-fit: cover;">';
                        }
                    }
                    setTimeout(() => window.location.reload(), 1500); 
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                showToast(data.message || 'Failed to update picture', false);
            }
        })
        .catch(error => {
            showToast('Error uploading picture', false);
        });
    }
}

function toggleStudentTravelHistoryFields(show) {
    const fieldsDiv = document.getElementById('student_travel_history_fields');
    if (!fieldsDiv) return;
    fieldsDiv.style.display = show ? 'block' : 'none';
    
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

function toggleStudentVisaRefusalFields(show) {
    const fieldsDiv = document.getElementById('student_visa_refusal_fields');
    if (!fieldsDiv) return;
    fieldsDiv.style.display = show ? 'block' : 'none';
    
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

const studentImmCountryChk = document.getElementById('student_imm_country_chk');
function toggleStudentImmigrationNone(isNoneChecked) {
    if (isNoneChecked) {
        if (studentImmCountryChk) studentImmCountryChk.checked = false;
    } else {
        const noneChk = document.getElementById('student_imm_none_chk');
        if (noneChk) noneChk.checked = false;
    }
}

let studentTravelIndex = <?php echo e(count($travelEntries)); ?>;
function addStudentTravelRow() {
    const container = document.getElementById('student_travel_history_container');
    if (!container) return;

    const rowDiv = document.createElement('div');
    rowDiv.className = 'student-travel-row bg-white p-3 border rounded-3 mb-3';
    rowDiv.id = `student_travel_row_${studentTravelIndex}`;

    const countriesOptions = `<?php $__currentLoopData = \App\Models\Country::where('status', 'active')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->name); ?>"><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;

    rowDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 fw-semibold text-primary"><i class="fas fa-plane me-1"></i> Travel Entry #<span class="student-travel-entry-num"></span></h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-student-travel-btn" onclick="removeStudentTravelRow(${studentTravelIndex})">
                <i class="fas fa-times me-1"></i> Remove
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label font-12">Date of Arrival <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="travel_history[entries][${studentTravelIndex}][arrival_date]">
            </div>
            <div class="col-md-3">
                <label class="form-label font-12">Date of Departure <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="travel_history[entries][${studentTravelIndex}][departure_date]">
            </div>
            <div class="col-md-3">
                <label class="form-label font-12">Visa Start Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="travel_history[entries][${studentTravelIndex}][visa_start_date]">
            </div>
            <div class="col-md-3">
                <label class="form-label font-12">Visa Expiry Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="travel_history[entries][${studentTravelIndex}][visa_expiry_date]">
            </div>
            <div class="col-md-4">
                <label class="form-label font-12">Purpose of Visit <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="travel_history[entries][${studentTravelIndex}][purpose_of_visit]" placeholder="e.g. Tourism, Study, Work">
            </div>
            <div class="col-md-4">
                <label class="form-label font-12">Country <span class="text-danger">*</span></label>
                <select class="form-select select2-tags" name="travel_history[entries][${studentTravelIndex}][country]" data-placeholder="Select country">
                    <option value="">Select Country...</option>
                    ${countriesOptions}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label font-12">Visa Type <span class="text-danger">*</span></label>
                <select class="form-select" name="travel_history[entries][${studentTravelIndex}][visa_type]">
                    <option value="">Select Visa Type...</option>
                    <option value="Tourist Visa">Tourist Visa</option>
                    <option value="Student Visa">Student Visa</option>
                    <option value="Work Visa">Work Visa</option>
                    <option value="Business Visa">Business Visa</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
    `;

    container.appendChild(rowDiv);
    studentTravelIndex++;
    updateStudentTravelRowIndices();
    
    $(rowDiv).find('.select2-tags').select2({
        tags: true,
        placeholder: "Select country",
        width: '100%'
    });
}

function removeStudentTravelRow(index) {
    const row = document.getElementById(`student_travel_row_${index}`);
    if (row) {
        row.remove();
        updateStudentTravelRowIndices();
    }
}

function updateStudentTravelRowIndices() {
    const rows = document.querySelectorAll('.student-travel-row');
    rows.forEach((row, i) => {
        const numSpan = row.querySelector('.student-travel-entry-num');
        if (numSpan) numSpan.textContent = i + 1;
        const removeBtn = row.querySelector('.remove-student-travel-btn');
        if (removeBtn) {
            removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }
    });
}

let studentRefusalIndex = <?php echo e(count($refusalEntries)); ?>;
function addStudentRefusalRow() {
    const container = document.getElementById('student_visa_refusal_container');
    if (!container) return;

    const rowDiv = document.createElement('div');
    rowDiv.className = 'student-refusal-row bg-white p-3 border rounded-3 mb-3';
    rowDiv.id = `student_refusal_row_${studentRefusalIndex}`;

    const countriesOptions = `<?php $__currentLoopData = \App\Models\Country::where('status', 'active')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c->name); ?>"><?php echo e($c->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>`;

    rowDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0 fw-semibold text-danger"><i class="fas fa-ban me-1"></i> Refusal Entry #<span class="student-refusal-entry-num"></span></h6>
            <button type="button" class="btn btn-outline-danger btn-sm remove-student-refusal-btn" onclick="removeStudentRefusalRow(${studentRefusalIndex})">
                <i class="fas fa-times me-1"></i> Remove
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label font-12">Refusal Type <span class="text-danger">*</span></label>
                <select class="form-select" name="visa_refusals[entries][${studentRefusalIndex}][refusal_type]">
                    <option value="">Select Refusal Type...</option>
                    <option value="Visa Refusal">Visa Refusal</option>
                    <option value="Refused Entry">Refused Entry</option>
                    <option value="Deported">Deported</option>
                    <option value="Refused Leave to Remain">Refused Leave to Remain</option>
                    <option value="Refused Asylum">Refused Asylum</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label font-12">Date of Refusal <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="visa_refusals[entries][${studentRefusalIndex}][refusal_date]">
            </div>
            <div class="col-md-4">
                <label class="form-label font-12">Country <span class="text-danger">*</span></label>
                <select class="form-select select2-tags" name="visa_refusals[entries][${studentRefusalIndex}][country]" data-placeholder="Select country">
                    <option value="">Select Country...</option>
                    ${countriesOptions}
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label font-12">Visa Type <span class="text-danger">*</span></label>
                <select class="form-select" name="visa_refusals[entries][${studentRefusalIndex}][visa_type]">
                    <option value="">Select Visa Type...</option>
                    <option value="Tourist Visa">Tourist Visa</option>
                    <option value="Student Visa">Student Visa</option>
                    <option value="Work Visa">Work Visa</option>
                    <option value="Business Visa">Business Visa</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label font-12">Details / Reason <span class="text-danger">*</span></label>
                <textarea class="form-control" name="visa_refusals[entries][${studentRefusalIndex}][details]" rows="2" placeholder="Provide details or reason for refusal..."></textarea>
            </div>
        </div>
    `;

    container.appendChild(rowDiv);
    studentRefusalIndex++;
    updateStudentRefusalRowIndices();

    $(rowDiv).find('.select2-tags').select2({
        tags: true,
        placeholder: "Select country",
        width: '100%'
    });
}

function removeStudentRefusalRow(index) {
    const row = document.getElementById(`student_refusal_row_${index}`);
    if (row) {
        row.remove();
        updateStudentRefusalRowIndices();
    }
}

function updateStudentRefusalRowIndices() {
    const rows = document.querySelectorAll('.student-refusal-row');
    rows.forEach((row, i) => {
        const numSpan = row.querySelector('.student-refusal-entry-num');
        if (numSpan) numSpan.textContent = i + 1;
        const removeBtn = row.querySelector('.remove-student-refusal-btn');
        if (removeBtn) {
            removeBtn.style.display = rows.length > 1 ? 'inline-block' : 'none';
        }
    });
}

// Initial state checks on load
document.addEventListener('DOMContentLoaded', function() {
    const travelYes = document.getElementById('student_travel_yes');
    if (travelYes) {
        toggleStudentTravelHistoryFields(travelYes.checked);
    }
    const refusalYes = document.getElementById('student_refusal_yes');
    if (refusalYes) {
        toggleStudentVisaRefusalFields(refusalYes.checked);
    }
});

function validateAndSubmitProfile() {
    const mandatoryDocs = <?php echo json_encode($mandatoryDocs, 15, 512) ?>;
    const uploadedDocTypes = <?php echo json_encode($uploadedDocTypes, 15, 512) ?>;
    
    // Extract mandatory docs (where value is 'M' or if it is an array containing the doc)
    let mandatoryTypes = [];
    if (mandatoryDocs) {
        if (Array.isArray(mandatoryDocs)) {
            // Fallback for old style array data
            mandatoryTypes = mandatoryDocs;
        } else {
            // New style associative array
            for (const [docType, status] of Object.entries(mandatoryDocs)) {
                if (status === 'M') {
                    mandatoryTypes.push(docType);
                }
            }
        }
    }
    
    // Ensure all mandatory docs are present in the uploaded docs
    let missingDocs = [];
    mandatoryTypes.forEach(docType => {
        if (!uploadedDocTypes.includes(docType)) {
            missingDocs.push(docType);
        }
    });
    
    if (missingDocs.length > 0) {
        showToast('You must upload the following mandatory documents before submitting: ' + missingDocs.join(', '), false);
        switchTab(6); // Go back to documents tab
        return;
    }
    
    // If validation passes, go to dashboard
    window.location.href = "<?php echo e(route('dashboard')); ?>";
}
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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

    // Real-time option sync across Preferred Courses 1, 2, 3
    $(document).on('select2:select', 'select[name="intended_course"], select[name="preferred_course_2"], select[name="preferred_course_3"]', function(e) {
        const val = e.params && e.params.data ? e.params.data.id : null;
        if (!val) return;
        ['intended_course', 'preferred_course_2', 'preferred_course_3'].forEach(name => {
            const $target = $(`select[name="${name}"]`);
            if ($target.length && !$target.find(`option[value="${CSS.escape(val)}"]`).length) {
                const opt = new Option(val, val, false, false);
                $target.append(opt).trigger('change.select2');
            }
        });
    });

    // Real-time option sync across Preferred Universities 1, 2, 3
    $(document).on('select2:select', 'select[name="institute_name"], select[name="preferred_university_2"], select[name="preferred_university_3"]', function(e) {
        const val = e.params && e.params.data ? e.params.data.id : null;
        if (!val) return;
        ['institute_name', 'preferred_university_2', 'preferred_university_3'].forEach(name => {
            const $target = $(`select[name="${name}"]`);
            if ($target.length && !$target.find(`option[value="${CSS.escape(val)}"]`).length) {
                const opt = new Option(val, val, false, false);
                $target.append(opt).trigger('change.select2');
            }
        });
    });

    $(document).on('change', '#sameAsCurrentAddress', function() {
        const permAddrInput = $('input[name="permanent_address"]');
        const permPostInput = $('input[name="permanent_postcode"]');
        const permCountrySelect = $('select[name="permanent_country"]');
        const permStateSelect = $('select[name="permanent_state"]');
        const permCitySelect = $('select[name="permanent_city"]');

        if (this.checked) {
            const currAddr = $('input[name="current_address"]').val() || '';
            const currPost = $('input[name="current_postcode"]').val() || '';
            const currCountry = $('select[name="current_country"]').val() || '';
            const currState = $('select[name="current_state"]').val() || '';
            const currCity = $('select[name="current_city"]').val() || '';

            permAddrInput.val(currAddr);
            permPostInput.val(currPost);

            if (permCountrySelect.length && currCountry) {
                permCountrySelect.val(currCountry).trigger('change');
                if (permCountrySelect[0]) permCountrySelect[0].dispatchEvent(new Event('change', { bubbles: true }));
            }
            setTimeout(function() {
                if (permStateSelect.length && currState) {
                    permStateSelect.val(currState).trigger('change');
                    if (permStateSelect[0]) permStateSelect[0].dispatchEvent(new Event('change', { bubbles: true }));
                }
                setTimeout(function() {
                    if (permCitySelect.length && currCity) {
                        permCitySelect.val(currCity).trigger('change');
                        if (permCitySelect[0]) permCitySelect[0].dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }, 350);
            }, 350);
        } else {
            permAddrInput.val('');
            permPostInput.val('');

            if (permCountrySelect.length) {
                permCountrySelect.val('').trigger('change');
                if (permCountrySelect[0]) permCountrySelect[0].dispatchEvent(new Event('change', { bubbles: true }));
            }
            if (permStateSelect.length) {
                permStateSelect.val('').trigger('change');
                if (permStateSelect[0]) permStateSelect[0].dispatchEvent(new Event('change', { bubbles: true }));
            }
            if (permCitySelect.length) {
                permCitySelect.val('').trigger('change');
                if (permCitySelect[0]) permCitySelect[0].dispatchEvent(new Event('change', { bubbles: true }));
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\student\student_profile.blade.php ENDPATH**/ ?>
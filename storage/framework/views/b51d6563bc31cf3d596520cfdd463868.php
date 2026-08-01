<nav class="navbar navbar-light navbar-vertical navbar-expand-xl" style="display: none;">
    <script>
        var navbarStyle = localStorage.getItem("navbarStyle");
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="d-flex align-items-center">
        <div class="toggle-icon-wrapper">
            <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
        </div>
        <a class="navbar-brand" href="index.html">
            <div class="d-flex align-items-center py-3"><img class="me-2"
                    src="<?php echo e(asset('contents/backend/assets/img/icons/spot-illustrations/falcon.png')); ?>" alt=""
                    width="40" /><span class="font-sans-serif text-primary">iLap</span></div>
        </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content scrollbar">
            <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                <?php
                    $isApprovedStudent = true;
                    $isStudent = false;
                    if(Auth::check() && Auth::user()->hasRole('Student')) {
                        $isStudent = true;
                        $student = Auth::user()->student;
                        if(!$student || !$student->preAssessment || $student->preAssessment->assessment_status !== 'approved' || !$student->enrolment_status) {
                            $isApprovedStudent = false;
                        }
                    }
                ?>

                <!-- ==================== Dashboard ==================== -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isStudent || $isApprovedStudent): ?>
                <li class="nav-item mb-1">
                    <a class="nav-link" href="<?php echo e(route('dashboard')); ?>" role="button">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('hasrole', 'Student')): ?>
                <!-- ==================== Student Space ==================== -->
                <li class="nav-item">
                    <!-- label-->
                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Student Space</div>
                        <div class="col ps-0"><hr class="mb-0 navbar-vertical-divider" /></div>
                    </div>
                    
                    <!-- Dashboard -->
                    <a class="nav-link" href="<?php echo e($isApprovedStudent ? route('student.dashboard') : route('pre.assessment.index')); ?>" role="button">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-home"></span></span>
                            <span class="nav-link-text ps-1">Dashboard</span>
                        </div>
                    </a>


                    <!-- Pre Assessment -->
                    <a class="nav-link" href="<?php echo e(route('pre.assessment.index')); ?>" role="button">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-clipboard-list"></span></span>
                            <span class="nav-link-text ps-1">My Pre-Assessment</span>
                        </div>
                    </a>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('hasrole', 'Student')): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isApprovedStudent): ?>
                <!-- ==================== Student Profile ==================== -->
                <li class="nav-item mb-4">
                    <a class="nav-link dropdown-indicator" href="#student-profile" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="student-profile">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-user-circle"></span></span>
                            <span class="nav-link-text ps-1">Student Info</span>
                        </div>
                    </a>
                    <ul class="nav collapse show" id="student-profile">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('student.profile')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-id-card fa-xs me-1 text-muted"></i> View My Profile</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item mt-2 mb-1">
                            <div class="nav-link-text ps-3 text-uppercase text-muted" style="font-size: 0.75rem; font-weight: 600;"><i class="fas fa-user-edit me-1"></i>Update Information</div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link student-tab-link" href="<?php echo e(route('student.profile.edit')); ?>#tab-0" data-tab="0" onclick="handleStudentTabClick(event, 0)">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-user fa-xs me-1 text-muted"></i> Personal Info</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link student-tab-link" href="<?php echo e(route('student.profile.edit')); ?>#tab-1" data-tab="1" onclick="handleStudentTabClick(event, 1)">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-map-marker-alt fa-xs me-1 text-muted"></i> Address & Contacts</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link student-tab-link" href="<?php echo e(route('student.profile.edit')); ?>#tab-2" data-tab="2" onclick="handleStudentTabClick(event, 2)">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-plane fa-xs me-1 text-muted"></i> Travel & English</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link student-tab-link" href="<?php echo e(route('student.profile.edit')); ?>#tab-3" data-tab="3" onclick="handleStudentTabClick(event, 3)">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-graduation-cap fa-xs me-1 text-muted"></i> Academic History</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link student-tab-link" href="<?php echo e(route('student.profile.edit')); ?>#tab-4" data-tab="4" onclick="handleStudentTabClick(event, 4)">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-book-open fa-xs me-1 text-muted"></i> Course Preferences</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link student-tab-link" href="<?php echo e(route('student.profile.edit')); ?>#tab-5" data-tab="5" onclick="handleStudentTabClick(event, 5)">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1"><i class="fas fa-users fa-xs me-1 text-muted"></i> Referees</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- Documents -->
                    <a class="nav-link student-tab-link mt-2" href="<?php echo e(route('student.profile.edit')); ?>#tab-6" data-tab="6" onclick="handleStudentTabClick(event, 6)">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-folder-open"></span></span>
                            <span class="nav-link-text ps-1">Upload Documents</span>
                        </div>
                    </a>
                    <!--Download Documents -->
                    <a class="nav-link student-tab-link mt-2" href="<?php echo e(route('student.profile.edit')); ?>#tab-7" data-tab="7" onclick="handleStudentTabClick(event, 7)">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-download"></span></span>
                            <span class="nav-link-text ps-1">DownIoad Documents</span>
                        </div>
                    </a>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                 <!-- ==================== Campus Config ==================== -->
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['campus view', 'campus add'])): ?>
                 <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#configuration" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="configuration">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-building"></span></span>
                            <span class="nav-link-text ps-1">Configuration</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="configuration">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('countries.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Countries</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('states.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Divisions/State</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                             <a class="nav-link" href="<?php echo e(route('cities.index')); ?>">
                                 <div class="d-flex align-items-center">
                                     <span class="nav-link-text ps-1">Districts/City</span>
                                 </div>
                             </a>
                         </li>
                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (\Illuminate\Support\Facades\Blade::check('hasanyrole', 'Super Admin|Admin')): ?>
                         <li class="nav-item">
                             <a class="nav-link" href="<?php echo e(route('admin.config.dropdown.index')); ?>">
                                 <div class="d-flex align-items-center">
                                     <span class="nav-link-text ps-1">Dropdown Options</span>
                                 </div>
                             </a>
                         </li>
                         <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- ==================== Campus Config ==================== -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['campus view', 'campus add'])): ?>
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#campus" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="campus">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-building"></span></span>
                            <span class="nav-link-text ps-1">Campus Mgt</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="campus">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campus view')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('campuses.index')); ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">All Campuses</span>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('campus add')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('campuses.create')); ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">Add New Campuses</span>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isStudent): ?>
                <!-- ==================== Pre-Assessment ==================== -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.pre.assessments.index')); ?>">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-file-signature"></span></span>
                            <span class="nav-link-text ps-1">Pre-Assessments</span>
                        </div>
                    </a>
                </li>

                <!-- ==================== Enrolment Details ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#students" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="students">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-user-graduate"></span></span>
                            <span class="nav-link-text ps-1">Students</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="students">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('student view')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('admin.students.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Pre-Enrolment</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('admin.students.enrolled')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Enrolled Students</span>
                                </div>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">New Applications</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Multi-Program Students</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Enrolment Pipeline</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ==================== Document ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#docuemnts" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="docuemnts">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-folder-open"></span></span>
                            <span class="nav-link-text ps-1">Documents</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="docuemnts">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Upload Center</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Dropbox Sync Status</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Student Documents</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Exchange</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Verification</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Templates</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ==================== Letter Generate ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#letter" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="letter">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-envelope-open-text"></span></span>
                            <span class="nav-link-text ps-1">Letter Generate</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="letter">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.letter-templates.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.letter-templates.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Letter Templates</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.tags.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.tags.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Tag List</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('admin/config/dropdown-options/letter_type*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.config.dropdown.category', 'letter_type')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Template Types</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.official-signatures.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.official-signatures.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Signatures & Seals</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.letters.history') ? 'active' : ''); ?>" href="<?php echo e(route('admin.letters.history')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Letter History</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ==================== Invoice Generate ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#invoice_gen" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="invoice_gen">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-file-invoice-dollar"></span></span>
                            <span class="nav-link-text ps-1">Invoice Generate</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="invoice_gen">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.invoice-templates.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.invoice-templates.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Invoice Templates</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->is('admin/config/dropdown-options/invoice_type*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.config.dropdown.category', 'invoice_type')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Template Types</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.students.enrolled') ? 'active' : ''); ?>" href="<?php echo e(route('admin.students.enrolled')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Generate Invoices</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.invoices.history') ? 'active' : ''); ?>" href="<?php echo e(route('admin.invoices.history')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Invoice History</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user view', 'permission view', 'role view'])): ?>
                <li class="nav-item">
                    <!-- ==================== User & Role ==================== -->
                    <a class="nav-link dropdown-indicator" href="#user_role" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="user_role">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-users-cog"></span></span>
                            <span class="nav-link-text ps-1">User & Role</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="user_role">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user view')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('users.index')); ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">All Users</span>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('permission view')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('permissions.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Permissions</span>
                                </div>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('role view')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('roles.index')); ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">Roles</span>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user view')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Staff Management</span>
                                </div>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['agent view', 'commission view'])): ?>
                <li class="nav-item">
                    <!-- ==================== Agent Management ==================== -->
                    <a class="nav-link dropdown-indicator" href="#agent" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="agent">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-users-cog"></span></span>
                            <span class="nav-link-text ps-1">Agent Management</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="agent">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('agent view')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('agents.index')); ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-text ps-1">All Agent</span>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('commission view')): ?>
                            <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('commissions.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Agent Commission</span>
                                </div>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ==================== Courses & Academic ==================== -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((Auth::check() && Auth::user()->canany(['course view', 'institute view'])) || $isStudent): ?>
                <li class="nav-item">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course view')): ?>
                    <a class="nav-link dropdown-indicator" href="#ilap_course" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="ilap_course">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-book-open"></span></span>
                            <span class="nav-link-text ps-1">Courses</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="ilap_course">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('courses.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Course List</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if((Auth::check() && Auth::user()->can('institute view')) || $isStudent): ?>
                    <a class="nav-link dropdown-indicator" href="#institute" role="button"
                        data-bs-toggle="collapse" aria-expanded="false" aria-controls="institute">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-university"></span></span>
                            <span class="nav-link-text ps-1">Institute</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="institute">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('institutes.index')); ?>">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">All Institute</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('course view')): ?>
                    <a class="nav-link dropdown-indicator" href="#academic" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="academic">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-award"></span></span>
                            <span class="nav-link-text ps-1">Academic Results</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="academic">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Results</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Transcript</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Certificate</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <!-- ==================== Finance ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#finance" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="finance">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-wallet"></span></span>
                            <span class="nav-link-text ps-1">Finance</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="finance">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Invoices</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Payment Approvals</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Fee Management</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Fee Collection Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Installment Plans</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Due Fee Reminders</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Support ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#support" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="support">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-headset"></span></span>
                            <span class="nav-link-text ps-1">Support</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="support">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">All Tickets</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Create Ticket</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">My Assigned Tickets</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== Report ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#report" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="report">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-chart-bar"></span></span>
                            <span class="nav-link-text ps-1">Report</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="report">
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Dashboard Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Student Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Financial Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Document Reports</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Support Reports</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- ==================== SYSTEM SETTINGS ==================== -->
                <li class="nav-item">
                    <a class="nav-link dropdown-indicator" href="#setting" role="button" data-bs-toggle="collapse"
                        aria-expanded="false" aria-controls="setting">
                        <div class="d-flex align-items-center">
                            <span class="nav-link-icon"><span class="fas fa-chart-bar"></span></span>
                            <span class="nav-link-text ps-1">System Settings</span>
                        </div>
                    </a>
                    <ul class="nav collapse" id="setting">
                        <li class="nav-item">
                            <a class="nav-link" href="">    
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">General Settings</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Email Configuration</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Payment Gateway</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">Audit Logs</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\laragon\www\iLap\resources\views\backend\admin_component\navbar1_verticale.blade.php ENDPATH**/ ?>
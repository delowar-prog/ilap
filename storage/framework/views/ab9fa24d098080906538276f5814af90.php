<?php $__env->startSection('title', 'All Students'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-users text-primary me-2"></i> All Students</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.students.index', ['status' => 'pending'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'pending' ? 'active' : ''); ?>">
                            <i class="mdi mdi-clock-outline me-1"></i> Pending
                            <span class="badge bg-danger rounded-pill ms-1"><?php echo e($counts['pending']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.students.index', ['status' => 'approved'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'approved' ? 'active' : ''); ?>">
                            <i class="mdi mdi-check-circle-outline me-1"></i> Approved (Unassigned)
                            <span class="badge bg-success rounded-pill ms-1"><?php echo e($counts['approved']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.students.index', ['status' => 'assigned'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'assigned' ? 'active' : ''); ?>">
                            <i class="mdi mdi-school-outline me-1"></i> Course Assigned
                            <span class="badge bg-info rounded-pill ms-1"><?php echo e($counts['assigned']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.students.index', ['status' => 'rejected'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'rejected' ? 'active' : ''); ?>">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Rejected
                            <span class="badge bg-warning rounded-pill ms-1"><?php echo e($counts['rejected']); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.students.index', ['status' => 'terminated'])); ?>" 
                           class="nav-link rounded-0 <?php echo e($status == 'terminated' ? 'active' : ''); ?>">
                            <i class="mdi mdi-account-off-outline me-1"></i> Terminated
                            <span class="badge bg-dark rounded-pill ms-1"><?php echo e($counts['terminated'] ?? 0); ?></span>
                        </a>
                    </li>
                </ul>

                
                <form method="GET" action="<?php echo e(route('admin.students.index')); ?>" class="mb-3">
                    <input type="hidden" name="status" value="<?php echo e($status); ?>">
                    <input type="hidden" name="sort_by" value="<?php echo e($sortBy); ?>">
                    <input type="hidden" name="sort_dir" value="<?php echo e($sortDir); ?>">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_st" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [10, 20, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($n); ?>" <?php echo e($perPage == $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <span class="text-muted" style="font-size:0.82rem;">entries</span>

                            <select name="sort_dir" class="form-select form-select-sm ms-2" style="width:160px;" onchange="this.form.submit()">
                                <option value="desc" <?php echo e($sortDir == 'desc' ? 'selected' : ''); ?>>Newest First (DESC)</option>
                                <option value="asc" <?php echo e($sortDir == 'asc' ? 'selected' : ''); ?>>Oldest First (ASC)</option>
                            </select>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group" style="width:300px;">
                                <span class="input-group-text bg-white" style="border-right:0;"><i class="fas fa-search text-muted" style="font-size:0.8rem;"></i></span>
                                <input type="text" name="search" class="form-control form-control-sm border-start-0"
                                       placeholder="Search name, email, phone, ID..."
                                       value="<?php echo e($search); ?>" style="box-shadow:none;">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary px-3">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?>
                                <a href="<?php echo e(route('admin.students.index', ['status' => $status, 'per_page' => $perPage])); ?>"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="min-height: 350px;">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="bg-light text-muted">
                            <tr>
                                <?php
                                    function stSort($col, $label, $sortBy, $sortDir, $status, $search, $perPage, $route = 'admin.students.index') {
                                        $dir = ($sortBy === $col && $sortDir === 'asc') ? 'desc' : 'asc';
                                        $icon = $sortBy === $col ? ($sortDir === 'asc' ? '▲' : '▼') : '⇅';
                                        $url = route($route, compact('status', 'search', 'perPage') + ['sort_by' => $col, 'sort_dir' => $dir]);
                                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} <small>{$icon}</small></a>";
                                    }
                                ?>
                                <th>#</th>
                                <th><?php echo stSort('student_id', 'Student ID', $sortBy, $sortDir, $status, $search, $perPage); ?></th>
                                <th><?php echo stSort('first_name', 'Name', $sortBy, $sortDir, $status, $search, $perPage); ?></th>
                                <th>Campus</th>
                                <th><?php echo stSort('phone', 'Phone', $sortBy, $sortDir, $status, $search, $perPage); ?></th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                <td><?php echo e($loop->iteration + $students->firstItem() - 1); ?></td>
                                <td><span class="badge bg-secondary"><?php echo e($student->student_id); ?></span></td>
                                <td>
                                    <strong><?php echo e(trim($student->first_name.' '.$student->surname)); ?></strong>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->nationality): ?>
                                    <br><small class="text-muted"><?php echo e($student->nationality); ?></small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->campus): ?>
                                        <span class="badge bg-info text-dark"><?php echo e($student->campus->name); ?></span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td><?php echo e($student->phone ?? '-'); ?></td>
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($status === 'assigned'): ?>
                                        <span class="badge bg-info">Assigned</span>
                                    <?php elseif($student->enrolment_status === 'approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php elseif($student->enrolment_status === 'rejected'): ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="text-center">
                                     <div class="d-flex align-items-center justify-content-center gap-1">
                                         <a href="<?php echo e(route('admin.students.show', $student->id)); ?>" class="btn btn-xs btn-outline-info" data-bs-toggle="tooltip" title="View Profile">
                                             <i class="fas fa-eye"></i>
                                         </a>
                                         
                                         <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->enrolment_status === 'pending'): ?>
                                             <button type="button" class="btn btn-xs btn-outline-success btn-approve-enrol" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>" data-bs-toggle="tooltip" title="Approve">
                                                 <i class="fas fa-check"></i>
                                             </button>
                                             <button type="button" class="btn btn-xs btn-outline-danger btn-reject-enrol" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>" data-bs-toggle="tooltip" title="Reject">
                                                 <i class="fas fa-times"></i>
                                             </button>
                                         <?php elseif($student->enrolment_status === 'approved'): ?>
                                             <?php $completion = $student->getCompletionPercentage(); ?>
                                             <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($student->applications->isEmpty()): ?>
                                                 <a href="<?php echo e(route('admin.students.enrolment', $student->id)); ?>" class="btn btn-xs btn-outline-success" data-bs-toggle="tooltip" title="Manage Course & Fees">
                                                     <i class="fas fa-file-invoice-dollar"></i>
                                                 </a>
                                             <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                              <button type="button" class="btn btn-xs btn-outline-primary btn-send-student" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>" data-completion="<?php echo e($completion); ?>" data-bs-toggle="tooltip" title="Send to Student (Completion: <?php echo e($completion); ?>%)">
                                                  <i class="fas fa-paper-plane"></i>
                                              </button>
                                         <?php elseif($student->enrolment_status === 'rejected'): ?>
                                             <button type="button" class="btn btn-xs btn-outline-warning btn-revert-enrol" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>" data-bs-toggle="tooltip" title="Move to Pending">
                                                 <i class="fas fa-undo"></i>
                                             </button>
                                             <button type="button" class="btn btn-xs btn-outline-danger btn-delete-student" data-id="<?php echo e($student->id); ?>" data-name="<?php echo e($student->first_name); ?> <?php echo e($student->surname); ?>" data-bs-toggle="tooltip" title="Delete">
                                                 <i class="fas fa-trash-alt"></i>
                                             </button>
                                         <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                     </div>
                                 </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>No students found.
                                </td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing <?php echo e($students->firstItem() ?? 0); ?>–<?php echo e($students->lastItem() ?? 0); ?> of <?php echo e($students->total()); ?> records
                    </small>
                    <?php echo e($students->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function showToast(message, isSuccess) {
    if (typeof toastr !== 'undefined') {
        if (isSuccess) {
            toastr.success(message);
        } else {
            toastr.error(message);
        }
    } else {
        alert(message);
    }
}

$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // 1. Send to Student Action with SweetAlert & Toastr validation
    $(document).on('click', '.btn-send-student', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        const completion = parseInt($(this).data('completion'));
        
        Swal.fire({
            title: 'Send to Student?',
            text: `Are you sure you want to move "${studentName}" to the Enrolled Students section? (Profile Completion: ${completion}%)`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Send',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call AJAX
                $.ajax({
                    url: `/admin/students/${studentId}/send-to-student`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 2. Approve Enrolment Action
    $(document).on('click', '.btn-approve-enrol', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Approve Pre-Enrolment?',
            text: `Are you sure you want to approve "${studentName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}/approve`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 3. Reject Enrolment Action
    $(document).on('click', '.btn-reject-enrol', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Reject Pre-Enrolment?',
            text: `Are you sure you want to reject "${studentName}"?`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}/reject`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 4. Revert Enrolment Action
    $(document).on('click', '.btn-revert-enrol', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Revert to Pending?',
            text: `Are you sure you want to move "${studentName}" back to Pending?`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Revert',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}/revert-to-pending`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 5. Delete Student Action
    $(document).on('click', '.btn-delete-student', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Delete Student?',
            text: `Are you sure you want to permanently delete student "${studentName}" and their user record? This action is irreversible!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}`,
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views/backend/admin/students/index.blade.php ENDPATH**/ ?>
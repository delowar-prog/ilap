<?php $__env->startSection('title', 'Manage — Partner Institutes'); ?>

<?php $__env->startSection('admin_contents'); ?>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0">
                <i class="fas fa-university me-2"></i> Partner Institutes
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.config.dropdown.index')); ?>">Configuration</a></li>
                    <li class="breadcrumb-item active">Partner Institutes</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row mt-3">
    
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-list me-2 text-primary"></i>Current Partner Institutes</h6>
            </div>
            <div class="card-body p-0">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($options->isEmpty()): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        No partner institutes yet. Add one using the form on the right.
                    </div>
                <?php else: ?>
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Institute Details</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="<?php echo e($opt->is_active ? '' : 'table-secondary opacity-75'); ?>">
                                <td>
                                    
                                    <form action="<?php echo e(route('admin.config.partner_institutes.update', $opt->id)); ?>" method="POST" id="edit-form-<?php echo e($opt->id); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-5">
                                                <input type="text" name="name" value="<?php echo e($opt->name); ?>"
                                                       class="form-control form-control-sm" placeholder="Name" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="country" value="<?php echo e($opt->country); ?>"
                                                       class="form-control form-control-sm" placeholder="Country">
                                            </div>
                                            <div class="col-md-10 mt-1">
                                                <input type="url" name="website" value="<?php echo e($opt->website); ?>"
                                                       class="form-control form-control-sm" placeholder="Website (https://...)">
                                            </div>
                                            <div class="col-md-2 mt-1">
                                                <button type="submit" class="btn btn-sm btn-outline-primary px-2 w-100" title="Save Changes">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block m-0">
                                        <input class="form-check-input option-status-toggle" 
                                               type="checkbox" 
                                               role="switch" 
                                               data-url="<?php echo e(route('admin.config.partner_institutes.toggle', $opt->id)); ?>"
                                               <?php echo e($opt->is_active ? 'checked' : ''); ?> 
                                               style="cursor: pointer; width: 2.6em; height: 1.3em;">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        
                                        <form action="<?php echo e(route('admin.config.partner_institutes.destroy', $opt->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" title="Delete"
                                                    onclick="return confirm('Delete this institute?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-plus-circle me-2 text-success"></i>Add New Institute</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.config.partner_institutes.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">INSTITUTE NAME <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="e.g. University of Oxford" value="<?php echo e(old('name')); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">COUNTRY</label>
                        <input type="text" name="country" class="form-control <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="e.g. United Kingdom" value="<?php echo e(old('country')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">WEBSITE</label>
                        <input type="url" name="website" class="form-control <?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="e.g. https://www.ox.ac.uk" value="<?php echo e(old('website')); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['website'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fas fa-plus me-1"></i> Add Institute
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // AJAX Toggle Switch
    $(document).on('change', '.option-status-toggle', function() {
        const switchEl = $(this);
        const url = switchEl.data('url');
        const isChecked = switchEl.is(':checked');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PATCH'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                const tr = switchEl.closest('tr');
                if (isChecked) {
                    tr.removeClass('table-secondary opacity-75');
                } else {
                    tr.addClass('table-secondary opacity-75');
                }

                if (typeof toastr !== 'undefined') {
                    toastr.success('Status updated successfully');
                } else if (typeof Swal !== 'undefined') {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Status updated successfully'
                    });
                }
            },
            error: function() {
                switchEl.prop('checked', !isChecked);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update status. Please try again.'
                    });
                } else {
                    alert('Failed to update status.');
                }
            }
        });
    });

    // Init tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\config\partner_institutes\index.blade.php ENDPATH**/ ?>
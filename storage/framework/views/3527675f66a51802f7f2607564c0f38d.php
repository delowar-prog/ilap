<?php $__env->startSection('admin_contents'); ?>

<div class="card mb-3">
    <div class="card-header py-3 bg-light">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 text-primary fw-bold">
                    <i class="fas fa-file-alt me-2"></i> Letter Templates Engine
                </h5>
                <small class="text-muted">Create, edit and manage dynamic letter templates for student generation</small>
            </div>
            <div class="col-auto">
                <a href="<?php echo e(route('admin.letter-templates.create')); ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Add New Template
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">

        <form method="GET" action="<?php echo e(route('admin.letter-templates.index')); ?>" class="row g-2 mb-4">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search templates by title or type..." value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="">-- All Template Types --</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($types)): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($typeOpt); ?>" <?php echo e(request('type') == $typeOpt ? 'selected' : ''); ?>><?php echo e($typeOpt); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('search') || request('type')): ?>
                    <a href="<?php echo e(route('admin.letter-templates.index')); ?>" class="btn btn-outline-danger" title="Reset Filters"><i class="fas fa-redo"></i></a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle border">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Template Title</th>
                        <th>Type</th>
                        <th>Subject / Heading</th>
                        <th class="text-center">Status</th>
                        <th>Created At</th>
                        <th class="text-end" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($templates->firstItem() + $index); ?></td>
                            <td>
                                <strong><?php echo e($template->title); ?></strong>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($template->header_image): ?>
                                    <span class="badge bg-info ms-1"><i class="fas fa-image"></i> Header Image</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-secondary text-uppercase"><?php echo e($template->type); ?></span>
                            </td>
                            <td><?php echo e(Str::limit($template->subject ?? 'N/A', 40)); ?></td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input template-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-id="<?php echo e($template->id); ?>" 
                                           data-url="<?php echo e(route('admin.letter-templates.toggle', $template->id)); ?>"
                                           <?php echo e($template->status ? 'checked' : ''); ?> 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>
                            <td><?php echo e($template->created_at ? $template->created_at->format('d M, Y') : 'N/A'); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.letter-templates.preview', $template->id)); ?>" class="btn btn-sm btn-info text-white me-1" title="Preview Dummy Output">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.letter-templates.edit', $template->id)); ?>" class="btn btn-sm btn-primary me-1" title="Edit Template">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.letter-templates.destroy', $template->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn-confirm" data-text="You want to delete this letter template!" title="Delete Template">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                No letter templates found. Click <strong>Add New Template</strong> to create one.
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <?php echo e($templates->appends(request()->query())->links()); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).on('change', '.template-status-toggle', function() {
    const switchEl = $(this);
    const url = switchEl.data('url');
    const isChecked = switchEl.is(':checked');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            _method: 'PATCH'
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
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
        error: function(xhr) {
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
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views/backend/letter_templates/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('admin_contents'); ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-file-signature me-2"></i> Official Signatures & Seals Management
        </h5>
        <a href="<?php echo e(route('admin.official-signatures.create')); ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Signature / Seal
        </a>
    </div>

    <div class="card-body">

        <!-- Filter Form -->
        <form method="GET" action="<?php echo e(route('admin.official-signatures.index')); ?>" class="row g-2 mb-4">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by Name, Designation, or Tag..." value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-secondary text-white rounded-pill px-3"><i class="fas fa-filter me-1"></i> Filter</button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->anyFilled(['search'])): ?>
                    <a href="<?php echo e(route('admin.official-signatures.index')); ?>" class="btn btn-outline-secondary rounded-pill px-3">Reset</a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle border">
                <thead class="table-light">
                    <tr>
                        <th width="60" class="text-center">#</th>
                        <th width="120">Signature</th>
                        <th width="120">Seal</th>
                        <th>Signatory Name</th>
                        <th>Designation / Role</th>
                        <th>Tag Key</th>
                        <th class="text-center">Status</th>
                        <th width="120" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $signatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-center fw-bold"><?php echo e($signatures->firstItem() + $loop->index); ?></td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sig->signature_path): ?>
                                <div class="bg-white border rounded p-1 text-center" style="width: 90px; height: 50px;">
                                    <img src="<?php echo e(asset($sig->signature_path)); ?>" alt="<?php echo e($sig->name); ?>" class="img-fluid h-100" style="object-fit: contain;">
                                </div>
                                <?php else: ?>
                                <span class="text-muted small">N/A</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sig->seal_path): ?>
                                <div class="bg-white border rounded p-1 text-center" style="width: 90px; height: 50px;">
                                    <img src="<?php echo e(asset($sig->seal_path)); ?>" alt="Seal" class="img-fluid h-100" style="object-fit: contain;">
                                </div>
                                <?php else: ?>
                                <span class="text-muted small">N/A</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <span class="fw-bold text-dark"><?php echo e($sig->name); ?></span>
                            </td>
                            <td>
                                <span class="text-muted small"><?php echo e($sig->designation ?? 'N/A'); ?></span>
                            </td>
                            <td>
                                <code class="bg-light text-primary px-2 py-1 border rounded fw-bold cursor-pointer" onclick="copyToClipboard('<?php echo e($sig->tag); ?>')" title="Click to copy tag">
                                    <?php echo e($sig->tag); ?>

                                </code>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input global-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-url="<?php echo e(route('status.toggle', ['modelType' => 'official_signature', 'id' => $sig->id])); ?>"
                                           <?php echo e($sig->status == 'active' ? 'checked' : ''); ?> 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?php echo e(route('admin.official-signatures.edit', $sig->id)); ?>" class="btn btn-outline-primary btn-sm rounded-circle me-1" title="Edit Signature">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.official-signatures.destroy', $sig->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this signature?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" title="Delete Signature">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-file-signature fa-3x mb-3 text-secondary opacity-50"></i>
                                <h5>No Official Signatures or Seals Found</h5>
                                <p class="small mb-3">Add signatures or seals to generate custom letter tags like <code><?php echo '{{principal_signature}}'; ?></code>.</p>
                                <a href="<?php echo e(route('admin.official-signatures.create')); ?>" class="btn btn-primary btn-sm rounded-pill">
                                    <i class="fas fa-plus me-1"></i> Add First Signature / Seal
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <?php echo e($signatures->withQueryString()->links()); ?>

        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Tag copied to clipboard!',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            alert('Tag copied: ' + text);
        }
    });
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\official_signatures\index.blade.php ENDPATH**/ ?>
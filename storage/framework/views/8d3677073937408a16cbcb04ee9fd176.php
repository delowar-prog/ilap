<?php $__env->startSection('admin_contents'); ?>

<div class="card mb-4 shadow-sm">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-plus-circle me-2"></i> Add New Official Signature / Seal
        </h5>
        <a href="<?php echo e(route('admin.official-signatures.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Signatures
        </a>
    </div>

    <div class="card-body">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($error); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form action="<?php echo e(route('admin.official-signatures.store')); ?>" method="POST" enctype="multipart/form-data" id="signatureForm">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="signature_data" id="signature_data_input">

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Signatory Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. Dr. Md. Rahman" value="<?php echo e(old('name')); ?>" required>
                        <small class="text-muted">Full name of the person or office (e.g. Dr. John Smith, Office of the Registrar)</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Designation / Role Title <span class="text-danger">*</span></label>
                        <select name="designation_select" id="designation_select" class="form-select" onchange="toggleCustomDesignation(this.value)" required>
                            <option value="">-- Select Role / Designation --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($roles)): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($roleOpt); ?>" <?php echo e(old('designation') == $roleOpt ? 'selected' : ''); ?>><?php echo e($roleOpt); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <option value="custom_other" class="fw-bold text-primary">+ Other Custom Designation...</option>
                        </select>

                        <div id="custom_designation_box" class="mt-2 d-none">
                            <input type="text" name="custom_designation" id="custom_designation_input" class="form-control border-primary" placeholder="Type custom designation name..." value="<?php echo e(old('custom_designation')); ?>">
                        </div>
                        <input type="hidden" name="designation" id="final_designation">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag Format <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">&#123;&#123;</span>
                            <input type="text" name="tag_key" class="form-control" placeholder="e.g. principal" value="<?php echo e(old('tag_key')); ?>" required>
                            <span class="input-group-text">&#125;&#125;</span>
                        </div>
                        <small class="text-muted">Use this tag in letter templates (Only letters/numbers/underscores).</small>
                    </div>



                    <div class="card bg-light border-info mb-3">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-info"><i class="fas fa-file-upload me-1"></i> Upload Signature Image (Optional)</h6>
                            <p class="small text-muted mb-2">If you already have a scanned signature transparent PNG file, you can upload it directly below.</p>
                            <input type="file" name="signature_file" id="signature_file_input" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="card bg-light border-info mb-3">
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-info"><i class="fas fa-stamp me-1"></i> Upload Official Seal / Stamp (Optional)</h6>
                            <p class="small text-muted mb-2">Upload a transparent PNG seal image file for this signatory.</p>
                            <input type="file" name="seal_file" id="seal_file_input" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <!-- Digital Signature Canvas Pad Column -->
                <div class="col-lg-6">
                    <div class="card border-primary shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-pen-fancy me-1"></i> Draw Signature on Canvas Pad</h6>
                            <button type="button" id="clearCanvasBtn" class="btn btn-outline-light btn-xs rounded-pill px-2">
                                <i class="fas fa-eraser me-1"></i> Clear Pad
                            </button>
                        </div>
                        <div class="card-body p-3 text-center d-flex flex-column justify-content-center">
                            <p class="small text-muted mb-2">Draw the signature cleanly in the box below using mouse, touchpad, or touchscreen stylus.</p>
                            
                            <div class="border rounded p-1 bg-white shadow-sm position-relative my-auto" style="touch-action: none;">
                                <canvas id="officialCanvas" width="460" height="200" class="w-100 border rounded" style="background: #fff; cursor: crosshair; touch-action: none;"></canvas>
                            </div>
                            
                            <small class="text-muted mt-2"><i class="fas fa-info-circle me-1"></i> Drawn strokes will be saved as transparent background PNG image.</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" id="submitFormBtn" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                    <i class="fas fa-save me-1"></i> Save Official Signature
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
$(document).ready(function() {
    var canvas = document.getElementById('officialCanvas');
    if (!canvas) return;

    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255, 0)', // Transparent background
        penColor: 'rgb(0, 0, 128)', // Navy Blue
        minWidth: 1.5,
        maxWidth: 3.5
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    resizeCanvas();
    $(window).on('resize', function() {
        // Keep signature ratio on resize if needed
    });

    $('#clearCanvasBtn').on('click', function() {
        signaturePad.clear();
    });

    window.toggleCustomDesignation = function(val) {
        if (val === 'custom_other') {
            $('#custom_designation_box').removeClass('d-none');
            $('#custom_designation_input').prop('required', true).focus();
        } else {
            $('#custom_designation_box').addClass('d-none');
            $('#custom_designation_input').prop('required', false);
        }
    };

    $('#signatureForm').on('submit', function(e) {
        var selectedRole = $('#designation_select').val();
        if (selectedRole === 'custom_other') {
            $('#final_designation').val($('#custom_designation_input').val());
        } else {
            $('#final_designation').val(selectedRole);
        }

        var fileInput = $('#signature_file_input')[0];
        var hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
        var sealInput = $('#seal_file_input')[0];
        var hasSeal = sealInput && sealInput.files && sealInput.files.length > 0;

        if (!signaturePad.isEmpty()) {
            var dataUrl = signaturePad.toDataURL('image/png');
            $('#signature_data_input').val(dataUrl);
        } else if (!hasFile && !hasSeal) {
            e.preventDefault();
            alert('Please draw a signature on the canvas pad OR select a signature/seal image file to upload.');
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\official_signatures\create.blade.php ENDPATH**/ ?>
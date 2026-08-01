<!-- Digital Signature Pad Modal -->
<div class="modal fade" id="signaturePadModal" tabindex="-1" aria-labelledby="signaturePadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="signaturePadModalLabel">
                    <i class="fas fa-signature me-2"></i> Draw Digital Signature
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted small mb-3">Draw your official signature in the box below using your mouse, touchpad, or touchscreen finger.</p>
                
                <!-- Current Saved Signature Preview -->
                <div id="current_signature_box" class="mb-3 p-2 border rounded bg-light <?php echo e(auth()->user()->signature ? '' : 'd-none'); ?>">
                    <label class="form-label d-block text-muted small fw-bold mb-1">Current Saved Signature:</label>
                    <img id="current_signature_img" src="<?php echo e(auth()->user()->signature ? asset(auth()->user()->signature) : ''); ?>" class="img-fluid border p-1 rounded bg-white" style="max-height: 80px;" alt="Current Signature">
                </div>

                <!-- Canvas Signature Pad Box -->
                <div class="signature-canvas-wrapper border rounded p-1 shadow-sm bg-white position-relative" style="touch-action: none;">
                    <canvas id="signatureCanvas" width="440" height="180" class="w-100 border rounded" style="background: #fff; cursor: crosshair; touch-action: none;"></canvas>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="button" id="clearSignatureBtn" class="btn btn-outline-danger btn-sm rounded-pill">
                        <i class="fas fa-eraser me-1"></i> Clear Canvas
                    </button>
                    <small class="text-muted"><i class="fas fa-pen-fancy me-1 text-primary"></i> Smooth Stroke Enabled</small>
                </div>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveSignatureBtn" class="btn btn-primary btn-sm rounded-pill px-4">
                    <i class="fas fa-save me-1"></i> Save Signature
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
$(document).ready(function() {
    var canvas = document.getElementById('signatureCanvas');
    if (!canvas) return;

    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgba(255, 255, 255, 0)', // Transparent
        penColor: 'rgb(0, 0, 128)', // Deep Navy Blue
        minWidth: 1.5,
        maxWidth: 3.5
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear(); // Clear on resize
    }

    // Modal open event
    $('#signaturePadModal').on('shown.bs.modal', function () {
        resizeCanvas();
    });

    // Clear Canvas
    $('#clearSignatureBtn').on('click', function() {
        signaturePad.clear();
    });

    // Save Signature via AJAX
    $('#saveSignatureBtn').on('click', function() {
        if (signaturePad.isEmpty()) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Signature',
                    text: 'Please draw your signature before saving.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                alert('Please draw your signature before saving.');
            }
            return;
        }

        var dataUrl = signaturePad.toDataURL('image/png');

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Saving...');

        $.ajax({
            url: "<?php echo e(route('user.signature.save')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                signature_data: dataUrl
            },
            success: function(response) {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Save Signature');

                if (response.status === 'success') {
                    $('#current_signature_img').attr('src', response.signature_path);
                    $('#current_signature_box').removeClass('d-none');
                    
                    // Update any signature preview elements on page
                    $('.user-signature-preview').attr('src', response.signature_path).removeClass('d-none');

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Digital Signature saved successfully!',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }

                    $('#signaturePadModal').modal('hide');
                } else {
                    alert(response.message || 'Error saving signature.');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Save Signature');
                alert('Failed to save signature. Please try again.');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\iLap\resources\views\components\signature_pad_modal.blade.php ENDPATH**/ ?>
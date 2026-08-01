<?php $__env->startSection('admin_contents'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-percentage me-2"></i>
            Setup Commission
        </h5>
        <a href="<?php echo e(route('commissions.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="<?php echo e(route('commissions.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card-body">
            <div class="row g-3">
                
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Agent <span class="text-danger">*</span>
                    </label>
                    <select name="agent_id" id="agent_id" 
                            class="form-select <?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Select Agent</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($agent->id); ?>" <?php echo e(old('agent_id') == $agent->id ? 'selected' : ''); ?>>
                                <?php echo e($agent->name); ?> (<?php echo e($agent->agent_code); ?>) - 
                                <?php echo e(ucfirst(str_replace('_', ' ', $agent->agent_type))); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['agent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Course
                        <small class="text-muted">(Leave empty for all courses)</small>
                    </label>
                    <select name="course_id" id="course_id" 
                            class="form-select <?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- All Courses (Default) --</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>>
                                <?php echo e($course->name); ?> (<?php echo e($course->currency); ?> <?php echo e(number_format($course->fee, 2)); ?>)
                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['course_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Commission Type <span class="text-danger">*</span>
                    </label>
                    <select name="commission_type" id="commission_type" 
                            class="form-select <?php $__errorArgs = ['commission_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="percentage" <?php echo e(old('commission_type') == 'percentage' ? 'selected' : ''); ?>>
                            Percentage (%)
                        </option>
                        <option value="flat" <?php echo e(old('commission_type') == 'flat' ? 'selected' : ''); ?>>
                            Flat Amount
                        </option>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['commission_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Amount <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" id="amount_prefix">
                            <?php echo e(old('commission_type') == 'percentage' ? '%' : ''); ?>

                        </span>
                        <input type="number" step="0.01" min="0" max="1000000" 
                               name="amount" id="amount" 
                               class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('amount')); ?>" 
                               placeholder="0.00" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        For percentage: enter value between 0-100
                    </small>
                </div>

                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Currency <span class="text-danger">*</span>
                    </label>
                    <select name="currency" class="form-select <?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <option value="<?php echo e($currency); ?>" <?php echo e(old('currency') == $currency ? 'selected' : ''); ?>>
                                <?php echo e($currency); ?>

                            </option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['currency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        System will calculate based on numerical value only
                    </small>
                </div>

                
                <div class="col-12">
                    <div class="alert alert-info mb-0" id="preview_box" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calculator me-2"></i>
                                <strong>Live Preview:</strong>
                                <span id="preview_text"></span>
                            </div>
                            <div class="fs-4 fw-bold text-success" id="preview_amount"></div>
                        </div>
                    </div>
                </div>

                
                <div class="col-12">
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Important Notes:</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Commission will be paid in <strong>full</strong> by each student - no partial payment.</li>
                            <li>One commission setup per agent per course (or all courses).</li>
                            <li>HQ staff can override or amend commission amounts at any time.</li>
                            <li>System calculates based on numerical values only (currency prefix ignored).</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer text-end">
            <a href="<?php echo e(route('commissions.index')); ?>" class="btn btn-secondary me-2">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Commission
            </button>
        </div>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commissionType = document.getElementById('commission_type');
        const amount = document.getElementById('amount');
        const amountPrefix = document.getElementById('amount_prefix');
        const courseSelect = document.getElementById('course_id');
        const previewBox = document.getElementById('preview_box');
        const previewText = document.getElementById('preview_text');
        const previewAmount = document.getElementById('preview_amount');

        // Course data (from blade)
        const courses = <?php echo json_encode($courses->keyBy('id'), 15, 512) ?>;

        function updatePreview() {
            const type = commissionType.value;
            const amt = parseFloat(amount.value) || 0;
            const courseId = courseSelect.value;
            const course = courses[courseId];

            // Update prefix
            amountPrefix.textContent = type === 'percentage' ? '%' : '';

            // Percentage এর জন্য max 100
            if (type === 'percentage') {
                amount.max = 100;
            } else {
                amount.max = 1000000;
            }

            // Preview calculation
            if (amt > 0 && course) {
                let calculatedAmount;
                if (type === 'percentage') {
                    calculatedAmount = (course.fee * amt) / 100;
                    previewText.textContent = `${amt}% of ${course.currency} ${parseFloat(course.fee).toFixed(2)} =`;
                } else {
                    calculatedAmount = amt;
                    previewText.textContent = `Flat commission per student:`;
                }
                previewAmount.textContent = `${course.currency} ${calculatedAmount.toFixed(2)}`;
                previewBox.style.display = 'block';
            } else if (amt > 0 && !courseId) {
                if (type === 'flat') {
                    previewText.textContent = `Flat commission per student (any course):`;
                    previewAmount.textContent = `${amt.toFixed(2)}`;
                    previewBox.style.display = 'block';
                } else {
                    previewBox.style.display = 'none';
                }
            } else {
                previewBox.style.display = 'none';
            }
        }

        commissionType.addEventListener('change', updatePreview);
        amount.addEventListener('input', updatePreview);
        courseSelect.addEventListener('change', updatePreview);

        // Initial call
        updatePreview();
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\commissions\create.blade.php ENDPATH**/ ?>
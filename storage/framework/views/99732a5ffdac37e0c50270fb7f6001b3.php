<?php $__env->startSection('admin_contents'); ?>

<div class="card mb-4">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-eye me-2"></i> Template Live Preview (Dummy Data)
        </h5>
        <div>
            <a href="<?php echo e(route('admin.invoice-templates.edit', $invoiceTemplate->id)); ?>" class="btn btn-primary btn-sm rounded-pill me-2">
                <i class="fas fa-edit me-1"></i> Edit Template
            </a>
            <a href="<?php echo e(route('admin.invoice-templates.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body p-4 bg-secondary bg-opacity-10 d-flex justify-content-center">
        <!-- Paper Mockup -->
        <div class="bg-white shadow p-5 border" style="max-width: 800px; width: 100%; min-height: 900px; font-family: Arial, sans-serif; position: relative;">
            
            <!-- Premium Header -->
            <div style="border-bottom: 2px solid #003366; padding-bottom: 12px; margin-bottom: 20px;">
                <table style="width: 100%; border-collapse: collapse; margin: 0;">
                    <tr>
                        <td style="vertical-align: middle; padding: 0;">
                            <table style="border-collapse: collapse;">
                                <tr>
                                    <!-- Circular Seal Design -->
                                    <td style="padding-right: 12px; vertical-align: middle;">
                                        <div style="width: 55px; height: 55px; border-radius: 50%; border: 1.5px solid #003366; text-align: center; background-color: #fff; padding: 2px; box-sizing: border-box; display: inline-block;">
                                            <div style="border: 1px dashed #b8860b; border-radius: 50%; width: 100%; height: 100%; box-sizing: border-box; padding-top: 3px; position: relative;">
                                                <div style="font-size: 4px; color: #003366; font-weight: bold; text-transform: uppercase; line-height: 1;">LEARNING</div>
                                                <div style="font-size: 11px; font-weight: bold; color: #b8860b; margin: 1px 0; font-family: 'Georgia', serif; line-height: 1.1;">iLAP</div>
                                                <div style="font-size: 4px; color: #003366; font-weight: bold; text-transform: uppercase; line-height: 1;">PROVIDER</div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Brand Text -->
                                    <td style="vertical-align: middle; line-height: 1.1;">
                                        <span style="font-size: 30px; font-weight: 800; color: #003366; font-family: Arial, sans-serif; letter-spacing: -1px;">iLAP</span>
                                        <span style="font-size: 8px; font-weight: bold; color: #555; text-transform: uppercase; vertical-align: super; margin-left: 3px;">International<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Learning Access<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provider</span>
                                        <div style="width: 155px; height: 1px; background-color: #b8860b; margin: 3px 0 2px 0;"></div>
                                        <div style="font-size: 8px; font-weight: bold; color: #003366; text-transform: uppercase; letter-spacing: 0.5px;">Global Education Group</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: right; vertical-align: middle; padding: 0; font-size: 10px; line-height: 1.3; color: #333; font-family: Arial, sans-serif;">
                            <strong style="color: #003366; font-size: 11px;">167-169 Great Portland Street</strong><br>
                            London W1W 5PF<br>
                            <span style="color: #003366; font-weight: bold;">United Kingdom</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="d-flex justify-content-between mb-4 text-muted small">
                <div>
                    <strong>Date:</strong> <?php echo e(date('d M, Y')); ?><br>
                    <strong>Ref No:</strong> ILAP/INV-PREVIEW/SAMPLE
                </div>
                <div class="text-end">
                    <strong>Student ID:</strong> STU-2026-001
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($invoiceTemplate->subject): ?>
                <h5 class="text-center fw-bold text-dark text-uppercase mb-4" style="text-decoration: underline;">
                    <?php echo e($invoiceTemplate->subject); ?>

                </h5>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="content-preview mb-5" style="line-height: 1.8; color: #333;">
                <?php echo $content; ?>

            </div>

            <!-- Mockup Signatures at bottom of preview page (above footer) -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activeSignatures) && count($activeSignatures) > 0): ?>
                <div style="position: absolute; bottom: 130px; left: 40px; right: 40px; z-index: 50;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeSignatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <td style="width: <?php echo e(100 / count($activeSignatures)); ?>%; text-align: center; vertical-align: bottom;">
                                    <div style="display: inline-block; text-align: center; font-family: Arial, sans-serif;">
                                        <!-- Styled dummy signature box in preview -->
                                        <div style="font-family: 'Courier New', Courier, monospace; font-style: italic; font-size: 13px; color: #003366; height: 35px; line-height: 35px; border: 1px dashed #ccc; padding: 0 10px; border-radius: 4px; display: inline-block; margin-bottom: 5px; background-color: #fafafa;">
                                            /<?php echo e($sig['name']); ?>/
                                        </div>
                                        <div style="border-top: 1px solid #999; width: 140px; margin: 0 auto 3px auto;"></div>
                                        <div style="font-weight: bold; font-size: 10.5px; color: #333; line-height: 1.2;"><?php echo e($sig['name']); ?></div>
                                        <div style="font-size: 8.5px; color: #666; line-height: 1.2;"><?php echo e($sig['designation']); ?></div>
                                    </div>
                                </td>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tr>
                    </table>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Premium Footer -->
            <div style="position: absolute; bottom: 30px; left: 40px; right: 40px; border-top: 1px solid #e0e0e0; padding-top: 10px;">
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                    <tr>
                        <td style="font-size: 7.5px; color: #444; line-height: 1.1; vertical-align: middle;">
                            <span style="font-weight: bold; color: #c22026; text-transform: uppercase;">Cambridge English</span> School &nbsp;|&nbsp;
                            <span style="font-weight: bold; color: #1e306e; text-transform: uppercase;">Graduate College</span> &nbsp;|&nbsp;
                            <span style="font-weight: bold; color: #0f1c3f;">UKQAS</span> &nbsp;|&nbsp;
                            <span style="font-weight: bold; color: #d9534f; text-transform: uppercase;">VAS</span> Visa
                        </td>
                        <td style="text-align: right; font-size: 7.5px; font-weight: bold; color: #003366; vertical-align: middle;">
                            UKRLP Register
                        </td>
                    </tr>
                </table>
                <div style="font-size: 5.5px; color: #777; line-height: 1.3; text-align: center; margin-bottom: 8px;">
                    Australia, Bahrain, Bangladesh, Brazil, Canada, China, Cyprus, Egypt, India, Malaysia, UAE, UK, USA, Vietnam.
                </div>
                <div style="background-color: #003366; color: #ffffff; padding: 6px 12px; font-size: 7.5px; border-radius: 4px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="color: #ffffff;">
                                <strong>iLAP Group Limited</strong> (Company No. 12405171)
                            </td>
                            <td style="text-align: right; color: #ffffff;">
                                Phone: +44 208 133 8086 | Email: info@ilap.org.uk | Web: www.ilap.org.uk
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\invoice_templates\preview.blade.php ENDPATH**/ ?>
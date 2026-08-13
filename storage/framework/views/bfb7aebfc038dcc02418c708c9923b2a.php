<?php
    $topMargin = isset($pad_margin_top) && $pad_margin_top > 0 ? (int)$pad_margin_top : 130;
    $bottomMargin = isset($pad_margin_bottom) && $pad_margin_bottom > 0 ? (int)$pad_margin_bottom : 120;
    $leftMargin = isset($pad_margin_left) && $pad_margin_left > 0 ? (int)$pad_margin_left : 55;
    $rightMargin = isset($pad_margin_right) && $pad_margin_right > 0 ? (int)$pad_margin_right : 55;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo e($title ?? 'Official Invoice'); ?></title>
    <style>
        @page {
            margin: <?php echo e($topMargin); ?>px 0px <?php echo e($bottomMargin); ?>px 0px;
        }
        <?php if(!empty($letter_head_image)): ?>
        .letterhead-bg {
            position: fixed;
            top: -<?php echo e($topMargin); ?>px;
            left: 0px;
            width: 210mm;
            height: 297mm;
            z-index: -1000;
        }
        <?php endif; ?>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background: transparent;
        }
        .header {
            position: fixed;
            top: -110px;
            left: 0px;
            right: 0px;
            height: 100px;
            width: 100%;
        }
        .footer {
            position: fixed;
            bottom: -235px;
            left: 0px;
            right: 0px;
            height: 120px;
            width: 100%;
        }
        /* Signature block at end of content — stays on last page only */
        .signature-fixed {
            margin-top: 40px;
            page-break-inside: avoid;
            padding: 0 0 10px 0;
        }
        .page-break-gap-auto {
            display: none !important;
            page-break-before: always;
        }
        .content {
            padding-left: <?php echo e($leftMargin); ?>px;
            padding-right: <?php echo e($rightMargin); ?>px;
            margin-top: 0px;
            background: transparent;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }
        .content p {
            margin-top: 0;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        .content ul,
        .content ol {
            margin-bottom: 1rem;
            padding-left: 20px;
        }
        .content table {
            border-collapse: collapse;
            margin-bottom: 1rem;
            width: 100%;
        }
        .content td,
        .content th {
            border: 1px solid #ddd;
            padding: 4px 8px;
        }
        .meta-info {
            margin-bottom: 20px;
        }
        .meta-info table {
            width: 100%;
        }
        .meta-info td {
            vertical-align: top;
        }
        h1, h2, h3, h4 {
            color: #003366;
            margin-top: 0;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #333;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($letter_head_image)): ?>
        <img src="<?php echo e($letter_head_image); ?>" class="letterhead-bg">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- ═══════════════ PREMIUM FULL-WIDTH HEADER ═══════════════ -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($letter_head_image)): ?>
    <div class="header">
        <table style="width: 100%; border-collapse: collapse; margin: 0; padding: 20px 55px 0 55px;">
            <tr>
                <!-- Brand Logo & Taglines -->
                <td style="vertical-align: middle; padding: 0;">
                    <table style="border-collapse: collapse;">
                        <tr>
                            <!-- circular seal design -->
                            <td style="padding-right: 12px; vertical-align: middle;">
                                <div style="width: 60px; height: 60px; border-radius: 50%; border: 1.5px solid #003366; text-align: center; background-color: #fff; padding: 2px; box-sizing: border-box;">
                                    <div style="border: 1px dashed #b8860b; border-radius: 50%; width: 100%; height: 100%; box-sizing: border-box; padding-top: 3px; position: relative;">
                                        <div style="font-size: 4px; color: #003366; font-weight: bold; text-transform: uppercase; line-height: 1; letter-spacing: 0.1px;">LEARNING</div>
                                        <div style="font-size: 13px; font-weight: bold; color: #b8860b; margin: 1px 0; font-family: 'Georgia', serif; line-height: 1.1;">iLAP</div>
                                        <div style="font-size: 4px; color: #003366; font-weight: bold; text-transform: uppercase; line-height: 1; letter-spacing: 0.1px;">PROVIDER</div>
                                        <div style="font-size: 4px; color: #b8860b; position: absolute; bottom: 4px; left: 18px;">★★★★★</div>
                                    </div>
                                </div>
                            </td>
                            <!-- Brand Text -->
                            <td style="vertical-align: middle; line-height: 1;">
                                <span style="font-size: 34px; font-weight: 800; color: #003366; font-family: Arial, sans-serif; letter-spacing: -1.5px;">iLAP</span>
                                <span style="font-size: 8px; font-weight: bold; color: #555; text-transform: uppercase; vertical-align: super; margin-left: 3px; letter-spacing: 0.3px;">International<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Learning Access<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provider</span>
                                <div style="width: 155px; height: 1px; background-color: #b8860b; margin: 4px 0 2px 0;"></div>
                                <div style="font-size: 8.5px; font-weight: bold; color: #003366; text-transform: uppercase; letter-spacing: 0.8px; font-family: Helvetica, Arial, sans-serif;">Global Education Group</div>
                            </td>
                        </tr>
                    </table>
                </td>
                <!-- Address block with red map pin -->
                <td style="text-align: right; vertical-align: middle; padding: 0; width: 230px;">
                    <table style="float: right; border-collapse: collapse;">
                        <tr>
                            <td style="text-align: right; font-size: 10px; line-height: 1.35; color: #333; padding-right: 10px; font-family: Arial, sans-serif;">
                                <strong style="color: #003366; font-size: 11px;">167-169 Great Portland Street</strong><br>
                                London W1W 5PF<br>
                                <span style="color: #003366; font-weight: bold; letter-spacing: 0.2px;">United Kingdom</span>
                            </td>
                            <!-- Map Pin Icon -->
                            <td style="vertical-align: middle; width: 20px; text-align: center; padding-top: 2px;">
                                <div style="width: 14px; height: 18px; background-color: #e31b23; border-radius: 7px 7px 0 0; position: relative; display: inline-block;">
                                    <div style="width: 6px; height: 6px; background-color: #fff; border-radius: 50%; position: absolute; top: 4px; left: 4px;"></div>
                                    <div style="width: 0; height: 0; border-left: 7px solid transparent; border-right: 7px solid transparent; border-top: 10px solid #e31b23; position: absolute; bottom: -8px; left: 0;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- Blue Accent Line spanning 100% Page Width -->
        <div style="width: 100%; height: 3px; background-color: #003366; margin-top: 10px;"></div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- ═══════════════ CONTENT AREA ═══════════════ -->
    <div class="content">
        <div class="letter-body" style="margin-top: 0px;">
            <?php echo $content; ?>

        </div>

        <!-- ═══════════════ SIGNATURE BLOCK (END OF CONTENT — LAST PAGE) ═══════════════ -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($activeSignatures) && count($activeSignatures) > 0): ?>
            <div class="signature-fixed">
                <!-- Thin separator line above signatures -->
                <div style="width: 100%; height: 1px; background-color: #cccccc; margin-bottom: 12px;"></div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $activeSignatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <td style="width: <?php echo e(100 / count($activeSignatures)); ?>%; text-align: center; vertical-align: top; padding: 0 10px;">
                                <div style="display: inline-block; text-align: center;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(file_exists($sig['path'])): ?>
                                        <img src="<?php echo e($sig['path']); ?>" style="max-height: 50px; width: auto; display: block; margin: 0 auto 4px auto;" alt="Signature">
                                    <?php else: ?>
                                        <div style="height: 50px;"></div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div style="border-top: 1.5px solid #003366; width: 170px; margin: 0 auto 3px auto;"></div>
                                    <div style="font-weight: bold; font-size: 10.5px; color: #003366; line-height: 1.2;"><?php echo e($sig['name']); ?></div>
                                    <div style="font-size: 9px; color: #666; line-height: 1.2;"><?php echo e($sig['designation']); ?></div>
                                </div>
                            </td>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tr>
                </table>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- ═══════════════ PREMIUM FULL-WIDTH FOOTER ═══════════════ -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($letter_head_image)): ?>
    <div class="footer">
        <!-- Gray separator line -->
        <div style="width: 100%; height: 1px; background-color: #e0e0e0; margin-bottom: 8px;"></div>

        <table style="width: 100%; border-collapse: collapse; padding: 0 55px; margin-bottom: 5px;">
            <tr>
                <!-- Accreditation & Partner Text Labels (Clean & Professional) -->
                <td style="font-size: 7.5px; color: #444; line-height: 1.1; vertical-align: middle;">
                    <span style="font-weight: bold; color: #c22026; text-transform: uppercase;">Cambridge English</span> School of London &nbsp;|&nbsp;
                    <span style="font-weight: bold; color: #1e306e; text-transform: uppercase;">Graduate College</span> of London &nbsp;|&nbsp;
                    <span style="font-weight: bold; color: #0f1c3f;">UKQAS</span> Qualifications &nbsp;|&nbsp;
                    <span style="font-weight: bold; color: #d9534f; text-transform: uppercase;">VAS</span> Visa Application Services
                </td>
                <td style="text-align: right; font-size: 8px; font-weight: bold; color: #003366; vertical-align: middle; width: 120px;">
                    UKRLP UK Register of Learning Providers
                </td>
            </tr>
        </table>

        <!-- Nominated Access Points Text -->
        <div style="padding: 0 55px; margin-bottom: 8px;">
            <div style="font-size: 6.5px; color: #0066cc; text-transform: uppercase; font-weight: bold; margin-bottom: 2px; text-align: center;">Our Nominated Access Points Worldwide:</div>
            <div style="font-size: 6px; color: #777; line-height: 1.3; text-align: center;">
                Australia, Bahrain, Bangladesh, Brazil, Belgium, Brunei, Cameroon, Canada, China, Congo, Croatia, Cyprus, Czech Republic, Egypt, Estonia, Ethiopia, Finland, France, Georgia, Germany, Ghana, Hong Kong, India, Indonesia, Iraq, Ireland, Italy, Japan, Kenya, Malaysia, Maldives, Nepal, Netherlands, New Zealand, Nigeria, Pakistan, Portugal, Qatar, Romania, Saudi Arabia, Singapore, South Africa, Spain, Sri Lanka, Sweden, Switzerland, Thailand, Turkey, UAE, UK, USA, Vietnam.
            </div>
        </div>

        <!-- Contact Banner Bar (100% full width) -->
        <div style="background-color: #003366; color: #ffffff; padding: 8px 55px; font-size: 8px; line-height: 1.4;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="color: #ffffff; font-size: 8.5px;">
                        <strong>iLAP Group Limited</strong> (Registered in England & Wales, Company No. 12405171)
                    </td>
                    <td style="text-align: right; color: #ffffff; font-size: 8px;">
                        <strong>Phone:</strong> +44 208 133 8086 &nbsp;|&nbsp; <strong>Email:</strong> info@ilap.org.uk &nbsp;|&nbsp; <strong>Web:</strong> www.ilap.org.uk
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</body>
</html>
<?php /**PATH C:\laragon\www\iLap\resources\views/backend/pdf/invoice_layout.blade.php ENDPATH**/ ?>
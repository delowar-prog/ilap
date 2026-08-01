<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Registration — iLap</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:       #4f46e5;
            --primary-light: #6366f1;
            --primary-dark:  #3730a3;
            --accent:        #06b6d4;
            --success:       #10b981;
            --danger:        #ef4444;
            --bg:            #ffffff;
            --bg2:           #f1f5f9;
            --card:          #ffffff;
            --border:        #e2e8f0;
            --text:          #0f172a;
            --muted:         #64748b;
            --input-bg:      #ffffff;
            --input-border:  #cbd5e1;
            --input-focus:   rgba(99,102,241,0.2);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Background blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.1;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 500px; height: 500px;
            background: var(--primary);
            top: -150px; left: -150px;
        }
        body::after {
            width: 400px; height: 400px;
            background: var(--accent);
            bottom: -100px; right: -100px;
        }

        .wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 860px;
        }

        /* Top logo bar */
        .logo-bar {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-bar .brand {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .logo-bar .brand span { color: var(--primary-light); }
        .logo-bar .brand .dot { color: var(--accent); }
        .logo-bar p { color: var(--muted); font-size: .9rem; margin-top: .3rem; }

        /* Card */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);
            padding: 2rem 2.5rem;
            color: #ffffff;
        }
        .card-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: .3rem;
        }
        .card-header p { font-size: .875rem; opacity: .85; }

        /* Steps indicator */
        .steps {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
            gap: 0;
        }
        .step-item {
            display: flex;
            align-items: center;
            flex: 1;
            gap: .5rem;
            font-size: .78rem;
            font-weight: 500;
            opacity: .8;
            transition: opacity .3s;
            color: #ffffff;
        }
        .step-item.active { opacity: 1; }
        .step-item .num {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem;
            font-weight: 700;
            flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.4);
            color: #ffffff;
        }
        .step-item.active .num {
            background: white;
            color: var(--primary-dark);
            border-color: white;
        }
        .step-sep { flex: 1; height: 1px; background: rgba(255,255,255,0.3); margin: 0 .4rem; }

        /* Body */
        .card-body { padding: 2.5rem; }

        /* Alert (error/success) */
        .alert {
            border-radius: 10px;
            padding: .9rem 1.2rem;
            font-size: .875rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: .7rem;
        }
        .alert-danger { background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.25); color: #fca5a5; }
        .alert-success { background: rgba(16,185,129,.12); border: 1px solid rgba(16,185,129,.25); color: #6ee7b7; }
        .alert ul { padding-left: 1rem; margin-top: .3rem; }

        /* Section label */
        .section-label {
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--accent);
            margin-bottom: 1.2rem;
            margin-top: 1.8rem;
        }
        .section-label:first-of-type { margin-top: 0; }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Grid */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
        .col-span-2 { grid-column: span 2; }

        /* Form group */
        .form-group { display: flex; flex-direction: column; gap: .4rem; }
        .form-group label {
            font-size: .8rem;
            font-weight: 500;
            color: var(--muted);
        }
        .form-group label .req { color: var(--primary-light); margin-left: 2px; }

        .form-control {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            color: var(--text);
            padding: .7rem 1rem;
            font-size: .9rem;
            font-family: inherit;
            width: 100%;
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
            -webkit-appearance: none;
        }
        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px var(--input-focus);
            background: #ffffff;
        }
        .form-control.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239,68,68,.2);
        }
        .form-control option { background: var(--bg2); color: var(--text); }
        .invalid-feedback { font-size: .78rem; color: #fca5a5; margin-top: .2rem; }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            height: 44px;
            padding-left: 2.2rem;
            display: flex;
            align-items: center;
            transition: border-color .2s, box-shadow .2s;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text);
            padding-left: .2rem;
            line-height: normal;
            font-size: .9rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
            right: .8rem;
        }
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary-light) !important;
            box-shadow: 0 0 0 3px var(--input-focus) !important;
            outline: none;
        }
        .select2-dropdown {
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            z-index: 9999;
        }
        .select2-search--dropdown .select2-search__field {
            border-radius: 8px;
            border: 1px solid var(--input-border);
            padding: .5rem .8rem;
            font-size: .88rem;
            outline: none;
        }
        .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary) !important;
        }

        /* Input with icon */
        .input-wrap { position: relative; }
        .input-wrap .form-control { padding-left: 2.6rem; }
        .input-wrap .icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .85rem;
            pointer-events: none;
        }
        .input-wrap .toggle-pw {
            position: absolute;
            right: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            cursor: pointer;
            font-size: .85rem;
            background: none; border: none;
            padding: 0;
        }
        .input-wrap .toggle-pw:hover { color: var(--text); }

        /* Promo code special */
        .promo-wrap { position: relative; }
        .promo-wrap .form-control { padding-right: 5rem; text-transform: uppercase; }
        .promo-wrap .verify-btn {
            position: absolute;
            right: .4rem;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 7px;
            padding: .35rem .8rem;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
            font-family: inherit;
        }
        .promo-wrap .verify-btn:hover { background: var(--primary-light); }
        .promo-status { font-size: .78rem; margin-top: .3rem; }
        .promo-status.found    { color: #6ee7b7; }
        .promo-status.notfound { color: #fca5a5; }

        /* Hint text */
        .hint { font-size: .75rem; color: var(--muted); margin-top: .25rem; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: .9rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, opacity .2s;
            margin-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(79,70,229,.4); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: .7; cursor: not-allowed; }

        /* Footer link */
        .card-footer {
            border-top: 1px solid var(--border);
            padding: 1.3rem 2.5rem;
            text-align: center;
            font-size: .875rem;
            color: var(--muted);
        }
        .card-footer a { color: var(--primary-light); text-decoration: none; font-weight: 500; }
        .card-footer a:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 640px) {
            .card-header, .card-body { padding: 1.5rem; }
            .card-footer { padding: 1rem 1.5rem; }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
            .col-span-2 { grid-column: span 1; }
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Logo -->
    <div class="logo-bar">
        <div class="brand">
            <i class="fas fa-graduation-cap" style="color:var(--accent)"></i>
            i<span>Lap</span><span class="dot">.</span>
        </div>
        <p>International Learning Application Portal</p>
    </div>

    <!-- Card -->
    <div class="card">
        <!-- Header -->
        <div class="card-header">
            <h1><i class="fas fa-user-plus me-2"></i>Registration</h1>
            <p>Create your account to start your international education journey.</p>

            <!-- Steps -->
            <div class="steps">
                <div class="step-item active">
                    <div class="num">1</div>
                    <span>Basic Info</span>
                </div>
                <div class="step-sep"></div>
                <div class="step-item">
                    <div class="num">2</div>
                    <span>Profile</span>
                </div>
                <div class="step-sep"></div>
                <div class="step-item">
                    <div class="num">3</div>
                    <span>Documents</span>
                </div>
                <div class="step-sep"></div>
                <div class="step-item">
                    <div class="num">4</div>
                    <span>Application</span>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation" style="margin-top:.1rem;flex-shrink:0"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><?php echo e($error); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-circle-check" style="flex-shrink:0"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
                <?php echo csrf_field(); ?>

                <!-- ─── Personal Info ─── -->
                <div class="section-label">
                    <i class="fas fa-user"></i> Personal Information
                </div>

                <div class="grid-3">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="first_name" id="first_name" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="John" value="<?php echo e(old('first_name')); ?>" required autofocus />
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="middle_name">Middle Name <span style="color:var(--muted);font-size:.75rem;font-weight:400;">(Optional)</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="middle_name" id="middle_name" class="form-control <?php $__errorArgs = ['middle_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Middle" value="<?php echo e(old('middle_name')); ?>" />
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['middle_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname / Last Name <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="surname" id="surname" class="form-control <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Doe" value="<?php echo e(old('surname')); ?>" required />
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="john@example.com" value="<?php echo e(old('email')); ?>" required autocomplete="username" />
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="email_confirmation">Confirm Email <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" name="email_confirmation" id="email_confirmation" class="form-control"
                                   placeholder="Re-enter email address" required autocomplete="username" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="country_id">Country of Residence <span class="req">*</span></label>
                        <div class="input-wrap" style="position: relative;">
                            <i class="fas fa-globe icon" style="z-index: 2;"></i>
                            <select name="country_id" id="country_id" class="form-control select2-tags <?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-placeholder="Select or type country name..." required>
                                <option value=""></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($country->id); ?>" data-code="<?php echo e($country->phone_code); ?>" <?php echo e(old('country_id') == $country->id ? 'selected' : ''); ?>>
                                        <?php echo e($country->name); ?>

                                    </option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(old('country_id') && !is_numeric(old('country_id'))): ?>
                                    <option value="<?php echo e(old('country_id')); ?>" selected><?php echo e(old('country_id')); ?></option>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['country_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group col-span-2">
                        <label for="phone">Phone / Mobile <span class="req">*</span></label>
                        <div style="display: flex; gap: .4rem;">
                            <div class="input-wrap" style="width: 140px; position: relative;">
                                <select name="phone_code" id="phone_code" class="form-control" style="padding: .7rem 1.8rem .7rem .8rem;" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($country->phone_code); ?>" <?php echo e(old('phone_code') == $country->phone_code ? 'selected' : ''); ?>>
                                            <?php echo e($country->iso2); ?> (<?php echo e($country->phone_code); ?>)
                                        </option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </select>
                                <i class="fas fa-chevron-down" style="position: absolute; right: .8rem; top: 50%; transform: translateY(-50%); font-size: .8rem; color: var(--muted); pointer-events: none;"></i>
                            </div>
                            <div class="input-wrap" style="flex: 1;">
                                <i class="fas fa-phone icon"></i>
                                <input type="text" name="phone" id="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="1XXX XXXXXX" value="<?php echo e(old('phone')); ?>" required />
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- ─── Account Security ─── -->
                <div class="section-label">
                    <i class="fas fa-lock"></i> Account Security
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="password">Password <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Min. 8 characters" required autocomplete="new-password" />
                            <button type="button" class="toggle-pw" onclick="togglePw('password', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control" placeholder="Re-enter password" required autocomplete="new-password" />
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ─── Campus & Promo Codes ─── -->
                <div class="section-label">
                    <i class="fas fa-building"></i> Campus & Promo Codes
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="campus_code">Campus Code <span class="req">*</span></label>
                        <div class="input-wrap promo-wrap">
                            <i class="fas fa-school icon"></i>
                            <input type="text" name="campus_code" id="campus_code" class="form-control <?php $__errorArgs = ['campus_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="e.g. CMP-001" value="<?php echo e(old('campus_code', $refCampusCode ?? '')); ?>" required <?php echo e(isset($refCampusCode) ? 'readonly' : ''); ?>

                                   oninput="this.value = this.value.toUpperCase(); resetCampusStatus()" />
                            <button type="button" class="verify-btn" onclick="verifyCampus()">Verify</button>
                        </div>
                        <div class="promo-status" id="campusStatus"></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['campus_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="promo_code">Promo Code <span class="req">*</span></label>
                        <div class="promo-wrap">
                            <input type="text" name="promo_code" id="promo_code"
                                   class="form-control <?php $__errorArgs = ['promo_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="e.g. PRM123456"
                                   value="<?php echo e(old('promo_code', $refPromoCode ?? '')); ?>" required <?php echo e(isset($refPromoCode) ? 'readonly' : ''); ?>

                                   maxlength="50"
                                   oninput="this.value = this.value.toUpperCase(); resetPromoStatus()" />
                            <button type="button" class="verify-btn" onclick="verifyPromo()">Verify</button>
                        </div>
                        <div class="promo-status" id="promoStatus"></div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['promo_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-rocket"></i>
                    Create My Account
                </button>
            </form>
        </div>

        <div class="card-footer">
            Already have an account? <a href="<?php echo e(route('login')); ?>">Sign in here</a>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Verify promo code via AJAX
    function verifyPromo() {
        const code   = document.getElementById('promo_code').value.trim();
        const status = document.getElementById('promoStatus');
        if (!code) { status.textContent = ''; return; }

        status.textContent = 'Checking…';
        status.className   = 'promo-status';

        fetch(`/verify-promo?code=${encodeURIComponent(code)}`)
            .then(r => r.json())
            .then(data => {
                if (data.found) {
                    status.textContent = `✔ Valid code: ${data.agent_name}`;
                    status.className   = 'promo-status found';
                } else {
                    status.textContent = '✘ Promo code not found.';
                    status.className   = 'promo-status notfound';
                }
            })
            .catch(() => {
                status.textContent = 'Could not verify. Please continue anyway.';
                status.className   = 'promo-status notfound';
            });
    }

    function resetPromoStatus() {
        document.getElementById('promoStatus').textContent = '';
        document.getElementById('promoStatus').className = 'promo-status';
    }

    // Verify campus code via AJAX
    function verifyCampus() {
        const code   = document.getElementById('campus_code').value.trim();
        const status = document.getElementById('campusStatus');
        if (!code) { status.textContent = ''; return; }

        status.textContent = 'Checking…';
        status.className   = 'promo-status';

        fetch(`/verify-campus?code=${encodeURIComponent(code)}`)
            .then(r => r.json())
            .then(data => {
                if (data.found) {
                    status.textContent = `✔ Valid campus: ${data.campus_name}`;
                    status.className   = 'promo-status found';
                } else {
                    status.textContent = '✘ Campus code not found.';
                    status.className   = 'promo-status notfound';
                }
            })
            .catch(() => {
                status.textContent = 'Could not verify. Please continue anyway.';
                status.className   = 'promo-status notfound';
            });
    }

    function resetCampusStatus() {
        document.getElementById('campusStatus').textContent = '';
        document.getElementById('campusStatus').className = 'promo-status';
    }

    // Sync country code with phone code
    function updatePhoneCode() {
        const countrySelect = document.getElementById('country_id');
        if (!countrySelect) return;
        const selectedOption = countrySelect.options[countrySelect.selectedIndex];
        if (selectedOption) {
            const code = selectedOption.getAttribute('data-code');
            if (code) {
                document.getElementById('phone_code').value = code;
            }
        }
    }

    // Show loading state on submit
    document.getElementById('registerForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled   = true;
        btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i> Creating Account…';
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-tags').each(function() {
            const el = $(this);
            el.select2({
                tags: true,
                placeholder: el.attr('data-placeholder') || "Select or type to add if not found...",
                allowClear: true,
                width: '100%'
            }).on('change', function() {
                updatePhoneCode();
            });
        });

        updatePhoneCode();

        if (document.getElementById('campus_code').value.trim() !== '') {
            verifyCampus();
        }
        if (document.getElementById('promo_code').value.trim() !== '') {
            verifyPromo();
        }
    });
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\iLap\resources\views\auth\register.blade.php ENDPATH**/ ?>
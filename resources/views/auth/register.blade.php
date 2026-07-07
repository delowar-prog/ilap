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
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:       #4f46e5;
            --primary-light: #6366f1;
            --primary-dark:  #3730a3;
            --accent:        #06b6d4;
            --success:       #10b981;
            --danger:        #ef4444;
            --bg:            #0f172a;
            --bg2:           #1e293b;
            --card:          #1e293b;
            --border:        rgba(255,255,255,0.08);
            --text:          #f1f5f9;
            --muted:         #94a3b8;
            --input-bg:      rgba(255,255,255,0.05);
            --input-border:  rgba(255,255,255,0.12);
            --input-focus:   rgba(99,102,241,0.5);
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
            opacity: 0.18;
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
            box-shadow: 0 25px 60px rgba(0,0,0,0.45);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);
            padding: 2rem 2.5rem;
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
            opacity: .6;
            transition: opacity .3s;
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
        }
        .step-item.active .num {
            background: white;
            color: var(--primary-dark);
            border-color: white;
        }
        .step-sep { flex: 1; height: 1px; background: rgba(255,255,255,0.2); margin: 0 .4rem; }

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
            background: rgba(255,255,255,0.08);
        }
        .form-control.is-invalid {
            border-color: var(--danger);
            box-shadow: 0 0 0 3px rgba(239,68,68,.2);
        }
        .form-control option { background: var(--bg2); color: var(--text); }
        .invalid-feedback { font-size: .78rem; color: #fca5a5; margin-top: .2rem; }

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
            <h1><i class="fas fa-user-plus me-2"></i> Student Registration</h1>
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

            {{-- Validation Errors --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-circle-exclamation" style="margin-top:.1rem;flex-shrink:0"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Success --}}
            @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-circle-check" style="flex-shrink:0"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- ─── Personal Info ─── -->
                <div class="section-label">
                    <i class="fas fa-user"></i> Personal Information
                </div>

                <div class="grid-3">
                    <div class="form-group">
                        <label for="first_name">First Name <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                   placeholder="John" value="{{ old('first_name') }}" required autofocus />
                        </div>
                        @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="middle_name">Middle Name <span style="color:var(--muted);font-size:.75rem;font-weight:400;">(Optional)</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="middle_name" id="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                                   placeholder="Middle" value="{{ old('middle_name') }}" />
                        </div>
                        @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="surname">Surname / Last Name <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user icon"></i>
                            <input type="text" name="surname" id="surname" class="form-control @error('surname') is-invalid @enderror"
                                   placeholder="Doe" value="{{ old('surname') }}" required />
                        </div>
                        @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="john@example.com" value="{{ old('email') }}" required autocomplete="username" />
                        </div>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone / Mobile <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-phone icon"></i>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="+880 1XXX XXXXXX" value="{{ old('phone') }}" required />
                        </div>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min. 8 characters" required autocomplete="new-password" />
                            <button type="button" class="toggle-pw" onclick="togglePw('password', this)" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                <!-- ─── Campus & Country ─── -->
                <div class="section-label">
                    <i class="fas fa-building"></i> Campus & Location
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label for="campus_id">Select Campus <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-school icon"></i>
                            <select name="campus_id" id="campus_id" class="form-control @error('campus_id') is-invalid @enderror" required>
                                <option value="">— Choose a campus —</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }} ({{ $campus->campus_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="country_id">Country of Residence <span class="req">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-globe icon"></i>
                            <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                <option value="">— Select country —</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('country_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- ─── Agent Promo Code ─── -->
                <div class="section-label">
                    <i class="fas fa-tag"></i> Agent / Promo Code <span style="font-size:.7rem;font-weight:400;text-transform:none;letter-spacing:0;color:var(--muted);margin-left:.3rem;">(Optional)</span>
                </div>

                <div class="form-group" style="max-width:380px">
                    <label for="promo_code">Agent / Promo Code</label>
                    <div class="promo-wrap">
                        <input type="text" name="promo_code" id="promo_code"
                               class="form-control @error('promo_code') is-invalid @enderror"
                               placeholder="e.g. AGT-BD001"
                               value="{{ old('promo_code') }}"
                               maxlength="50"
                               oninput="this.value = this.value.toUpperCase(); resetPromoStatus()" />
                        <button type="button" class="verify-btn" onclick="verifyPromo()">Verify</button>
                    </div>
                    <div class="promo-status" id="promoStatus"></div>
                    <div class="hint"><i class="fas fa-info-circle me-1"></i>If referred by an agent, enter their code to link your account.</div>
                    @error('promo_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-rocket"></i>
                    Create My Account
                </button>
            </form>
        </div>

        <div class="card-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in here</a>
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
                    status.textContent = `✔ Valid code — Agent: ${data.agent_name}`;
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

    // Show loading state on submit
    document.getElementById('registerForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled   = true;
        btn.innerHTML  = '<i class="fas fa-spinner fa-spin"></i> Creating Account…';
    });
</script>
</body>
</html>

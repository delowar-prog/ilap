@extends('layouts.backend_master')

@section('admin_contents')

<div class="card mb-4">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-plus-circle me-2"></i> Create New Invoice Template
        </h5>
        <a href="{{ route('admin.invoice-templates.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Templates
        </a>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.invoice-templates.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <!-- Left Form Column -->
                <div class="col-lg-8">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Template Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Official Student Tuition Fee Invoice" value="{{ old('title') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Template Type <span class="text-danger">*</span></label>
                            <select name="type" id="type_select" class="form-select @error('type') is-invalid @enderror" onchange="toggleCustomType(this.value)" required>
                                <option value="">-- Select Type --</option>
                                @if(isset($types))
                                    @foreach($types as $typeOpt)
                                        <option value="{{ $typeOpt }}" {{ old('type') == $typeOpt ? 'selected' : '' }}>{{ $typeOpt }}</option>
                                    @endforeach
                                @endif
                                <option value="add_new" class="fw-bold text-primary">+ Add New Custom Type...</option>
                            </select>
                            <div id="custom_type_box" class="mt-2 d-none">
                                <input type="text" name="custom_type" id="custom_type_input" class="form-control border-primary" placeholder="Type new invoice type name..." value="{{ old('custom_type') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Subject / Title Heading in Invoice</label>
                        <input type="text" name="subject" class="form-control" placeholder="e.g. INVOICE FOR ACADEMIC TUITION FEES" value="{{ old('subject') }}">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fas fa-image me-1 text-info"></i> Invoice Header Image (Optional)</label>
                            <input type="file" name="header_image" class="form-control" accept="image/*">
                            <small class="text-muted">Will appear at top of generated PDF</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fas fa-image me-1 text-info"></i> Footer Pad Image (Optional)</label>
                            <input type="file" name="footer_image" class="form-control" accept="image/*">
                            <small class="text-muted">Will appear at bottom footer of generated PDF</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Invoice Body Content <span class="text-danger">*</span></label>
                        <textarea name="content_body" id="editor" class="form-control @error('content_body') is-invalid @enderror" rows="12" required>{{ old('content_body') }}</textarea>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="templateStatus" value="1" checked>
                        <label class="form-check-label fw-bold" for="templateStatus"><i class="fas fa-toggle-on text-success me-1"></i> Active Template (Available for Invoice Generation)</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 mt-3">
                        <i class="fas fa-save me-1"></i> Save Invoice Template
                    </button>
                </div>

                <!-- Right Helper Sidebar Column -->
                <div class="col-lg-4">
                    <div class="card bg-light border-primary shadow-sm">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-code me-1"></i> Dynamic Placeholders</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-primary btn-sm w-100 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#signaturePadModal">
                                    <i class="fas fa-pen-fancy me-1"></i> Draw My Digital Signature
                                </button>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{student_name}}'; ?>')">
                                    <code><?php echo '{{student_name}}'; ?></code> - Full Name
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{student_id}}'; ?>')">
                                    <code><?php echo '{{student_id}}'; ?></code> - Student Code
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{passport_number}}'; ?>')">
                                    <code><?php echo '{{passport_number}}'; ?></code> - Passport Number
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{email}}'; ?>')">
                                    <code><?php echo '{{email}}'; ?></code> - Email Address
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{phone}}'; ?>')">
                                    <code><?php echo '{{phone}}'; ?></code> - Phone Number
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{dob}}'; ?>')">
                                    <code><?php echo '{{dob}}'; ?></code> - Date of Birth
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{gender}}'; ?>')">
                                    <code><?php echo '{{gender}}'; ?></code> - Gender
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{nationality}}'; ?>')">
                                    <code><?php echo '{{nationality}}'; ?></code> - Country of Nationality
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{institute_name}}'; ?>')">
                                    <code><?php echo '{{institute_name}}'; ?></code> - Institute Name
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{course_name}}'; ?>')">
                                    <code><?php echo '{{course_name}}'; ?></code> - Applied Course
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{address}}'; ?>')">
                                    <code><?php echo '{{address}}'; ?></code> - Present Address
                                </button>
                                <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{today_date}}'; ?>')">
                                    <code><?php echo '{{today_date}}'; ?></code> - Current Date
                                </button>

                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-primary bg-opacity-10 text-primary"><i class="fas fa-signature me-1"></i> Signatures & Seals</span>
                                    <a href="{{ route('admin.official-signatures.create') }}" target="_blank" class="small text-primary text-decoration-none">+ Add New</a>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{admin_signature}}'; ?>')">
                                    <code><?php echo '{{admin_signature}}'; ?></code> - Logged-in Admin Signature
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{student_signature}}'; ?>')">
                                    <code><?php echo '{{student_signature}}'; ?></code> - Student Signature
                                </button>

                                @if(isset($officialSignatures) && count($officialSignatures) > 0)
                                    @foreach($officialSignatures as $offSig)
                                        <button type="button" class="btn btn-outline-primary btn-sm text-start bg-white" onclick="insertTag('<?php echo $offSig->tag; ?>')">
                                            <code><?php echo $offSig->tag; ?></code> - {{ $offSig->name }} ({{ $offSig->designation ?? ucfirst($offSig->type) }})
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@include('components.signature_pad_modal')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    $('#editor').summernote({
        placeholder: 'Write your invoice template content here... You can use tables, payment terms, currency codes, and placeholders.',
        tabsize: 2,
        height: 350,
        toolbar: [
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});

function toggleCustomType(val) {
    const box = document.getElementById('custom_type_box');
    const input = document.getElementById('custom_type_input');
    if (val === 'add_new') {
        box.classList.remove('d-none');
        input.required = true;
        input.focus();
    } else {
        box.classList.add('d-none');
        input.required = false;
        input.value = '';
    }
}

function insertTag(tag) {
    if (typeof $ !== 'undefined' && $('#editor').data('summernote')) {
        $('#editor').summernote('editor.insertText', ' ' + tag + ' ');
    } else {
        const editor = document.getElementById('editor');
        const start = editor.selectionStart || 0;
        const end = editor.selectionEnd || 0;
        const text = editor.value;
        editor.value = text.substring(0, start) + ' ' + tag + ' ' + text.substring(end);
    }
}
</script>
@endpush

@endsection

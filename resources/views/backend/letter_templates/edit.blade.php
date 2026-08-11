@extends('layouts.backend_master')

@section('admin_contents')

<div class="card mb-4">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-edit me-2"></i> Edit Letter Template
        </h5>
        <a href="{{ route('admin.letter-templates.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
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

        <form action="{{ route('admin.letter-templates.update', $letterTemplate->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Form Column -->
                <div class="col-lg-8">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Template Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $letterTemplate->title) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Template Type <span class="text-danger">*</span></label>
                            <select name="type" id="type_select" class="form-select @error('type') is-invalid @enderror" onchange="toggleCustomType(this.value)" required>
                                <option value="">-- Select Type --</option>
                                @if(isset($types))
                                    @foreach($types as $typeOpt)
                                        <option value="{{ $typeOpt }}" {{ old('type', $letterTemplate->type) == $typeOpt ? 'selected' : '' }}>{{ $typeOpt }}</option>
                                    @endforeach
                                @endif
                                <option value="add_new" class="fw-bold text-primary">+ Add New Custom Type...</option>
                            </select>
                            <div id="custom_type_box" class="mt-2 d-none">
                                <input type="text" name="custom_type" id="custom_type_input" class="form-control border-primary" placeholder="Type new letter type name..." value="{{ old('custom_type') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-file-invoice me-1 text-primary"></i> Select Letter Head Pad</label>
                        <select name="letter_head_id" id="letter_head_select" class="form-select @error('letter_head_id') is-invalid @enderror">
                            <option value="">-- No Letter Head Pad --</option>
                            @if(isset($letterHeads))
                                @foreach($letterHeads as $lh)
                                    <option value="{{ $lh->id }}" data-type="{{ $lh->type ?? 'all' }}" data-image="{{ asset('storage/' . $lh->image_path) }}" {{ (old('letter_head_id', $letterTemplate->letter_head_id) == $lh->id) ? 'selected' : '' }}>
                                        {{ $lh->label }} {{ $lh->type ? '('.$lh->type.')' : '' }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted">Selecting a letterhead pad will set its image (A4 or custom size) as background in the editor and PDF.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Letter Body Content <span class="text-danger">*</span></label>
                        <textarea name="content_body" id="editor" class="form-control @error('content_body') is-invalid @enderror" rows="12" required>{{ old('content_body', $letterTemplate->content_body) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 mt-3">
                        <i class="fas fa-save me-1"></i> Update Letter Template
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

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="badge bg-primary bg-opacity-10 text-primary"><i class="fas fa-tags me-1"></i> Data Tags</span>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addTagModal" class="small text-primary text-decoration-none">+ Add New</a>
                            </div>
                            <div class="d-grid gap-2" id="dynamicTagsContainer">
                                @if(isset($tags))
                                    @foreach($tags as $index => $tagObj)
                                        <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white tag-btn-item" onclick="insertTag('<?php echo $tagObj->tag; ?>')" data-index="{{ $index }}">
                                            <code><?php echo $tagObj->tag; ?></code> - {{ $tagObj->name }}
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                            <!-- Pagination Controls -->
                            <div class="d-flex justify-content-between align-items-center mt-2" id="tagPaginationControls" style="display: none;">
                                <button type="button" class="btn btn-sm btn-light border" id="prevTagPage" onclick="changeTagPage(-1)" disabled><i class="fas fa-chevron-left"></i> Prev</button>
                                <span id="tagPageInfo" class="small text-muted">Page 1</span>
                                <button type="button" class="btn btn-sm btn-light border" id="nextTagPage" onclick="changeTagPage(1)"><i class="fas fa-chevron-right"></i> Next</button>
                            </div>
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

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addTagForm">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addTagModalLabel"><i class="fas fa-plus-circle me-1"></i> Add New Dynamic Tag</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag For (Database Field) <span class="text-danger">*</span></label>
                        <select name="tag_for" id="new_tag_for" class="form-select" required>
                            <option value="">-- Select Field --</option>
                            @if(isset($studentFields))
                                @foreach($studentFields as $group => $fields)
                                    <optgroup label="{{ $group }}">
                                        @foreach($fields as $col => $label)
                                            <option value="{{ $col }}">{{ $label }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="new_tag_name" class="form-control" placeholder="e.g. Session Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag Format <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">@{{</span>
                            <input type="text" name="tag" id="new_tag_format" class="form-control" placeholder="session_name" required>
                            <span class="input-group-text">}}</span>
                        </div>
                        <small class="text-muted">Only use letters, numbers, and underscores.</small>
                    </div>
                    <div id="tagErrorMsg" class="alert alert-danger d-none py-2"></div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveTagBtn">Save Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
function updateEditorLetterHead(imageUrl) {
    if (imageUrl) {
        $('.note-editable').css({
            'background-image': 'url("' + imageUrl + '")',
            'background-size': '100% 100%',
            'background-repeat': 'no-repeat',
            'background-position': 'center top',
            'min-height': '1050px'
        });
    } else {
        $('.note-editable').css({
            'background-image': 'none',
            'min-height': '350px'
        });
    }
}

function filterLetterHeadsByType(selectedType) {
    $('#letter_head_select option').each(function() {
        const padType = $(this).data('type');
        if (!padType || padType === 'all' || !selectedType || padType === selectedType) {
            $(this).show().prop('disabled', false);
        } else {
            $(this).hide().prop('disabled', true);
        }
    });

    const currentSelected = $('#letter_head_select option:selected');
    if (currentSelected.length && currentSelected.is(':disabled')) {
        $('#letter_head_select').val('');
        $('#letter_head_select').trigger('change');
    }
}

$(document).ready(function() {
    filterLetterHeadsByType($('#type_select').val());

    $(document).on('change', '#type_select', function() {
        filterLetterHeadsByType($(this).val());
    });

    $('#editor').summernote({
        placeholder: '',
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
        ],
        callbacks: {
            onInit: function() {
                const initialImg = $('#letter_head_select').find('option:selected').data('image');
                updateEditorLetterHead(initialImg);
            }
        }
    });

    $(document).on('change', '#letter_head_select', function() {
        const imageUrl = $(this).find('option:selected').data('image') || '';
        updateEditorLetterHead(imageUrl);
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
    if(!tag) return;
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

// Client-side pagination logic for tags
let currentTagPage = 1;
const tagsPerPage = 10;

function renderTagPagination() {
    const $items = $('.tag-btn-item');
    const totalItems = $items.length;
    if (totalItems <= tagsPerPage) {
        $('#tagPaginationControls').hide();
        $items.show();
        return;
    }
    
    $('#tagPaginationControls').addClass('d-flex').show();
    const totalPages = Math.ceil(totalItems / tagsPerPage);
    
    if (currentTagPage < 1) currentTagPage = 1;
    if (currentTagPage > totalPages) currentTagPage = totalPages;
    
    $items.hide();
    const startIndex = (currentTagPage - 1) * tagsPerPage;
    const endIndex = startIndex + tagsPerPage;
    $items.slice(startIndex, endIndex).show();
    
    $('#tagPageInfo').text(`Page ${currentTagPage} of ${totalPages}`);
    $('#prevTagPage').prop('disabled', currentTagPage === 1);
    $('#nextTagPage').prop('disabled', currentTagPage === totalPages);
}

function changeTagPage(delta) {
    currentTagPage += delta;
    renderTagPagination();
}

$(document).ready(function() {
    renderTagPagination();
});

// Handle Add New Tag Form Submission
$('#addTagForm').on('submit', function(e) {
    e.preventDefault();
    
    let tagName = $('#new_tag_name').val().trim();
    let tagFormat = $('#new_tag_format').val().trim();
    let tagFor = $('#new_tag_for').val().trim();

    if (tagName === '' || tagFormat === '' || tagFor === '') {
        $('#tagErrorMsg').text('Tag For, Tag Name, and Tag Format are required.').removeClass('d-none');
        return;
    }

    $('#saveTagBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    $('#tagErrorMsg').addClass('d-none').text('');

    $.ajax({
        url: "{{ route('admin.tags.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            if(response.success) {
                // Add new tag to the list visually
                const newIndex = $('.tag-btn-item').length;
                const newTagHtml = `
                    <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white tag-btn-item" onclick="insertTag('${response.tag.tag}')" data-index="${newIndex}">
                        <code>${response.tag.tag}</code> - ${response.tag.name}
                    </button>
                `;
                $('#dynamicTagsContainer').append(newTagHtml);
                renderTagPagination();
                
                // Hide modal and reset form
                $('#addTagModal').modal('hide');
                $('#addTagForm')[0].reset();
            }
        },
        error: function(xhr) {
            let errorMsg = 'An error occurred while saving the tag.';
            if(xhr.responseJSON && xhr.responseJSON.errors) {
                errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
            } else if(xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            $('#tagErrorMsg').removeClass('d-none').text(errorMsg);
        },
        complete: function() {
            $('#saveTagBtn').prop('disabled', false).text('Save Tag');
        }
    });
});
</script>
@endpush

@endsection

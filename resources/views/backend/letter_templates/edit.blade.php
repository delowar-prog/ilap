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
                                    <option value="{{ $lh->id }}" data-type="{{ $lh->type ?? 'all' }}" data-image="{{ asset('storage/' . $lh->image_path) }}" data-margin-top="{{ $lh->margin_top ?? 130 }}" data-margin-bottom="{{ $lh->margin_bottom ?? 120 }}" data-margin-left="{{ $lh->margin_left ?? 0 }}" data-margin-right="{{ $lh->margin_right ?? 0 }}" {{ (old('letter_head_id', $letterTemplate->letter_head_id) == $lh->id) ? 'selected' : '' }}>
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
<style>
    .note-editable p {
        margin-top: 0;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
let splitTimer = null;
let currentPadImageUrl = '';
let currentPadData = null;
let currentDynamicHeight = 1050;

function applyPageSheetStyles($sheet, pageNum, imageUrl, pageHeight, padData, force) {
    const marginTop = (padData && padData.marginTop !== undefined) ? padData.marginTop : 130;
    const marginBottom = (padData && padData.marginBottom !== undefined) ? padData.marginBottom : 120;
    const marginLeft = (padData && padData.marginLeft !== undefined) ? padData.marginLeft : 0;
    const marginRight = (padData && padData.marginRight !== undefined) ? padData.marginRight : 0;

    if (force || $sheet.attr('data-page') != pageNum || !$sheet.data('styled')) {
        $sheet.attr('data-page', pageNum).data('styled', true).css({
            'background-image': 'url("' + imageUrl + '")',
            'background-size': '100% 100%',
            'background-repeat': 'no-repeat',
            'background-position': 'center top',
            'background-color': '#ffffff',
            'width': '750px',
            'min-height': pageHeight + 'px',
            'margin': '0 auto 35px auto',
            'box-shadow': '0 4px 15px rgba(0, 0, 0, 0.15)',
            'border-radius': '4px',
            'box-sizing': 'border-box',
            'padding-top': marginTop + 'px',
            'padding-bottom': marginBottom + 'px',
            'padding-left': (marginLeft > 0 ? marginLeft : 55) + 'px',
            'padding-right': (marginRight > 0 ? marginRight : 55) + 'px',
            'position': 'relative'
        });

        let $badge = $sheet.children('.page-sheet-badge');
        if (!$badge.length) {
            $badge = $('<div class="page-sheet-badge" contenteditable="false" style="position: absolute; top: 10px; right: 15px; background: rgba(0, 51, 102, 0.85); color: #ffffff; font-size: 11px; font-weight: bold; padding: 2px 10px; border-radius: 12px; z-index: 100; pointer-events: none; user-select: none;">Page ' + pageNum + '</div>');
            $sheet.append($badge);
        } else {
            $badge.text('Page ' + pageNum);
        }
    }
}

function saveSelection() {
    if (window.getSelection) {
        const sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            return sel.getRangeAt(0);
        }
    }
    return null;
}

function moveCursorToEndOfNode($node) {
    if (!$node.length) return;
    const el = $node[0];
    if (window.getSelection && document.createRange) {
        const range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false); // collapse to END
        const sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
        el.scrollIntoView && el.scrollIntoView({ block: 'nearest' });
    }
}

let isBalancing = false;

function autoSplitPages() {
    if (isBalancing || !currentPadImageUrl || !currentDynamicHeight) return;
    isBalancing = true;

    try {
        const $editable = $('.note-editable');
        if (!$editable.length) return;

        let $sheets = $editable.children('.page-sheet');
        if (!$sheets.length) return;

        const marginBottom = (currentPadData && currentPadData.marginBottom !== undefined) ? currentPadData.marginBottom : 120;
        const marginTop = (currentPadData && currentPadData.marginTop !== undefined) ? currentPadData.marginTop : 130;
        const effectiveBottomMargin = (marginBottom > 30) ? (marginBottom - 25) : marginBottom;
        const maxAllowedContentHeight = currentDynamicHeight - marginTop - effectiveBottomMargin;

        let domChanged = false;
        let $overflowTargetSheet = null;
        let $lastOverflowNode = null; // page sheet where overflow nodes landed

        // STEP 1: Pull content up from next sheet with safety margin
        for (let i = 0; i < $sheets.length - 1; i++) {
            let $currSheet = $($sheets[i]);
            let $nextSheet = $($sheets[i + 1]);

            let currContentHeight = 0;
            $currSheet.children().not('.page-sheet-badge').each(function() {
                currContentHeight += ($(this).outerHeight(true) || 24);
            });

            let pullLimit = 30;
            while ($nextSheet.children().not('.page-sheet-badge').length > 0 && pullLimit > 0) {
                pullLimit--;
                let $firstNextChild = $nextSheet.children().not('.page-sheet-badge').first();
                let childH = $firstNextChild.outerHeight(true) || 24;

                if (currContentHeight + childH + 5 <= maxAllowedContentHeight) {
                    $currSheet.append($firstNextChild);
                    currContentHeight += childH;
                    domChanged = true;
                } else {
                    break;
                }
            }
        }

        // STEP 2: Push spillage down to next sheets
        $sheets = $editable.children('.page-sheet');
        $sheets.each(function(index) {
            let $sheet = $(this);
            let pageNum = index + 1;

            let accumulatedHeight = 0;
            let overflowNodes = [];

            $sheet.children().not('.page-sheet-badge').each(function() {
                let $child = $(this);
                let h = $child.outerHeight(true) || 24;
                accumulatedHeight += h;

                if (accumulatedHeight > maxAllowedContentHeight && $sheet.children().not('.page-sheet-badge').length > 1) {
                    overflowNodes.push($child);
                }
            });

            if (overflowNodes.length > 0) {
                domChanged = true;
                let $nextSheet = $editable.children('.page-sheet[data-page="' + (pageNum + 1) + '"]');
                if (!$nextSheet.length) {
                    $nextSheet = $('<div class="page-sheet" data-page="' + (pageNum + 1) + '"></div>');
                    $sheet.after($nextSheet);
                }
                for (let i = overflowNodes.length - 1; i >= 0; i--) {
                    $nextSheet.prepend(overflowNodes[i]);
                }
                if (!$overflowTargetSheet) {
                    $overflowTargetSheet = $nextSheet;
                    $lastOverflowNode = overflowNodes[overflowNodes.length - 1];
                }
            }
        });

        // STEP 3: Remove completely empty trailing sheets (except Page 1)
        // Only remove if NO children at all — do NOT remove pages with <p><br> (cursor position)
        $editable.children('.page-sheet').each(function(idx) {
            let $sheet = $(this);
            let $contentChildren = $sheet.children().not('.page-sheet-badge');
            if (idx > 0 && $contentChildren.length === 0) {
                $sheet.remove();
                domChanged = true;
            }
        });

        // STEP 4: Re-style all sheets when DOM changed & move cursor to next page
        if (domChanged) {
            $editable.children('.page-sheet').each(function(idx) {
                applyPageSheetStyles($(this), idx + 1, currentPadImageUrl, currentDynamicHeight, currentPadData, true);
            });

            if ($lastOverflowNode && $lastOverflowNode.length > 0) {
                try {
                    moveCursorToEndOfNode($lastOverflowNode);
                } catch(e) {}
            }
        }
    } finally {
        isBalancing = false;
    }
}

function triggerAutoSplitPages() {
    clearTimeout(splitTimer);
    splitTimer = setTimeout(autoSplitPages, 300);
}

function updateEditorLetterHead(imageUrl, padData) {
    currentPadImageUrl = imageUrl;
    currentPadData = padData;

    const $editable = $('.note-editable');
    if (!imageUrl) {
        $editable.css({
            'background': '#ffffff',
            'padding': '15px',
            'min-height': '350px'
        });
        $editable.children('.page-sheet').each(function() {
            $(this).replaceWith($(this).contents());
        });
        return;
    }

    const img = new Image();
    img.onload = function() {
        const containerWidth = 750;
        currentDynamicHeight = (this.naturalWidth && this.naturalHeight) 
            ? Math.round(containerWidth * (this.naturalHeight / this.naturalWidth)) 
            : 1050;

        $editable.css({
            'background-color': '#e9ecef',
            'padding': '25px 15px',
            'min-height': (currentDynamicHeight + 50) + 'px'
        });

        let $sheets = $editable.children('.page-sheet');
        if ($sheets.length === 0) {
            // Restore saved multi-page content by splitting on page-break-before divs
            const rawHtml = $editable.html().trim();
            const pageBreakPattern = /<div[^>]*style=["'][^"']*page-break-before\s*:\s*always[^"']*["'][^>]*>\s*<\/div>/gi;

            if (pageBreakPattern.test(rawHtml)) {
                // Multi-page content — split into pages
                const pages = rawHtml.split(/<div[^>]*style=["'][^"']*page-break-before\s*:\s*always[^"']*["'][^>]*>\s*<\/div>/gi);
                let sheetsHtml = '';
                pages.forEach(function(pageContent, idx) {
                    const content = pageContent.trim() || '<p><br></p>';
                    sheetsHtml += '<div class="page-sheet" data-page="' + (idx + 1) + '">' + content + '</div>';
                });
                $editable.html(sheetsHtml);
            } else {
                // Single page content
                const contents = rawHtml || '<p><br></p>';
                $editable.html('<div class="page-sheet" data-page="1">' + contents + '</div>');
            }
            $sheets = $editable.children('.page-sheet');
        }

        $sheets.each(function(idx) {
            applyPageSheetStyles($(this), idx + 1, imageUrl, currentDynamicHeight, padData);
        });

        triggerAutoSplitPages();
    };
    img.src = imageUrl;
}

function getPadDataFromSelect() {
    const $opt = $('#letter_head_select').find('option:selected');
    if (!$opt.length || !$opt.val()) return null;
    return {
        imageUrl: $opt.data('image') || '',
        marginTop: parseInt($opt.data('margin-top')) || 130,
        marginBottom: parseInt($opt.data('margin-bottom')) || 120,
        marginLeft: parseInt($opt.data('margin-left')) || 0,
        marginRight: parseInt($opt.data('margin-right')) || 0
    };
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
                const padData = getPadDataFromSelect();
                updateEditorLetterHead(padData ? padData.imageUrl : '', padData);
            },
            onChange: function() {
                triggerAutoSplitPages();
            },
            onKeyup: function() {
                triggerAutoSplitPages();
            },
            onPaste: function() {
                triggerAutoSplitPages();
            }
        }
    });

    $(document).on('change', '#letter_head_select', function() {
        const padData = getPadDataFromSelect();
        updateEditorLetterHead(padData ? padData.imageUrl : '', padData);
    });

    $('form').on('submit', function() {
        const $editable = $('.note-editable');
        const $sheets = $editable.children('.page-sheet');
        if ($sheets.length > 0) {
            let fullHtml = '';
            $sheets.each(function(i) {
                if (i > 0) {
                    fullHtml += '<div style="page-break-before: always;"></div>';
                }
                let $clone = $(this).clone();
                $clone.find('.page-sheet-badge').remove();
                fullHtml += $clone.html();
            });
            $('#editor').val(fullHtml);
        }
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

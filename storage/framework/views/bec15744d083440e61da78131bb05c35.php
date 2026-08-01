<?php $__env->startSection('admin_contents'); ?>

<div class="card mb-4">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-plus-circle me-2"></i> Create New Letter Template
        </h5>
        <a href="<?php echo e(route('admin.letter-templates.index')); ?>" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Templates
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

        <form action="<?php echo e(route('admin.letter-templates.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row">
                <!-- Left Form Column -->
                <div class="col-lg-8">
                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Template Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="e.g. Official Student Offer Letter" value="<?php echo e(old('title')); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Template Type <span class="text-danger">*</span></label>
                            <select name="type" id="type_select" class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" onchange="toggleCustomType(this.value)" required>
                                <option value="">-- Select Type --</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($types)): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <option value="<?php echo e($typeOpt); ?>" <?php echo e(old('type') == $typeOpt ? 'selected' : ''); ?>><?php echo e($typeOpt); ?></option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <option value="add_new" class="fw-bold text-primary">+ Add New Custom Type...</option>
                            </select>
                            <div id="custom_type_box" class="mt-2 d-none">
                                <input type="text" name="custom_type" id="custom_type_input" class="form-control border-primary" placeholder="Type new letter type name..." value="<?php echo e(old('custom_type')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Subject / Title Heading in Letter</label>
                        <input type="text" name="subject" class="form-control" placeholder="e.g. LETTER OF ACCEPTANCE FOR ACADEMIC ADMISSION" value="<?php echo e(old('subject')); ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="fas fa-image me-1 text-info"></i> Letterhead Header Image (Optional)</label>
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
                        <label class="form-label fw-bold">Letter Body Content <span class="text-danger">*</span></label>
                        <textarea name="content_body" id="editor" class="form-control <?php $__errorArgs = ['content_body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="12" required><?php echo e(old('content_body')); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 mt-3">
                        <i class="fas fa-save me-1"></i> Save Letter Template
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
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($tags)): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tagObj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <button type="button" class="btn btn-outline-dark btn-sm text-start bg-white tag-btn-item" onclick="insertTag('<?php echo $tagObj->tag; ?>')" data-index="<?php echo e($index); ?>">
                                            <code><?php echo $tagObj->tag; ?></code> - <?php echo e($tagObj->name); ?>

                                        </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                                    <a href="<?php echo e(route('admin.official-signatures.create')); ?>" target="_blank" class="small text-primary text-decoration-none">+ Add New</a>
                                </div>

                                <button type="button" class="btn btn-outline-primary btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{admin_signature}}'; ?>')">
                                    <code><?php echo '{{admin_signature}}'; ?></code> - Logged-in Admin Signature
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm text-start bg-white" onclick="insertTag('<?php echo '{{student_signature}}'; ?>')">
                                    <code><?php echo '{{student_signature}}'; ?></code> - Student Signature
                                </button>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($officialSignatures) && count($officialSignatures) > 0): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $officialSignatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offSig): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <button type="button" class="btn btn-outline-primary btn-sm text-start bg-white" onclick="insertTag('<?php echo $offSig->tag; ?>')">
                                            <code><?php echo $offSig->tag; ?></code> - <?php echo e($offSig->name); ?> (<?php echo e($offSig->designation ?? ucfirst($offSig->type)); ?>)
                                        </button>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php echo $__env->make('components.signature_pad_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Add Tag Modal -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addTagForm">
                <?php echo csrf_field(); ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addTagModalLabel"><i class="fas fa-plus-circle me-1"></i> Add New Dynamic Tag</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag For (Database Field) <span class="text-danger">*</span></label>
                        <select name="tag_for" id="new_tag_for" class="form-select" required>
                            <option value="">-- Select Field --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($studentFields)): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $studentFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <optgroup label="<?php echo e($group); ?>">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                            <option value="<?php echo e($col); ?>"><?php echo e($label); ?></option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    </optgroup>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="new_tag_name" class="form-control" placeholder="e.g. Session Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag Format <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">{{</span>
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

<?php $__env->startPush('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
$(document).ready(function() {
    $('#editor').summernote({
        placeholder: 'Write your letter content here... You can use Bold, Underline, Bullet points, Tables, and Dynamic tags.',
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
        url: "<?php echo e(route('admin.tags.store')); ?>",
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
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.backend_master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\iLap\resources\views\backend\letter_templates\create.blade.php ENDPATH**/ ?>
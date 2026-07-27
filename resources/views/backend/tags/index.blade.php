@extends('layouts.backend_master')

@section('admin_contents')
<div class="card mb-4">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-tags me-2"></i> Data Tags List
        </h5>
        <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#createTagModal">
            <i class="fas fa-plus-circle me-1"></i> Add New Tag
        </button>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Name (Label)</th>
                        <th>Tag Format</th>
                        <th width="150" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tags as $key => $tag)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $tag->name }}</td>
                            <td><code>{{ $tag->tag }}</code></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#editTagModal{{ $tag->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.tags.destroy', $tag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this tag?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editTagModal{{ $tag->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content text-start">
                                    <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title"><i class="fas fa-edit me-1"></i> Edit Tag</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tag For (Database Field) <span class="text-danger">*</span></label>
                                                <select name="tag_for" class="form-select" required>
                                                    <option value="">-- Select Field --</option>
                                                    @if(isset($studentFields))
                                                        @foreach($studentFields as $group => $fields)
                                                            <optgroup label="{{ $group }}">
                                                                @foreach($fields as $col => $label)
                                                                    <option value="{{ $col }}" {{ $tag->tag_for == $col ? 'selected' : '' }}>{{ $label }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tag Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{ $tag->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tag Format <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text">@{{</span>
                                                    @php
                                                        $rawTag = str_replace(['{{', '}}'], '', $tag->tag);
                                                    @endphp
                                                    <input type="text" name="tag" class="form-control" value="{{ $rawTag }}" required>
                                                    <span class="input-group-text">}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update Tag</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No tags created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createTagModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.tags.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle me-1"></i> Add New Tag</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag For (Database Field) <span class="text-danger">*</span></label>
                        <select name="tag_for" class="form-select" required>
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
                        <input type="text" name="name" class="form-control" placeholder="e.g. Session Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tag Format <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">@{{</span>
                            <input type="text" name="tag" class="form-control" placeholder="session_name" required>
                            <span class="input-group-text">}}</span>
                        </div>
                        <small class="text-muted">Only use letters, numbers, and underscores.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('head_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // For Create Modal
        const createModal = document.getElementById('createTagModal');
        if (createModal) {
            const tagForSelect = createModal.querySelector('select[name="tag_for"]');
            const tagNameInput = createModal.querySelector('input[name="name"]');
            const tagFormatInput = createModal.querySelector('input[name="tag"]');

            if (tagForSelect && tagNameInput && tagFormatInput) {
                tagForSelect.addEventListener('change', function () {
                    if (this.value) {
                        const selectedOption = this.options[this.selectedIndex];
                        tagNameInput.value = selectedOption.text;
                        tagFormatInput.value = this.value;
                    } else {
                        tagNameInput.value = '';
                        tagFormatInput.value = '';
                    }
                });
            }
        }
        
        // For Edit Modals
        const editModals = document.querySelectorAll('[id^="editTagModal"]');
        editModals.forEach(modal => {
            const tagForSelect = modal.querySelector('select[name="tag_for"]');
            const tagNameInput = modal.querySelector('input[name="name"]');
            const tagFormatInput = modal.querySelector('input[name="tag"]');

            if (tagForSelect && tagNameInput && tagFormatInput) {
                tagForSelect.addEventListener('change', function () {
                    if (this.value) {
                        const selectedOption = this.options[this.selectedIndex];
                        tagNameInput.value = selectedOption.text;
                        tagFormatInput.value = this.value;
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection

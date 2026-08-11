@extends('layouts.backend_master')

@section('admin_contents')

<div class="card mb-3">
    <div class="card-header py-3 bg-light">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0 text-primary fw-bold">
                    <i class="fas fa-file-alt me-2"></i> Letter Templates Engine
                </h5>
                <small class="text-muted">Create, edit and manage dynamic letter templates for student generation</small>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.letter-templates.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-plus me-1"></i> Add New Template
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">

        <form method="GET" action="{{ route('admin.letter-templates.index') }}" class="row g-2 mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search templates by title or type..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="">-- All Template Types --</option>
                    @if(isset($types))
                        @foreach($types as $typeOpt)
                            <option value="{{ $typeOpt }}" {{ request('type') == $typeOpt ? 'selected' : '' }}>{{ $typeOpt }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort_dir" class="form-select" onchange="this.form.submit()">
                    <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Newest First (DESC)</option>
                    <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Oldest First (ASC)</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
                @if(request('search') || request('type') || request('sort_dir'))
                    <a href="{{ route('admin.letter-templates.index') }}" class="btn btn-outline-danger" title="Reset Filters"><i class="fas fa-redo"></i></a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle border">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Template Title</th>
                        <th>Type</th>
                        <th>Letter Head Pad</th>
                        <th class="text-center">Status</th>
                        <th>Created At</th>
                        <th class="text-end" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $index => $template)
                        <tr>
                            <td>{{ $templates->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $template->title }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-secondary text-uppercase">{{ $template->type }}</span>
                            </td>
                            <td>
                                @if($template->letterHead)
                                    <span class="badge bg-primary"><i class="fas fa-file-image me-1"></i> {{ $template->letterHead->label }}</span>
                                @else
                                    <span class="text-muted small">None</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input template-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-id="{{ $template->id }}" 
                                           data-url="{{ route('admin.letter-templates.toggle', $template->id) }}"
                                           {{ $template->status ? 'checked' : '' }} 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>
                            <td>{{ $template->created_at ? $template->created_at->format('d M, Y') : 'N/A' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.letter-templates.preview', $template->id) }}" class="btn btn-sm btn-info text-white me-1" title="Preview Dummy Output">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.letter-templates.edit', $template->id) }}" class="btn btn-sm btn-primary me-1" title="Edit Template">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.letter-templates.destroy', $template->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn-confirm" data-text="You want to delete this letter template!" title="Delete Template">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                                No letter templates found. Click <strong>Add New Template</strong> to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $templates->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).on('change', '.template-status-toggle', function() {
    const switchEl = $(this);
    const url = switchEl.data('url');
    const isChecked = switchEl.is(':checked');

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'PATCH'
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            if (typeof toastr !== 'undefined') {
                toastr.success('Status updated successfully');
            } else if (typeof Swal !== 'undefined') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Status updated successfully'
                });
            }
        },
        error: function(xhr) {
            switchEl.prop('checked', !isChecked);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update status. Please try again.'
                });
            } else {
                alert('Failed to update status.');
            }
        }
    });
});
</script>
@endpush

@endsection

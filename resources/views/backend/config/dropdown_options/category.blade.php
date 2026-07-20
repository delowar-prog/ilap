@extends('layouts.backend_master')
@section('title', 'Manage — ' . $categoryName)

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0">
                <i class="fas fa-sliders-h me-2"></i> {{ $categoryName }}
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.config.dropdown.index') }}">Configuration</a></li>
                    <li class="breadcrumb-item active">{{ $categoryName }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    {{-- LEFT: Options List --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-list me-2 text-primary"></i>Current Options</h6>
                <small class="text-muted">Drag rows to reorder</small>
            </div>
            <div class="card-body p-0">
                @if($options->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        No options yet. Add one using the form on the right.
                    </div>
                @else
                    <table class="table table-hover align-middle mb-0" id="sortable-table">
                        <thead class="table-light">
                            <tr>
                                <th width="36" class="text-center text-muted"><i class="fas fa-grip-vertical"></i></th>
                                <th>Label</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="160" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-body">
                            @foreach($options as $opt)
                            <tr data-id="{{ $opt->id }}" class="{{ $opt->is_active ? '' : 'table-secondary opacity-75' }}">
                                <td class="text-center text-muted" style="cursor:grab;">
                                    <i class="fas fa-grip-vertical"></i>
                                </td>
                                <td>
                                    {{-- Inline edit form --}}
                                    <form action="{{ route('admin.config.dropdown.update', $opt->id) }}" method="POST"
                                          class="d-flex gap-2 align-items-center" id="edit-form-{{ $opt->id }}">
                                        @csrf @method('PUT')
                                        <input type="text" name="label" value="{{ $opt->label }}"
                                               class="form-control form-control-sm"
                                               style="max-width:280px;" required>
                                        <input type="hidden" name="is_active" value="{{ $opt->is_active ? '1' : '0' }}">
                                        <button type="submit" class="btn btn-sm btn-outline-primary px-2" title="Save">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    @if($opt->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        {{-- Toggle active --}}
                                        <form action="{{ route('admin.config.dropdown.toggle', $opt->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $opt->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                    data-bs-toggle="tooltip"
                                                    title="{{ $opt->is_active ? 'Disable' : 'Enable' }}">
                                                <i class="fas {{ $opt->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                            </button>
                                        </form>
                                        {{-- Delete --}}
                                        <form action="{{ route('admin.config.dropdown.destroy', $opt->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" title="Delete"
                                                    onclick="return confirm('Delete this option?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    {{-- RIGHT: Add New Option --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-plus-circle me-2 text-success"></i>Add New Option</h6>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger py-2 mb-3">
                        @foreach($errors->all() as $e)
                            <div class="small">{{ $e }}</div>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('admin.config.dropdown.store', $category) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Option Label <span class="text-danger">*</span></label>
                        <input type="text" name="label" class="form-control" value="{{ old('label') }}"
                               placeholder="e.g. United Kingdom (UK)" required autofocus>
                        <small class="text-muted">This is exactly what will show in the dropdown.</small>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus me-1"></i> Add Option
                    </button>
                </form>

                <hr>

                <a href="{{ route('admin.config.dropdown.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-arrow-left me-1"></i> Back to All Categories
                </a>
            </div>
        </div>

        {{-- Info card --}}
        <div class="card border-0 shadow-sm mt-3 border-start border-info border-3">
            <div class="card-body py-3">
                <h6 class="fw-semibold text-info mb-2"><i class="fas fa-info-circle me-1"></i>How it works</h6>
                <ul class="small text-muted mb-0 ps-3">
                    <li>Add options here and they appear in dropdowns across the project.</li>
                    <li>Disable an option to hide it from forms without deleting.</li>
                    <li>Drag rows to change the display order.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
    const tbody = document.getElementById('sortable-body');
    if (tbody) {
        Sortable.create(tbody, {
            animation: 150,
            handle: '.fa-grip-vertical',
            onEnd: function () {
                const rows = tbody.querySelectorAll('tr[data-id]');
                const order = Array.from(rows).map((r, i) => r.dataset.id);
                fetch('{{ route('admin.config.dropdown.reorder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ order })
                });
            }
        });
    }
    // Init tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush

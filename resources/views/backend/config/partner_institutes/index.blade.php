@extends('layouts.backend_master')
@section('title', 'Manage — Partner Institutes')

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0">
                <i class="fas fa-university me-2"></i> Partner Institutes
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.config.dropdown.index') }}">Configuration</a></li>
                    <li class="breadcrumb-item active">Partner Institutes</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row mt-3">
    {{-- LEFT: Options List --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-list me-2 text-primary"></i>Current Partner Institutes</h6>
            </div>
            <div class="card-body p-0">
                @if($options->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        No partner institutes yet. Add one using the form on the right.
                    </div>
                @else
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Institute Details</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($options as $opt)
                            <tr class="{{ $opt->is_active ? '' : 'table-secondary opacity-75' }}">
                                <td>
                                    {{-- Inline edit form --}}
                                    <form action="{{ route('admin.config.partner_institutes.update', $opt->id) }}" method="POST" id="edit-form-{{ $opt->id }}">
                                        @csrf @method('PUT')
                                        <div class="row g-2 align-items-center">
                                            <div class="col-md-5">
                                                <input type="text" name="name" value="{{ $opt->name }}"
                                                       class="form-control form-control-sm" placeholder="Name" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="country" value="{{ $opt->country }}"
                                                       class="form-control form-control-sm" placeholder="Country">
                                            </div>
                                            <div class="col-md-10 mt-1">
                                                <input type="url" name="website" value="{{ $opt->website }}"
                                                       class="form-control form-control-sm" placeholder="Website (https://...)">
                                            </div>
                                            <div class="col-md-2 mt-1">
                                                <button type="submit" class="btn btn-sm btn-outline-primary px-2 w-100" title="Save Changes">
                                                    <i class="fas fa-save"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block m-0">
                                        <input class="form-check-input option-status-toggle" 
                                               type="checkbox" 
                                               role="switch" 
                                               data-url="{{ route('admin.config.partner_institutes.toggle', $opt->id) }}"
                                               {{ $opt->is_active ? 'checked' : '' }} 
                                               style="cursor: pointer; width: 2.6em; height: 1.3em;">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        {{-- Delete --}}
                                        <form action="{{ route('admin.config.partner_institutes.destroy', $opt->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" title="Delete"
                                                    onclick="return confirm('Delete this institute?')">
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

    {{-- RIGHT: Add New Form --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-plus-circle me-2 text-success"></i>Add New Institute</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.config.partner_institutes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">INSTITUTE NAME <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               placeholder="e.g. University of Oxford" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">COUNTRY</label>
                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                               placeholder="e.g. United Kingdom" value="{{ old('country') }}">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">WEBSITE</label>
                        <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                               placeholder="e.g. https://www.ox.ac.uk" value="{{ old('website') }}">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fas fa-plus me-1"></i> Add Institute
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // AJAX Toggle Switch
    $(document).on('change', '.option-status-toggle', function() {
        const switchEl = $(this);
        const url = switchEl.data('url');
        const isChecked = switchEl.is(':checked');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PATCH'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                const tr = switchEl.closest('tr');
                if (isChecked) {
                    tr.removeClass('table-secondary opacity-75');
                } else {
                    tr.addClass('table-secondary opacity-75');
                }

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
            error: function() {
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

    // Init tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush

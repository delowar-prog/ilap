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
                                    <form action="{{ route('admin.config.dropdown.update', $opt->id) }}" method="POST" enctype="multipart/form-data"
                                          class="d-flex gap-2 align-items-center" id="edit-form-{{ $opt->id }}">
                                        @csrf @method('PUT')
                                        <div class="d-flex flex-column gap-1">
                                             <div class="d-flex gap-2 align-items-center">
                                                 <input type="text" name="label" value="{{ $opt->label }}"
                                                        class="form-control form-control-sm"
                                                        style="max-width:280px;" required placeholder="Label">
                                                 @if($category === 'letter_head' && $opt->type)
                                                     <span class="badge bg-info text-dark" title="Assigned Type">{{ $opt->type }}</span>
                                                 @endif
                                                 <input type="hidden" name="is_active" value="{{ $opt->is_active ? '1' : '0' }}">
                                                 <button type="submit" class="btn btn-sm btn-outline-primary px-2" title="Save">
                                                     <i class="fas fa-save"></i>
                                                 </button>
                                             </div>
                                            @if($category === 'department')
                                            <div class="d-flex gap-2 align-items-center mt-1">
                                                <input type="text" name="country" value="{{ $opt->country }}"
                                                       class="form-control form-control-sm"
                                                       style="max-width:140px;" placeholder="Country">
                                                <input type="url" name="website" value="{{ $opt->website }}"
                                                       class="form-control form-control-sm"
                                                       style="max-width:180px;" placeholder="Website (url)">
                                            </div>
                                            @endif
                                            @if($category === 'letter_head')
                                            <div class="d-flex gap-2 align-items-center mt-1 flex-wrap">
                                                <select name="type" class="form-select form-select-sm" style="max-width:140px;" title="Assigned Template Type">
                                                    <option value="">-- All Types --</option>
                                                    @if(isset($templateTypes))
                                                        @foreach($templateTypes as $tType)
                                                            <option value="{{ $tType }}" {{ $opt->type == $tType ? 'selected' : '' }}>{{ $tType }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if($opt->image_path)
                                                    <a href="{{ asset('storage/' . $opt->image_path) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $opt->image_path) }}" alt="Pad" class="img-thumbnail" style="height:35px; width:auto;" title="View Pad Image">
                                                    </a>
                                                @endif
                                                <input type="file" name="image" class="form-control form-control-sm" style="max-width:160px;" accept="image/*" title="Change Pad Image">
                                            </div>
                                            <div class="d-flex gap-2 align-items-center mt-1 flex-wrap bg-light p-1 rounded border">
                                                <small class="fw-bold text-muted" style="font-size:11px;">Margins (px):</small>
                                                <input type="number" name="margin_top" value="{{ $opt->margin_top ?? 130 }}" class="form-control form-control-sm" style="width:70px;" title="Top Margin (Header Height)" placeholder="Top">
                                                <input type="number" name="margin_bottom" value="{{ $opt->margin_bottom ?? 120 }}" class="form-control form-control-sm" style="width:70px;" title="Bottom Margin (Footer Height)" placeholder="Bot">
                                                <input type="number" name="margin_left" value="{{ $opt->margin_left ?? 0 }}" class="form-control form-control-sm" style="width:70px;" title="Left Margin" placeholder="Left">
                                                <input type="number" name="margin_right" value="{{ $opt->margin_right ?? 0 }}" class="form-control form-control-sm" style="width:70px;" title="Right Margin" placeholder="Right">
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-inline-block m-0">
                                        <input class="form-check-input option-status-toggle" 
                                               type="checkbox" 
                                               role="switch" 
                                               data-id="{{ $opt->id }}" 
                                               data-url="{{ route('admin.config.dropdown.toggle', $opt->id) }}"
                                               {{ $opt->is_active ? 'checked' : '' }} 
                                               style="cursor: pointer; width: 2.6em; height: 1.3em;">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
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

    {{-- RIGHT: Add New Form --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-plus-circle me-2 text-success"></i>Add New Option</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.config.dropdown.store', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">LABEL / NAME</label>
                        <input type="text" name="label" class="form-control @error('label') is-invalid @enderror"
                               placeholder="{{ $category === 'letter_head' ? 'e.g. Official A4 Pad' : 'e.g. Higher Secondary' }}" value="{{ old('label') }}" required>
                        @error('label')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @if($category === 'department')
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">COUNTRY</label>
                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                               placeholder="e.g. UK" value="{{ old('country') }}">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">WEBSITE</label>
                        <input type="url" name="website" class="form-control @error('website') is-invalid @enderror"
                               placeholder="https://..." value="{{ old('website') }}">
                        @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                    @if($category === 'letter_head')
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">ASSIGN TO TEMPLATE TYPE</label>
                        <select name="type" class="form-select">
                            <option value="">-- All Template Types --</option>
                            @if(isset($templateTypes))
                                @foreach($templateTypes as $tType)
                                    <option value="{{ $tType }}" {{ old('type') == $tType ? 'selected' : '' }}>{{ $tType }}</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="text-muted d-block mt-1">Select specific template type or leave blank for all types.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">LETTER HEAD PAD IMAGE (ANY SIZE / A4)</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        <small class="text-muted d-block mt-1">Upload letterhead background pad image of any size (PNG, JPG, WebP, SVG).</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label text-dark small fw-bold mb-2"><i class="fas fa-sliders-h me-1 text-primary"></i> PAD MARGIN CONFIGURATION (px)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label font-12 text-muted mb-1">Top Margin (Header)</label>
                                <input type="number" name="margin_top" class="form-control form-control-sm" placeholder="Auto / 130" value="{{ old('margin_top') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label font-12 text-muted mb-1">Bottom Margin (Footer)</label>
                                <input type="number" name="margin_bottom" class="form-control form-control-sm" placeholder="Auto / 120" value="{{ old('margin_bottom') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label font-12 text-muted mb-1">Left Margin (Side)</label>
                                <input type="number" name="margin_left" class="form-control form-control-sm" placeholder="0" value="{{ old('margin_left', 0) }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label font-12 text-muted mb-1">Right Margin (Side)</label>
                                <input type="number" name="margin_right" class="form-control form-control-sm" placeholder="0" value="{{ old('margin_right', 0) }}">
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1 font-11">Top & Bottom will be auto-detected if left empty. Left & Right margins default to 0 (optional).</small>
                    </div>
                    @endif
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="fas fa-plus me-1"></i> Add Option
                    </button>
                </form>
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

@extends('layouts.backend_master')

@section('admin_contents')
    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-university me-2"></i>
                        Institute Management
                    </h6>
                </div>
                <div class="col-auto">
                    @if(!auth()->user()->hasRole(['Student', 'student']))
                    <a href="{{ route('institutes.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Add Institute
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="table-responsive" style="overflow: visible;">
            <table class="table table-sm table-hover table-bordered align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Institute</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Status</th>
                        @if(!auth()->user()->hasRole(['Student', 'student']))
                        <th width="90" class="text-center">Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($institutes as $institute)
                        <tr>
                            <td class="text-center">{{ $institutes->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($institute->logo)
                                        <img src="{{ url($institute->logo) }}" width="32" height="32" class="rounded-circle me-2" style="object-fit:cover;">
                                    @else
                                        <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ substr($institute->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $institute->name }}</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ $institute->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">
                                    {{ $institute->code ?? 'N/A' }}
                                </span>
                            </td>
                            <td>{{ $institute->city ? $institute->city . ', ' . $institute->country : $institute->country }}</td>
                            <td class="text-center">
                                @if ($institute->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 0.75rem;">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger" style="font-size: 0.75rem;">Inactive</span>
                                @endif
                            </td>
                            @if(!auth()->user()->hasRole(['Student', 'student']))
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        <a href="{{ route('institutes.edit', $institute->id) }}" class="dropdown-item py-1">
                                            <i class="fas fa-edit me-2 text-warning"></i>Edit
                                        </a>
                                        <form action="{{ route('institutes.destroy', $institute->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No Institutes Found</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer py-2">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Showing {{ $institutes->firstItem() ?? 0 }} - {{ $institutes->lastItem() ?? 0 }} of {{ $institutes->total() }} records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    {{ $institutes->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
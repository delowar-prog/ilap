@extends('layouts.backend_master')

@section('admin_contents')
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-percentage me-2"></i>
                    Commission Management
                </h6>
            </div>
            <div class="col-auto">
                @can('commission add')
                    <a href="{{ route('commissions.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Setup Commission
                    </a>
                @endcan
            </div>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search agent name or code..." value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="agent_id" class="form-select form-select-sm">
                        <option value="">All Agents</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->agent_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="commission_type" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Types</option>
                        <option value="flat" {{ request('commission_type') == 'flat' ? 'selected' : '' }}>Flat</option>
                        <option value="percentage" {{ request('commission_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Newest First (DESC)</option>
                        <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Oldest First (ASC)</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Agent</th>
                    <th>Agent Type</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Created</th>
                    <th width="120" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $commission)
                    <tr>
                        <td class="text-center">{{ $commissions->firstItem() + $loop->index }}</td>
                        
                        <td>
                            <div class="fw-semibold">{{ $commission->agent->name }}</div>
                            <small class="text-muted">
                                <i class="fas fa-ticket-alt me-1"></i>{{ $commission->agent->agent_code }}
                            </small>
                        </td>

                        <td>
                            @if($commission->agent->agent_type == 'master')
                                <span class="badge bg-primary bg-opacity-10 text-primary">Master</span>
                            @else
                                <span class="badge bg-info bg-opacity-10 text-info">Sub-Agent</span>
                            @endif
                        </td>

                        <td>
                            @if($commission->course)
                                <div class="fw-semibold">{{ $commission->course->name }}</div>
                                <small class="text-muted">
                                    Fee: {{ $commission->course->currency }} {{ number_format($commission->course->fee, 2) }}
                                </small>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-globe me-1"></i>All Courses
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($commission->commission_type == 'percentage')
                                <span class="badge bg-warning bg-opacity-10 text-warning">
                                    <i class="fas fa-percent me-1"></i>Percentage
                                </span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    <i class="fas fa-money-bill me-1"></i>Flat
                                </span>
                            @endif
                        </td>

                        <td class="fw-bold text-primary">
                            @if($commission->commission_type == 'percentage')
                                {{ $commission->amount }}%
                            @else
                                {{ number_format($commission->amount, 2) }}
                            @endif
                        </td>

                        <td>
                            <span class="badge bg-dark bg-opacity-10 text-dark">
                                {{ $commission->currency }}
                            </span>
                        </td>

                        <td>
                            <small class="text-muted">
                                {{ $commission->created_at->diffForHumans() }}
                            </small>
                        </td>

                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" 
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                    @can('commission edit')
                                        <a href="{{ route('commissions.edit', $commission->id) }}" class="dropdown-item py-1">
                                            <i class="fas fa-edit me-2 text-warning"></i>Edit
                                        </a>
                                    @endcan

                                    @can('commission delete')
                                        <form action="{{ route('commissions.destroy', $commission->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item py-1 text-danger"
                                                    onclick="return confirm('Are you sure you want to delete this commission?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No Commission Found</h6>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="card-footer py-2">
        <div class="row align-items-center">
            <div class="col-md-6 text-end">
                {{ $commissions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
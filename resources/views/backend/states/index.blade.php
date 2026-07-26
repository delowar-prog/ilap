@extends('layouts.backend_master')

@section('admin_contents')
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-map-marker-alt me-2"></i> States Management
                </h6>
            </div>
            <div class="col-auto">
                <a href="{{ route('states.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add State
                </a>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search state name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="country_id" class="form-select form-select-sm">
                        <option value="">All Countries</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Country</th>
                    <th>State Name</th>
                    <th>State Code</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th width="100" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($states as $state)
                    <tr>
                        <td class="text-center">{{ $states->firstItem() + $loop->index }}</td>
                        <td>{{ $state->country->name }}</td>
                        <td class="fw-semibold">{{ $state->name }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $state->state_code ?? 'N/A' }}</span></td>
                        <td>{{ $state->type ?? 'N/A' }}</td>
                        <td class="text-center">
                            <div class="form-check form-switch d-inline-block m-0">
                                <input class="form-check-input global-status-toggle" 
                                       type="checkbox" 
                                       role="switch" 
                                       data-url="{{ route('status.toggle', ['modelType' => 'state', 'id' => $state->id]) }}"
                                       {{ $state->status == 'active' ? 'checked' : '' }} 
                                       style="cursor: pointer; width: 2.8em; height: 1.4em;">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('states.edit', $state->id) }}" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="{{ route('states.destroy', $state->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No State Found</h6>
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
                    Showing {{ $states->firstItem() ?? 0 }} - {{ $states->lastItem() ?? 0 }} of {{ $states->total() }}
                </small>
            </div>
            <div class="col-md-6 text-end">
                {{ $states->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
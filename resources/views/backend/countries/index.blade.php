@extends('layouts.backend_master')

@section('admin_contents')
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-globe me-2"></i> Countries Management
                </h6>
            </div>
            <div class="col-auto">
                <a href="{{ route('countries.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add Country
                </a>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search country name or ISO code..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
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
                    <th>Country Name</th>
                    <th>ISO Code</th>
                    <th>Phone Code</th>
                    <th>Currency</th>
                    <th>Capital</th>
                    <th>Status</th>
                    <th width="100" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td class="text-center">{{ $countries->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $country->name }}</td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $country->iso2 ?? 'N/A' }} / {{ $country->iso3 ?? 'N/A' }}
                            </span>
                        </td>
                        <td>{{ $country->phone_code ?? 'N/A' }}</td>
                        <td>{{ $country->currency }} {{ $country->currency_symbol }}</td>
                        <td>{{ $country->capital ?? 'N/A' }}</td>
                        <td>
                            @if($country->status == 'active')
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('countries.edit', $country->id) }}" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="{{ route('countries.destroy', $country->id) }}" method="POST">
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
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No Country Found</h6>
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
                    Showing {{ $countries->firstItem() ?? 0 }} - {{ $countries->lastItem() ?? 0 }} of {{ $countries->total() }}
                </small>
            </div>
            <div class="col-md-6 text-end">
                {{ $countries->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
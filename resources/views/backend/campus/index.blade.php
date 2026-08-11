@extends('layouts.backend_master')

@section('admin_contents')
    <div class="card mb-3">
        <div class="card-header py-2"> <!-- py-2 added for compact header -->
            <div class="row align-items-center">
                <div class="col">
                    <!-- Heading changed to h6 for smaller size -->
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-code-branch me-2"></i>
                        Campus Management
                    </h6>
                </div>

                <div class="col-auto">
                    @can('campus add')
                        <a href="{{ route('campuses.create') }}" class="btn btn-primary btn-sm"> <!-- btn-sm added -->
                            <i class="fas fa-plus me-1"></i> Add Campus
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body border-bottom py-3"> <!-- py-3 for compact padding -->
            <form method="GET">
                <div class="row g-2"> <!-- g-2 for tighter grid gap -->

                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search campus..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <select name="country" class="form-select form-select-sm">
                            <option value="">All Countries</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="sort_dir" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="desc" {{ request('sort_dir', 'desc') == 'desc' ? 'selected' : '' }}>Newest First (DESC)</option>
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Oldest First (ASC)</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Rows</option>
                            <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 Rows</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Rows</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Rows</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div class="table-responsive">
            <!-- table-sm and inline font-size added for compact data display -->
            <table class="table table-sm table-hover table-bordered align-middle mb-0" style="font-size: 0.85rem;">

                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Campus</th>
                        <th>Code</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Status</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($campuses as $campus)
                        <tr>
                            <td class="text-center">
                                {{ $campuses->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center">
                                    @if ($campus->logo)
                                        <img src="{{ asset($campus->logo) }}" width="32" height="32" class="rounded-circle me-2">
                                    @else
                                        <div class="bg-light text-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ substr($campus->name, 0, 1) }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $campus->name }}
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            {{ $campus->phone ?? 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info" style="font-size: 0.75rem;">
                                    {{ $campus->campus_code }}
                                </span>
                            </td>

                            <td>{{ $campus->country }}</td>
                            <td>{{ $campus->city }}</td>

                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input global-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-url="{{ route('status.toggle', ['modelType' => 'campus', 'id' => $campus->id]) }}"
                                           {{ ($campus->status == 1 || $campus->status == 'active') ? 'checked' : '' }} 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        @can('Campus View')
                                            <a href="{{ route('campuses.show', $campus->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        @endcan
                                        @can('Campus Edit')
                                            <a href="{{ route('campuses.edit', $campus->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        @endcan
                                        @can('Campus Delete')
                                            <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
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
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No Branch Found</h6>
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
                        Showing {{ $campuses->firstItem() ?? 0 }} - {{ $campuses->lastItem() ?? 0 }} of {{ $campuses->total() }} records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    <!-- Pagination will now render correctly if you added Paginator::useBootstrapFive() in AppServiceProvider -->
                    {{ $campuses->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
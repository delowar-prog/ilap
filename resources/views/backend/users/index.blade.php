@extends('layouts.backend_master')

@push('css')
@endpush
@section('admin_contents')

    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-users me-2"></i>
                        User Management
                    </h6>
                </div>

                <div class="col-auto">
                    @can('user add')
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add User
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body border-bottom py-3">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Search name or email..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="campus_id" class="form-select form-select-sm">
                            <option value="">All Campus</option>
                            @foreach ($campuses as $campus)
                                <option value="{{ $campus->id }}"
                                    {{ request('campus_id') == $campus->id ? 'selected' : '' }}>
                                    {{ $campus->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="role" class="form-select form-select-sm">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
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
                        <th width="50" class="text-center">ID</th>
                        <th>User Name</th>
                        <th>Campus Code</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Fource Login</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="text-center">{{ $users->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="fw-semibold">{{ $user->user_first_name . ' ' . $user->user_last_name }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 0.75rem;">
                                    {{ $user->campus->campus_code ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                @foreach ($user->getRoleNames() as $roleName)
                                    <span class="badge bg-info bg-opacity-10 text-info"
                                        style="font-size: 0.75rem;">{{ $roleName }}</span>
                                @endforeach
                            </td>

                            <td>{{ $user->phone ?? 'N/A' }}</td>

                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block m-0">
                                    <input class="form-check-input global-status-toggle" 
                                           type="checkbox" 
                                           role="switch" 
                                           data-url="{{ route('status.toggle', ['modelType' => 'user', 'id' => $user->id]) }}"
                                           {{ ($user->status == 1 || $user->status == 'active') ? 'checked' : '' }} 
                                           style="cursor: pointer; width: 2.8em; height: 1.4em;">
                                </div>
                            </td>

                            <td class="text-start">
                                {{-- প্যাকেজটি অটোমেটিক্যালি canImpersonate() এবং canBeImpersonated() চেক করে নেয় --}}
                                @if (auth()->user()->canImpersonate() && $user->canBeImpersonated())
                                    <form action="{{ route('impersonate', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-warning" 
                                                data-bs-toggle="tooltip" 
                                                title="Login as User">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>


                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        @can('user view')
                                            <a href="{{ route('users.show', $user->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        @endcan

                                        @can('edit user')
                                            <a href="{{ route('users.edit', $user->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        @endcan

                                        @can('delete user')
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-1 text-danger"
                                                    onclick="return confirm('Are you sure?')">
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
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No User Found</h6>
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
                        Showing {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                        records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

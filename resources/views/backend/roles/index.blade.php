@extends('layouts.backend_master')

@section('admin_contents')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i>
                        Role Management
                    </h5>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Role Name</th>
                        <th>Created At</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $roles->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $role->name }}
                                </div>
                                @if($role->name === 'Super Admin')
                                    <small class="text-danger">
                                        <i class="fas fa-crown me-1"></i>Super Admin
                                    </small>
                                @endif
                            </td>



                            <td>{{ $role->created_at->format('d M Y') }}</td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-falcon-default dropdown-toggle" data-bs-toggle="dropdown">
                                        Action
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('role edit')
                                            <a href="{{ route('roles.permissions', $role->id) }}" class="dropdown-item">
                                                <i class="fas fa-key me-2"></i>Edit Role
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6>No Role Found</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-md-6">
                    Showing {{ $roles->firstItem() ?? 0 }} - {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} records
                </div>
                <div class="col-md-6 text-end">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
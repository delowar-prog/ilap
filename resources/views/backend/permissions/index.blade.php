@extends('layouts.backend_master')

@section('admin_contents')
    <div class="card mb-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        Permission Management
                    </h5>
                </div>
            </div>
        </div>

        <!-- Add New Permission Form -->
        <div class="card-body border-bottom">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label">
                            Add New Permission <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Enter permission name (e.g., manage users, view reports)"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Ex: Branch View, User Add
                        </small>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-1"></i>
                            Add Permission
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Permissions Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Permission Name</th>
                        <th>Group</th>
                        <th>Used In Roles</th>
                        <th>Created At</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $permissions->firstItem() + $loop->index }}</td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $permission->name }}
                                </div>
                            </td>

                            <td>
                                @php
                                    $group = explode(' ', $permission->name)[1] ?? 'general';
                                @endphp
                                <span class="badge bg-secondary text-capitalize">
                                    {{ $group }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $rolesCount = \Spatie\Permission\Models\Role::permission($permission)->count();
                                @endphp
                                @if($rolesCount > 0)
                                    <span class="badge bg-info">
                                        {{ $rolesCount }} {{ Str::plural('role', $rolesCount) }}
                                    </span>
                                @else
                                    <span class="text-muted">Not used</span>
                                @endif
                            </td>

                            <td>{{ $permission->created_at->format('d M Y') }}</td>

                            <td>
                                @if($rolesCount == 0)
                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" 
                                          >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled title="Cannot delete - in use">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h6>No Permission Found</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-md-6">
                    Showing {{ $permissions->firstItem() ?? 0 }} - {{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() }} records
                </div>
                <div class="col-md-6 text-end">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">
            <i class="fas fa-key me-2"></i>
            Manage Permissions for: <span class="text-primary">{{ $role->name }}</span>
        </h5>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('roles.permissions.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            
            <!-- Select All Button -->
            <div class="mb-3">
                <button type="button" class="btn btn-sm btn-primary" id="selectAll">
                    <i class="fas fa-check-double me-1"></i> Select All
                </button>
                <button type="button" class="btn btn-sm btn-secondary" id="deselectAll">
                    <i class="fas fa-times me-1"></i> Deselect All
                </button>
            </div>

            <hr>

            <!-- Permission Groups -->
            @foreach($allPermissions as $group => $permissions)
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 text-capitalize">
                            <i class="fas fa-shield-alt me-2"></i>
                            {{ $group }} Permissions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input 
                                            type="checkbox" 
                                            name="permissions[]" 
                                            value="{{ $permission->name }}" 
                                            class="form-check-input permission-checkbox"
                                            id="permission_{{ $permission->id }}"
                                            {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Permissions
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        selectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => checkbox.checked = true);
        });

        deselectAllBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => checkbox.checked = false);
        });
    });
</script>
@endpush
@endsection
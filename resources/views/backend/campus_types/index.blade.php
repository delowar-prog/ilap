@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i> Campus Types
        </h5>
        <a href="{{ route('admin.campus-types.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th width="150" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campusTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration + $campusTypes->firstItem() - 1 }}</td>
                            <td>{{ $type->name }}</td>
                            <td>
                                <span class="badge bg-{{ $type->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($type->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.campus-types.edit', $type->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.campus-types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this campus type?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No campus types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    @if($campusTypes->hasPages())
        <div class="card-footer">
            {{ $campusTypes->links() }}
        </div>
    @endif
</div>
@endsection

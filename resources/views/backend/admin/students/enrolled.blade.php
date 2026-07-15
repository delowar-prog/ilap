@extends('layouts.backend_master')

@section('title', 'Enrolled Students')

@section('admin_contents')
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-users text-primary me-2"></i> Enrolled Students</h5>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive" style="min-height: 350px;">
                    <table class="table table-hover align-middle mb-0 custom-table">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td>{{ $loop->iteration + $students->firstItem() - 1 }}</td>
                                <td><span class="badge bg-secondary">{{ $student->student_id }}</span></td>
                                <td>
                                    <strong>{{ $student->first_name }} {{ $student->surname }}</strong>
                                    @if($student->nationality)
                                    <br><small class="text-muted">{{ $student->nationality }}</small>
                                    @endif
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-success">Enrolled</span>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" data-bs-boundary="window">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.students.show', $student->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-info"></i>View Profile
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No students found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $students->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

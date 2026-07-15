@extends('layouts.backend_master')

@section('title', 'All Students')

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-users text-primary me-2"></i> All Students</h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index', ['status' => 'pending']) }}" 
                           class="nav-link rounded-0 {{ $status == 'pending' ? 'active' : '' }}">
                            <i class="mdi mdi-clock-outline me-1"></i> Pending
                            <span class="badge bg-danger rounded-pill ms-1">{{ $counts['pending'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index', ['status' => 'approved']) }}" 
                           class="nav-link rounded-0 {{ $status == 'approved' ? 'active' : '' }}">
                            <i class="mdi mdi-check-circle-outline me-1"></i> Approved
                            <span class="badge bg-success rounded-pill ms-1">{{ $counts['approved'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index', ['status' => 'rejected']) }}" 
                           class="nav-link rounded-0 {{ $status == 'rejected' ? 'active' : '' }}">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Rejected
                            <span class="badge bg-warning rounded-pill ms-1">{{ $counts['rejected'] }}</span>
                        </a>
                    </li>
                </ul>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="bg-light text-muted">
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
                                    @if($student->enrolment_status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($student->enrolment_status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
                                            Action
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.students.show', $student->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-info"></i>View Profile
                                            </a>
                                            @if($student->enrolment_status === 'pending')
                                                <form action="{{ route('admin.students.approve', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-1 text-success" onclick="return confirm('Approve Pre-Enrolment?');">
                                                        <i class="fas fa-check me-2"></i>Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.students.reject', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Reject Pre-Enrolment?');">
                                                        <i class="fas fa-times me-2"></i>Reject
                                                    </button>
                                                </form>
                                            @endif
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
                    {{ $students->appends(['status' => $status])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

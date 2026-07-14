@extends('layouts.backend_master')

@section('title', 'All Students')

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-users text-primary me-2"></i> All Students</h5>
            </div>
            <div class="card-body p-0">
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
                                <td>{{ $loop->iteration }}</td>
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
                                    @if($student->preAssessment)
                                        @if($student->preAssessment->assessment_status === 'approved')
                                            <span class="badge bg-success">PA Approved</span>
                                        @elseif($student->preAssessment->assessment_status === 'rejected')
                                            <span class="badge bg-danger">PA Rejected</span>
                                        @else
                                            <span class="badge bg-warning text-dark">PA Pending</span>
                                        @endif
                                    @else
                                        <span class="badge bg-light text-muted">PA Not Submitted</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View Profile
                                    </a>
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
            </div>
        </div>
    </div>
</div>
@endsection

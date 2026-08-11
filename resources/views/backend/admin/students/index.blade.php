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
                            <i class="mdi mdi-check-circle-outline me-1"></i> Approved (Unassigned)
                            <span class="badge bg-success rounded-pill ms-1">{{ $counts['approved'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index', ['status' => 'assigned']) }}" 
                           class="nav-link rounded-0 {{ $status == 'assigned' ? 'active' : '' }}">
                            <i class="mdi mdi-school-outline me-1"></i> Course Assigned
                            <span class="badge bg-info rounded-pill ms-1">{{ $counts['assigned'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index', ['status' => 'rejected']) }}" 
                           class="nav-link rounded-0 {{ $status == 'rejected' ? 'active' : '' }}">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Rejected
                            <span class="badge bg-warning rounded-pill ms-1">{{ $counts['rejected'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.students.index', ['status' => 'terminated']) }}" 
                           class="nav-link rounded-0 {{ $status == 'terminated' ? 'active' : '' }}">
                            <i class="mdi mdi-account-off-outline me-1"></i> Terminated
                            <span class="badge bg-dark rounded-pill ms-1">{{ $counts['terminated'] ?? 0 }}</span>
                        </a>
                    </li>
                </ul>

                {{-- Filter Toolbar --}}
                <form method="GET" action="{{ route('admin.students.index') }}" class="mb-3">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                    <input type="hidden" name="sort_dir" value="{{ $sortDir }}">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        {{-- Left: per-page & sort direction --}}
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_st" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
                                @foreach([10, 20, 50, 100] as $n)
                                    <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <span class="text-muted" style="font-size:0.82rem;">entries</span>

                            <select name="sort_dir" class="form-select form-select-sm ms-2" style="width:160px;" onchange="this.form.submit()">
                                <option value="desc" {{ $sortDir == 'desc' ? 'selected' : '' }}>Newest First (DESC)</option>
                                <option value="asc" {{ $sortDir == 'asc' ? 'selected' : '' }}>Oldest First (ASC)</option>
                            </select>
                        </div>
                        {{-- Right: search + button --}}
                        <div class="d-flex align-items-center gap-2">
                            <div class="input-group" style="width:300px;">
                                <span class="input-group-text bg-white" style="border-right:0;"><i class="fas fa-search text-muted" style="font-size:0.8rem;"></i></span>
                                <input type="text" name="search" class="form-control form-control-sm border-start-0"
                                       placeholder="Search name, email, phone, ID..."
                                       value="{{ $search }}" style="box-shadow:none;">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary px-3">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            @if($search)
                                <a href="{{ route('admin.students.index', ['status' => $status, 'per_page' => $perPage]) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="min-height: 350px;">
                    <table class="table table-hover table-bordered mb-0 align-middle">
                        <thead class="bg-light text-muted">
                            <tr>
                                @php
                                    function stSort($col, $label, $sortBy, $sortDir, $status, $search, $perPage, $route = 'admin.students.index') {
                                        $dir = ($sortBy === $col && $sortDir === 'asc') ? 'desc' : 'asc';
                                        $icon = $sortBy === $col ? ($sortDir === 'asc' ? '▲' : '▼') : '⇅';
                                        $url = route($route, compact('status', 'search', 'perPage') + ['sort_by' => $col, 'sort_dir' => $dir]);
                                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} <small>{$icon}</small></a>";
                                    }
                                @endphp
                                <th>#</th>
                                <th>{!! stSort('student_id', 'Student ID', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th>{!! stSort('first_name', 'Name', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th>Campus</th>
                                <th>{!! stSort('phone', 'Phone', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
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
                                    <strong>{{ trim($student->first_name.' '.$student->surname) }}</strong>
                                    @if($student->nationality)
                                    <br><small class="text-muted">{{ $student->nationality }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($student->campus)
                                        <span class="badge bg-info text-dark">{{ $student->campus->name }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>
                                    @if($status === 'assigned')
                                        <span class="badge bg-info">Assigned</span>
                                    @elseif($student->enrolment_status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($student->enrolment_status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                     <div class="d-flex align-items-center justify-content-center gap-1">
                                         <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-xs btn-outline-info" data-bs-toggle="tooltip" title="View Profile">
                                             <i class="fas fa-eye"></i>
                                         </a>
                                         
                                         @if($student->enrolment_status === 'pending')
                                             <button type="button" class="btn btn-xs btn-outline-success btn-approve-enrol" data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->surname }}" data-bs-toggle="tooltip" title="Approve">
                                                 <i class="fas fa-check"></i>
                                             </button>
                                             <button type="button" class="btn btn-xs btn-outline-danger btn-reject-enrol" data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->surname }}" data-bs-toggle="tooltip" title="Reject">
                                                 <i class="fas fa-times"></i>
                                             </button>
                                         @elseif($student->enrolment_status === 'approved')
                                             @php $completion = $student->getCompletionPercentage(); @endphp
                                             @if($student->applications->isEmpty())
                                                 <a href="{{ route('admin.students.enrolment', $student->id) }}" class="btn btn-xs btn-outline-success" data-bs-toggle="tooltip" title="Manage Course & Fees">
                                                     <i class="fas fa-file-invoice-dollar"></i>
                                                 </a>
                                             @endif
                                              <button type="button" class="btn btn-xs btn-outline-primary btn-send-student" data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->surname }}" data-completion="{{ $completion }}" data-bs-toggle="tooltip" title="Send to Student (Completion: {{ $completion }}%)">
                                                  <i class="fas fa-paper-plane"></i>
                                              </button>
                                         @elseif($student->enrolment_status === 'rejected')
                                             <button type="button" class="btn btn-xs btn-outline-warning btn-revert-enrol" data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->surname }}" data-bs-toggle="tooltip" title="Move to Pending">
                                                 <i class="fas fa-undo"></i>
                                             </button>
                                             <button type="button" class="btn btn-xs btn-outline-danger btn-delete-student" data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->surname }}" data-bs-toggle="tooltip" title="Delete">
                                                 <i class="fas fa-trash-alt"></i>
                                             </button>
                                         @endif
                                     </div>
                                 </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>No students found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing {{ $students->firstItem() ?? 0 }}–{{ $students->lastItem() ?? 0 }} of {{ $students->total() }} records
                    </small>
                    {{ $students->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showToast(message, isSuccess) {
    if (typeof toastr !== 'undefined') {
        if (isSuccess) {
            toastr.success(message);
        } else {
            toastr.error(message);
        }
    } else {
        alert(message);
    }
}

$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // 1. Send to Student Action with SweetAlert & Toastr validation
    $(document).on('click', '.btn-send-student', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        const completion = parseInt($(this).data('completion'));
        
        Swal.fire({
            title: 'Send to Student?',
            text: `Are you sure you want to move "${studentName}" to the Enrolled Students section? (Profile Completion: ${completion}%)`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Send',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call AJAX
                $.ajax({
                    url: `/admin/students/${studentId}/send-to-student`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 2. Approve Enrolment Action
    $(document).on('click', '.btn-approve-enrol', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Approve Pre-Enrolment?',
            text: `Are you sure you want to approve "${studentName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}/approve`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 3. Reject Enrolment Action
    $(document).on('click', '.btn-reject-enrol', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Reject Pre-Enrolment?',
            text: `Are you sure you want to reject "${studentName}"?`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}/reject`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 4. Revert Enrolment Action
    $(document).on('click', '.btn-revert-enrol', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Revert to Pending?',
            text: `Are you sure you want to move "${studentName}" back to Pending?`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Revert',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}/revert-to-pending`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });

    // 5. Delete Student Action
    $(document).on('click', '.btn-delete-student', function(e) {
        e.preventDefault();
        const studentId = $(this).data('id');
        const studentName = $(this).data('name');
        
        Swal.fire({
            title: 'Delete Student?',
            text: `Are you sure you want to permanently delete student "${studentName}" and their user record? This action is irreversible!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/students/${studentId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.success) {
                            showToast(response.message, true);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showToast(response.message, false);
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        showToast(errorMsg, false);
                    }
                });
            }
        });
    });
});
</script>
@endpush


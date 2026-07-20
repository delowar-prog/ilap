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

                {{-- Filter Toolbar --}}
                <form method="GET" action="{{ route('admin.students.index') }}" class="mb-3">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                    <input type="hidden" name="sort_dir" value="{{ $sortDir }}">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        {{-- Left: per-page --}}
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_st" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
                                @foreach([10, 20, 50, 100] as $n)
                                    <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
                                @endforeach
                            </select>
                            <span class="text-muted" style="font-size:0.82rem;">entries</span>
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
                                <th>{!! stSort('email', 'Email', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
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
                                        <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" data-bs-boundary="window">
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
                                            @elseif($student->enrolment_status === 'approved')
                                                <form action="{{ route('admin.students.send_to_student', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-1 text-primary" onclick="return confirm('Send to Student? All data will be moved to the Student section.');">
                                                        <i class="fas fa-paper-plane me-2"></i>Send to Student
                                                    </button>
                                                </form>
                                            @elseif($student->enrolment_status === 'rejected')
                                                <form action="{{ route('admin.students.revert_to_pending', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item py-1 text-warning" onclick="return confirm('Move this student back to Pending?');">
                                                        <i class="fas fa-undo me-2"></i>Move to Pending
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure you want to delete this student and their user record?');">
                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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

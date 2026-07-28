@extends('layouts.backend_master')
@section('title', 'Pre-Assessments')

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Pre-Assessments</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    <li class="nav-item">
                        <a href="{{ route('admin.pre.assessments.index', ['status' => 'pending']) }}" 
                           class="nav-link rounded-0 {{ $status == 'pending' ? 'active' : '' }}">
                            <i class="mdi mdi-clock-outline me-1"></i> Pending
                            <span class="badge bg-danger rounded-pill ms-1">{{ $counts['pending'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pre.assessments.index', ['status' => 'approved']) }}" 
                           class="nav-link rounded-0 {{ $status == 'approved' ? 'active' : '' }}">
                            <i class="mdi mdi-check-circle-outline me-1"></i> Approved
                            <span class="badge bg-success rounded-pill ms-1">{{ $counts['approved'] }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pre.assessments.index', ['status' => 'rejected']) }}" 
                           class="nav-link rounded-0 {{ $status == 'rejected' ? 'active' : '' }}">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Rejected
                            <span class="badge bg-warning rounded-pill ms-1">{{ $counts['rejected'] }}</span>
                        </a>
                    </li>
                </ul>


                {{-- Filter Toolbar --}}
                <form method="GET" action="{{ route('admin.pre.assessments.index') }}" class="mb-3">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                    <input type="hidden" name="sort_dir" value="{{ $sortDir }}">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        {{-- Left: per-page --}}
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_pa" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
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
                                       placeholder="Search name, email, phone..."
                                       value="{{ $search }}" style="box-shadow:none;">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary px-3">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                            @if($search)
                                <a href="{{ route('admin.pre.assessments.index', ['status' => $status, 'per_page' => $perPage]) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                @php
                                    function paSort($col, $label, $sortBy, $sortDir, $status, $search, $perPage) {
                                        $dir = ($sortBy === $col && $sortDir === 'asc') ? 'desc' : 'asc';
                                        $icon = $sortBy === $col ? ($sortDir === 'asc' ? '▲' : '▼') : '⇅';
                                        $url = route('admin.pre.assessments.index', compact('status', 'search', 'perPage') + ['sort_by' => $col, 'sort_dir' => $dir]);
                                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} <small>{$icon}</small></a>";
                                    }
                                @endphp
                                <th>{!! paSort('first_name', 'First Name', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th>{!! paSort('middle_name', 'Middle Name', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th>{!! paSort('surname', 'Last Name', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th>Campus</th>
                                <th>Email</th>
                                <th>{!! paSort('contact_number', 'Phone', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th>Study Destination</th>
                                <th>{!! paSort('updated_at', 'Submitted At', $sortBy, $sortDir, $status, $search, $perPage) !!}</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessments as $assessment)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">
                                            <a href="{{ route('admin.pre.assessments.show', $assessment->id) }}" class="text-body">
                                                {{ $assessment->first_name ?? $assessment->student->first_name }}
                                            </a>
                                        </h5>
                                    </td>
                                    <td>{{ $assessment->middle_name ?? $assessment->student->middle_name ?? '-' }}</td>
                                    <td>{{ $assessment->surname ?? $assessment->student->surname }}</td>
                                    <td>
                                        @if($assessment->student && $assessment->student->campus)
                                            <span class="badge bg-info text-dark">{{ $assessment->student->campus->name }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $assessment->student->email ?? '-' }}</td>
                                    <td>{{ $assessment->contact_number ?? $assessment->student->phone }}</td>
                                    <td>{{ $assessment->study_destination ?? '-' }}</td>
                                    <td>{{ $assessment->updated_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.pre.assessments.show', $assessment->id) }}" 
                                           class="btn btn-sm btn-info" 
                                           data-bs-toggle="tooltip" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($assessment->assessment_status === 'approved')
                                            <form action="{{ route('admin.pre.assessments.send_to_pre_enrolment', $assessment->id) }}" method="POST" class="d-inline-block ms-1">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-primary" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Send to Pre-Enrolment"
                                                        onclick="return confirm('Send this student to Pre-Enrolment?');">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($assessment->assessment_status === 'rejected')
                                            <form action="{{ route('admin.pre.assessments.revert_to_pending', $assessment->id) }}" method="POST" class="d-inline-block ms-1">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-warning" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Move to Pending"
                                                        onclick="return confirm('Move this application back to Pending?');">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.pre.assessments.destroy', $assessment->id) }}" method="POST" class="d-inline-block ms-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Delete Assessment"
                                                        onclick="return confirm('Are you sure you want to delete this pre-assessment?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                        No assessments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">
                        Showing {{ $assessments->firstItem() ?? 0 }}–{{ $assessments->lastItem() ?? 0 }} of {{ $assessments->total() }} records
                    </small>
                    {{ $assessments->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

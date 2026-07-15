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

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Study Destination</th>
                                <th>Submitted At</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessments as $assessment)
                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1">
                                            <a href="{{ route('admin.pre.assessments.show', $assessment->id) }}" class="text-body">
                                                {{ $assessment->full_name ?? $assessment->student->first_name }}
                                            </a>
                                        </h5>
                                    </td>
                                    <td>{{ $assessment->student->email ?? '-' }}</td>
                                    <td>{{ $assessment->contact_number ?? $assessment->student->phone }}</td>
                                    <td>{{ $assessment->study_destination ?? '-' }}</td>
                                    <td>{{ $assessment->updated_at->format('d M Y, h:i A') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.pre.assessments.show', $assessment->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i> View
                                        </a>
                                        @if($assessment->assessment_status === 'approved')
                                            <form action="{{ route('admin.pre.assessments.send_to_pre_enrolment', $assessment->id) }}" method="POST" class="d-inline-block ms-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Send this student to Pre-Enrolment?');">
                                                    <i class="mdi mdi-send"></i> Send to Pre-Enrolment
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No assessments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $assessments->appends(['status' => $status])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

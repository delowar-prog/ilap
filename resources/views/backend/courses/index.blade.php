@extends('layouts.backend_master')

@section('admin_contents')
<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-book me-2"></i> Course Management
                </h6>
            </div>
            <div class="col-auto">
                @if(!auth()->user()->hasRole(['Student', 'student']))
                <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add Course
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search name, code or institute..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="course_type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="ilap" {{ request('course_type') == 'ilap' ? 'selected' : '' }}>iLAP Own</option>
                        <option value="external" {{ request('course_type') == 'external' ? 'selected' : '' }}>External</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        <option value="short" {{ request('category') == 'short' ? 'selected' : '' }}>Short</option>
                        <option value="long" {{ request('category') == 'long' ? 'selected' : '' }}>Long</option>
                        <option value="degree" {{ request('category') == 'degree' ? 'selected' : '' }}>Degree</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-responsive" style="overflow: visible;">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Institute</th>
                    <th>Category</th>
                    <th>Duration</th>
                    <th>Fee</th>
                    <th>Intake</th>
                    <th>Status</th>
                    @if(!auth()->user()->hasRole(['Student', 'student']))
                    <th width="120" class="text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td class="text-center">{{ $courses->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold">{{ $course->name }}</div>
                            <small class="text-muted">
                                <i class="fas fa-hashtag me-1"></i>{{ $course->course_code ?? 'N/A' }}
                            </small>
                            @if($course->is_featured)
                                <span class="badge bg-warning text-dark ms-1">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($course->is_ilap_course)
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    <i class="fas fa-home me-1"></i>iLAP Own
                                </span>
                            @else
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-university me-1"></i>External
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($course->is_ilap_course)
                                <span class="text-muted">iLAP Institute</span>
                            @else
                                <div>{{ $course->partner_institute ?? 'N/A' }}</div>
                                @if($course->institute_country)
                                    <small class="text-muted">
                                        <i class="fas fa-globe me-1"></i>{{ $course->institute_country }}
                                    </small>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($course->category)
                                <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                    {{ ucfirst($course->category) }}
                                </span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>{{ $course->duration ?? 'N/A' }}</td>
                        <td class="fw-bold text-primary">
                            {{ $course->currency }} {{ number_format($course->fee, 2) }}
                        </td>
                        <td>
                            @if($course->intake)
                                <small>{{ $course->intake }}</small>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $course->status === 'active' ? 'success' : ($course->status === 'archived' ? 'secondary' : 'danger') }}">
                                {{ ucfirst($course->status) }}
                            </span>
                        </td>
                        @if(!auth()->user()->hasRole(['Student', 'student']))
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item py-1 text-danger"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No Course Found</h6>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer py-2">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    Showing {{ $courses->firstItem() ?? 0 }} - {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }}
                </small>
            </div>
            <div class="col-md-6 text-end">
                {{ $courses->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
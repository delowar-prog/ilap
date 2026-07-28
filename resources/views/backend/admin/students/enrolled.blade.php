@extends('layouts.backend_master')

@section('title', 'Enrolled Students')

@section('admin_contents')
<div class="row g-3">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold" style="color: #2c3e7a;"><i class="fas fa-users text-primary me-2"></i> Enrolled Students</h5>
            </div>
            
            <div class="card-body">
                {{-- Filter Toolbar --}}
                <form method="GET" action="{{ route('admin.students.enrolled') }}" class="mb-3">
                    <input type="hidden" name="sort_by" value="{{ $sortBy }}">
                    <input type="hidden" name="sort_dir" value="{{ $sortDir }}">
                    <div class="d-flex align-items-center justify-content-between gap-2 p-2 rounded" style="background:#f8f9fc; border:1px solid #e3e6f0;">
                        {{-- Left: per-page --}}
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted fw-semibold mb-0 text-nowrap" style="font-size:0.82rem;">Show</label>
                            <select name="per_page" id="per_page_en" class="form-select form-select-sm" style="width:75px;" onchange="this.form.submit()">
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
                                <a href="{{ route('admin.students.enrolled', ['per_page' => $perPage]) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive" style="min-height: 350px;">
                    <table class="table table-hover align-middle mb-0 custom-table">
                        <thead class="table-light">
                            <tr>
                                @php
                                    function enSort($col, $label, $sortBy, $sortDir, $search, $perPage) {
                                        $dir = ($sortBy === $col && $sortDir === 'asc') ? 'desc' : 'asc';
                                        $icon = $sortBy === $col ? ($sortDir === 'asc' ? '▲' : '▼') : '⇅';
                                        $url = route('admin.students.enrolled', compact('search', 'perPage') + ['sort_by' => $col, 'sort_dir' => $dir]);
                                        return "<a href=\"{$url}\" class=\"text-dark text-decoration-none\">{$label} <small>{$icon}</small></a>";
                                    }
                                @endphp
                                <th>#</th>
                                <th>{!! enSort('student_id', 'Student ID', $sortBy, $sortDir, $search, $perPage) !!}</th>
                                <th>{!! enSort('first_name', 'First Name', $sortBy, $sortDir, $search, $perPage) !!}</th>
                                <th>{!! enSort('middle_name', 'Middle Name', $sortBy, $sortDir, $search, $perPage) !!}</th>
                                <th>{!! enSort('surname', 'Last Name', $sortBy, $sortDir, $search, $perPage) !!}</th>
                                <th>Campus</th>
                                <th>{!! enSort('email', 'Email', $sortBy, $sortDir, $search, $perPage) !!}</th>
                                <th>{!! enSort('phone', 'Phone', $sortBy, $sortDir, $search, $perPage) !!}</th>
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
                                    <strong>{{ $student->first_name }}</strong>
                                    @if($student->nationality)
                                    <br><small class="text-muted">{{ $student->nationality }}</small>
                                    @endif
                                </td>
                                <td>{{ $student->middle_name ?? '-' }}</td>
                                <td>{{ $student->surname }}</td>
                                <td>
                                    @if($student->campus)
                                        <span class="badge bg-info text-dark">{{ $student->campus->name }}</span>
                                    @else
                                        -
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
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>No enrolled students found.
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
                    {{ $students->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

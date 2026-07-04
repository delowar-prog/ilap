@extends('layouts.backend_master')

@section('admin_contents')
    <div class="card mb-3">
        <div class="card-header py-2">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="mb-0 fw-semibold text-uppercase">
                        <i class="fas fa-user-tie me-2"></i>
                        Agent Management
                    </h6>
                </div>
                <div class="col-auto">
                    @can('agent add')
                        <a href="{{ route('agents.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Add Agent
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body border-bottom py-3">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control form-control-sm"
                            placeholder="Search name, email or code..." value="{{ request('search') }}">
                    </div>

                    @if (auth()->user()->hasRole('Super Admin'))
                        <div class="col-md-2">
                            <select name="campus_id" class="form-select form-select-sm">
                                <option value="">All Campus</option>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus->id }}"
                                        {{ request('campus_id') == $campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <select name="agent_type" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <option value="master" {{ request('agent_type') == 'master' ? 'selected' : '' }}>Master Agent
                            </option>
                            <option value="sub_agent" {{ request('agent_type') == 'sub_agent' ? 'selected' : '' }}>Sub-Agent
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
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

        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">ID</th>
                        <th>Agent Code</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Parent Agent</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th width="90" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($agents as $agent)
                        <tr>
                            <td class="text-center">{{ $agents->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="badge bg-dark bg-opacity-10 text-dark" style="font-size: 0.75rem;">
                                    {{ $agent->agent_code }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $agent->full_name }}</div>
                                <small class="text-muted">{{ $agent->campus->name ?? 'N/A' }}</small>
                            </td>

                            <td>
                                @if ($agent->agent_type == 'master')
                                    <span class="badge bg-primary bg-opacity-10 text-primary">Master</span>
                                @else
                                    <span class="badge bg-info bg-opacity-10 text-info">Sub-Agent</span>
                                @endif
                            </td>

                            <td>
                                {{ $agent->parentAgent?->full_name ?? 'N/A' }}
                            </td>

                            <td>{{ $agent->email }}</td>

                            <td>
                                @if ($agent->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown"
                                        style="font-size: 0.75rem; padding: 0.25rem 0.5rem;">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" style="font-size: 0.85rem;">
                                        @can('agent view')
                                            <a href="{{ route('agents.show', $agent->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-eye me-2 text-primary"></i>View
                                            </a>
                                        @endcan
                                        @can('agent edit')
                                            <a href="{{ route('agents.edit', $agent->id) }}" class="dropdown-item py-1">
                                                <i class="fas fa-edit me-2 text-warning"></i>Edit
                                            </a>
                                        @endcan
                                        @can('agent delete')
                                            <form action="{{ route('agents.destroy', $agent->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-1 text-danger"
                                                    onclick="return confirmDeleteAgent('{{ $agent->name }}', '{{ $agent->agent_code }}')">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted">No Agent Found</h6>
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
                        Showing {{ $agents->firstItem() ?? 0 }} - {{ $agents->lastItem() ?? 0 }} of
                        {{ $agents->total() }} records
                    </small>
                </div>
                <div class="col-md-6 text-end">
                    {{ $agents->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function confirmDeleteAgent(name, code) {
                return confirm(
                    `⚠️ Are you sure you want to delete this agent?\n\n` +
                    `Name: ${name}\n` +
                    `Promo Code: ${code}\n\n` +
                    `Note: This action cannot be undone. The agent must have no sub-agents, students, or commissions.`
                );
            }
        </script>
    @endpush
@endsection

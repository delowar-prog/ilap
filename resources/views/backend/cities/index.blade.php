@extends('layouts.backend_master')

@section('admin_contents')



<div class="card mb-3">
    <div class="card-header py-2">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="mb-0 fw-semibold text-uppercase">
                    <i class="fas fa-city me-2"></i> Cities Management
                </h6>
            </div>
            <div class="col-auto">
                <a href="{{ route('cities.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Add City
                </a>
            </div>
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <form method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Search city name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="country_id" id="filter_country_id" class="form-select form-select-sm">
                        <option value="">All Countries</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="state_id" id="filter_state_id" class="form-select form-select-sm">
                        <option value="">All States</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-search me-1"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
            <thead class="bg-light">
                <tr>
                    <th width="50" class="text-center">#</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City Name</th>
                    <th>City Code</th>
                    <th>Status</th>
                    <th width="100" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cities as $city)
                    <tr>
                        <td class="text-center">{{ $cities->firstItem() + $loop->index }}</td>
                        <td>{{ $city->country->name }}</td>
                        <td>{{ $city->state->name }}</td>
                        <td class="fw-semibold">{{ $city->name }}</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $city->city_code ?? 'N/A' }}</span></td>
                        <td>
                            @if($city->status == 'active')
                                <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown" style="font-size: 0.75rem;">
                                    Action
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('cities.edit', $city->id) }}" class="dropdown-item py-1">
                                        <i class="fas fa-edit me-2 text-warning"></i>Edit
                                    </a>
                                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item py-1 text-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash me-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <h6 class="text-muted">No City Found</h6>
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
                    Showing {{ $cities->firstItem() ?? 0 }} - {{ $cities->lastItem() ?? 0 }} of {{ $cities->total() }}
                </small>
            </div>
            <div class="col-md-6 text-end">
                {{ $cities->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Filter Dropdown AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const filterCountry = document.getElementById('filter_country_id');
        const filterState = document.getElementById('filter_state_id');
        const initialFilterStateId = '{{ request('state_id') }}';

        function loadFilterStates(countryId, selectedStateId = '') {
            filterState.innerHTML = '<option value="">Loading...</option>';
            if (countryId) {
                fetch(`/geo/countries/${countryId}/states`)
                    .then(res => res.json())
                    .then(data => {
                        filterState.innerHTML = '<option value="">All States</option>';
                        data.forEach(state => {
                            let selected = state.id == selectedStateId ? 'selected' : '';
                            filterState.innerHTML += `<option value="${state.id}" ${selected}>${state.name}</option>`;
                        });
                    });
            } else {
                filterState.innerHTML = '<option value="">All States</option>';
            }
        }

        filterCountry.addEventListener('change', function() {
            loadFilterStates(this.value);
        });

        if (filterCountry.value) {
            loadFilterStates(filterCountry.value, initialFilterStateId);
        }
    });
</script>
@endpush
@endsection
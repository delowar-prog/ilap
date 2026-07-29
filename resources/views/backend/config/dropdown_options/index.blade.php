@extends('layouts.backend_master')
@section('title', 'Configuration — Dropdown Options')

@section('admin_contents')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0"><i class="fas fa-sliders-h me-2"></i> Configuration</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Dropdown Options</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    @foreach($categories as $key => $name)
    <div class="col-md-6 col-xl-4 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-lift" style="transition: box-shadow 0.2s, transform 0.2s;">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                         style="width:46px;height:46px;background:linear-gradient(135deg,#667eea,#764ba2);">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-semibold">{{ $name }}</h6>
                        <small class="text-muted"><code>{{ $key }}</code></small>
                    </div>
                </div>
                <div class="mt-auto d-flex align-items-center justify-content-between">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2" style="font-size:0.85rem;">
                        {{ $counts[$key] ?? 0 }} options
                    </span>
                    <a href="{{ route('admin.config.dropdown.category', $key) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-cog me-1"></i> Manage
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    {{-- Partner Institutes Card --}}
    <div class="col-md-6 col-xl-4 mb-4">
        <div class="card h-100 border-0 shadow-sm hover-lift" style="transition: box-shadow 0.2s, transform 0.2s;">
            <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                         style="width:46px;height:46px;background:linear-gradient(135deg,#667eea,#764ba2);">
                        <i class="fas fa-university text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-semibold">Partner Institutes</h6>
                        <small class="text-muted"><code>partner_institutes</code></small>
                    </div>
                </div>
                <div class="mt-auto d-flex align-items-center justify-content-between">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2" style="font-size:0.85rem;">
                        {{ \App\Models\PartnerInstitute::count() }} options
                    </span>
                    <a href="{{ route('admin.config.partner_institutes.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-cog me-1"></i> Manage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

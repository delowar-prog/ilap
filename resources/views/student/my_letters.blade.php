@extends('layouts.app')

@section('title', 'My Letters & Documents')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-0" style="color:#1a2456;">
                        <i class="fas fa-envelope-open-text me-2 text-primary"></i> My Letters & Documents
                    </h4>
                    <p class="text-muted small mb-0 mt-1">Official letters & certificates issued to you by the institution</p>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary fs-6 px-3 py-2 rounded-pill">
                    {{ $letters->count() }} {{ Str::plural('Document', $letters->count()) }}
                </span>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($letters->isEmpty())
                <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No letters sent to you yet.</h5>
                        <p class="text-muted small">When the institution sends you a letter or certificate, it will appear here.</p>
                    </div>
                </div>
            @else
                <div class="row g-3">
                    @foreach($letters as $letter)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 hover-shadow" style="transition: box-shadow 0.2s;">
                            <div class="card-body d-flex align-items-center gap-3 py-3 px-4">
                                {{-- Icon --}}
                                <div class="flex-shrink-0">
                                    @if(isset($letter->doc_type) && $letter->doc_type === 'invoice')
                                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                                            <i class="fas fa-file-invoice-dollar text-success fa-lg"></i>
                                        </div>
                                    @elseif($letter->file_type === 'pdf')
                                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                                            <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                        </div>
                                    @else
                                        <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width:52px; height:52px;">
                                            <i class="fas fa-file-alt text-info fa-lg"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-grow-1 min-w-0">
                                    <h6 class="fw-bold mb-0 text-truncate" style="color:#1a2456;">
                                        {{ (isset($letter->doc_type) && $letter->doc_type === 'invoice') ? $letter->invoice_title : $letter->letter_title }}
                                    </h6>
                                    <div class="d-flex flex-wrap gap-3 mt-1">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                            Issued: {{ $letter->sent_at?->format('d M, Y') ?? $letter->created_at->format('d M, Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-1 text-success"></i>
                                            By: {{ $letter->generator->name ?? 'Institution' }}
                                        </small>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2" style="font-size:10px;">
                                            <i class="fas fa-check me-1"></i> Delivered
                                        </span>
                                        @if(isset($letter->doc_type) && $letter->doc_type === 'invoice')
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2" style="font-size:10px;">
                                                Invoice
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="flex-shrink-0 d-flex gap-2">
                                    @if(isset($letter->doc_type) && $letter->doc_type === 'invoice')
                                        @if($letter->file_type === 'pdf')
                                        <a href="{{ route('student.invoices.preview', $letter->id) }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Preview
                                        </a>
                                        @endif
                                        <a href="{{ route('student.invoices.download', $letter->id) }}"
                                           class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    @else
                                        @if($letter->file_type === 'pdf')
                                        <a href="{{ route('student.letters.preview', $letter->id) }}" target="_blank"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Preview
                                        </a>
                                        @endif
                                        <a href="{{ route('student.letters.download', $letter->id) }}"
                                           class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    transform: translateY(-1px);
    transition: all 0.2s ease;
}
</style>
@endsection

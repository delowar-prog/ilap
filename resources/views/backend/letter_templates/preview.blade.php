@extends('layouts.backend_master')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    /* Match Summernote editor rendering exactly */
    .preview-content-body {
        font-family: Arial, sans-serif;
        font-size: 14px;
        line-height: 1.5;
        color: #333;
    }
    .preview-content-body p {
        margin-top: 0;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    .preview-content-body ul,
    .preview-content-body ol {
        margin-bottom: 1rem;
        padding-left: 20px;
    }
    .preview-content-body table {
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .preview-content-body td,
    .preview-content-body th {
        border: 1px solid #ddd;
        padding: 4px 8px;
    }
</style>
@endpush

@section('admin_contents')

<div class="card mb-4">
    <div class="card-header py-3 bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-eye me-2"></i> Template Live Preview (Dummy Data)
        </h5>
        <div>
            <a href="{{ route('admin.letter-templates.edit', $letterTemplate->id) }}" class="btn btn-primary btn-sm rounded-pill me-2">
                <i class="fas fa-edit me-1"></i> Edit Template
            </a>
            <a href="{{ route('admin.letter-templates.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="card-body p-4 bg-secondary bg-opacity-10 d-flex flex-column align-items-center">

        @if($padImageUrl)
            {{-- Multi-page pad image preview --}}
            @foreach($pages as $pageIndex => $pageContent)
                <div class="pad-page-preview mb-4 position-relative"
                     data-pad-image="{{ $padImageUrl }}"
                     style="
                         background-image: url('{{ $padImageUrl }}');
                         background-size: 100% 100%;
                         background-repeat: no-repeat;
                         background-position: center top;
                         background-color: #ffffff;
                         width: 750px;
                         box-shadow: 0 4px 15px rgba(0,0,0,0.15);
                         border-radius: 4px;
                         box-sizing: border-box;
                         padding-top: {{ $padData['marginTop'] ?? 130 }}px;
                         padding-bottom: {{ $padData['marginBottom'] ?? 120 }}px;
                         padding-left: {{ ($padData['marginLeft'] ?? 0) > 0 ? ($padData['marginLeft']) : 55 }}px;
                         padding-right: {{ ($padData['marginRight'] ?? 0) > 0 ? ($padData['marginRight']) : 55 }}px;
                     ">

                    @if($pageIndex === 0)
                        {{-- First page: show subject heading --}}
                        @if($letterTemplate->subject)
                            <h5 class="text-center fw-bold text-dark text-uppercase mb-4" style="text-decoration: underline;">
                                {{ $letterTemplate->subject }}
                            </h5>
                        @endif
                    @endif

                    <div class="content-preview preview-content-body">
                        {!! $pageContent !!}
                    </div>

                    {{-- Signatures on last page --}}
                    @if($loop->last && isset($activeSignatures) && count($activeSignatures) > 0)
                        <div style="margin-top: 40px;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    @foreach($activeSignatures as $sig)
                                        <td style="width: {{ 100 / count($activeSignatures) }}%; text-align: center; vertical-align: bottom;">
                                            <div style="display: inline-block; text-align: center; font-family: Arial, sans-serif;">
                                                <div style="font-family: 'Courier New', Courier, monospace; font-style: italic; font-size: 13px; color: #003366; height: 35px; line-height: 35px; border: 1px dashed #ccc; padding: 0 10px; border-radius: 4px; display: inline-block; margin-bottom: 5px; background-color: #fafafa;">
                                                    /{{ $sig['name'] }}/
                                                </div>
                                                <div style="border-top: 1px solid #999; width: 140px; margin: 0 auto 3px auto;"></div>
                                                <div style="font-weight: bold; font-size: 10.5px; color: #333; line-height: 1.2;">{{ $sig['name'] }}</div>
                                                <div style="font-size: 8.5px; color: #666; line-height: 1.2;">{{ $sig['designation'] }}</div>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        </div>
                    @endif

                </div>

                {{-- Page number indicator --}}
                @if(count($pages) > 1)
                    <div class="text-muted small mb-2">Page {{ $pageIndex + 1 }} of {{ count($pages) }}</div>
                @endif
            @endforeach

        @else
            {{-- No pad — fallback static design --}}
            <div class="bg-white shadow p-5 border" style="max-width: 800px; width: 100%; min-height: 900px; font-family: Arial, sans-serif; position: relative;">

                <!-- Premium Header -->
                <div style="border-bottom: 2px solid #003366; padding-bottom: 12px; margin-bottom: 20px;">
                    <table style="width: 100%; border-collapse: collapse; margin: 0;">
                        <tr>
                            <td style="vertical-align: middle; padding: 0;">
                                <table style="border-collapse: collapse;">
                                    <tr>
                                        <td style="padding-right: 12px; vertical-align: middle;">
                                            <div style="width: 55px; height: 55px; border-radius: 50%; border: 1.5px solid #003366; text-align: center; background-color: #fff; padding: 2px; box-sizing: border-box; display: inline-block;">
                                                <div style="border: 1px dashed #b8860b; border-radius: 50%; width: 100%; height: 100%; box-sizing: border-box; padding-top: 3px; position: relative;">
                                                    <div style="font-size: 4px; color: #003366; font-weight: bold; text-transform: uppercase; line-height: 1;">LEARNING</div>
                                                    <div style="font-size: 11px; font-weight: bold; color: #b8860b; margin: 1px 0; font-family: 'Georgia', serif; line-height: 1.1;">iLAP</div>
                                                    <div style="font-size: 4px; color: #003366; font-weight: bold; text-transform: uppercase; line-height: 1;">PROVIDER</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle; line-height: 1.1;">
                                            <span style="font-size: 30px; font-weight: 800; color: #003366; font-family: Arial, sans-serif; letter-spacing: -1px;">iLAP</span>
                                            <span style="font-size: 8px; font-weight: bold; color: #555; text-transform: uppercase; vertical-align: super; margin-left: 3px;">International<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Learning Access<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Provider</span>
                                            <div style="width: 155px; height: 1px; background-color: #b8860b; margin: 3px 0 2px 0;"></div>
                                            <div style="font-size: 8px; font-weight: bold; color: #003366; text-transform: uppercase; letter-spacing: 0.5px;">Global Education Group</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="text-align: right; vertical-align: middle; padding: 0; font-size: 10px; line-height: 1.3; color: #333; font-family: Arial, sans-serif;">
                                <strong style="color: #003366; font-size: 11px;">167-169 Great Portland Street</strong><br>
                                London W1W 5PF<br>
                                <span style="color: #003366; font-weight: bold;">United Kingdom</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="d-flex justify-content-between mb-4 text-muted small">
                    <div>
                        <strong>Date:</strong> {{ date('d M, Y') }}<br>
                        <strong>Ref No:</strong> ILAP/PREVIEW/SAMPLE
                    </div>
                    <div class="text-end">
                        <strong>Student ID:</strong> STU-2026-001
                    </div>
                </div>

                @if($letterTemplate->subject)
                    <h5 class="text-center fw-bold text-dark text-uppercase mb-4" style="text-decoration: underline;">
                        {{ $letterTemplate->subject }}
                    </h5>
                @endif

                <div class="content-preview mb-5" style="line-height: 1.8; color: #333;">
                    {!! $content !!}
                </div>

                <!-- Mockup Signatures at bottom of preview page (above footer) -->
                @if(isset($activeSignatures) && count($activeSignatures) > 0)
                    <div style="position: absolute; bottom: 130px; left: 40px; right: 40px; z-index: 50;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                @foreach($activeSignatures as $sig)
                                    <td style="width: {{ 100 / count($activeSignatures) }}%; text-align: center; vertical-align: bottom;">
                                        <div style="display: inline-block; text-align: center; font-family: Arial, sans-serif;">
                                            <div style="font-family: 'Courier New', Courier, monospace; font-style: italic; font-size: 13px; color: #003366; height: 35px; line-height: 35px; border: 1px dashed #ccc; padding: 0 10px; border-radius: 4px; display: inline-block; margin-bottom: 5px; background-color: #fafafa;">
                                                /{{ $sig['name'] }}/
                                            </div>
                                            <div style="border-top: 1px solid #999; width: 140px; margin: 0 auto 3px auto;"></div>
                                            <div style="font-weight: bold; font-size: 10.5px; color: #333; line-height: 1.2;">{{ $sig['name'] }}</div>
                                            <div style="font-size: 8.5px; color: #666; line-height: 1.2;">{{ $sig['designation'] }}</div>
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                @endif

                <!-- Premium Footer -->
                <div style="position: absolute; bottom: 30px; left: 40px; right: 40px; border-top: 1px solid #e0e0e0; padding-top: 10px;">
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                        <tr>
                            <td style="font-size: 7.5px; color: #444; line-height: 1.1; vertical-align: middle;">
                                <span style="font-weight: bold; color: #c22026; text-transform: uppercase;">Cambridge English</span> School &nbsp;|&nbsp;
                                <span style="font-weight: bold; color: #1e306e; text-transform: uppercase;">Graduate College</span> &nbsp;|&nbsp;
                                <span style="font-weight: bold; color: #0f1c3f;">UKQAS</span> &nbsp;|&nbsp;
                                <span style="font-weight: bold; color: #d9534f; text-transform: uppercase;">VAS</span> Visa
                            </td>
                            <td style="text-align: right; font-size: 7.5px; font-weight: bold; color: #003366; vertical-align: middle;">
                                UKRLP Register
                            </td>
                        </tr>
                    </table>
                    <div style="font-size: 5.5px; color: #777; line-height: 1.3; text-align: center; margin-bottom: 8px;">
                        Australia, Bahrain, Bangladesh, Brazil, Canada, China, Cyprus, Egypt, India, Malaysia, UAE, UK, USA, Vietnam.
                    </div>
                    <div style="background-color: #003366; color: #ffffff; padding: 6px 12px; font-size: 7.5px; border-radius: 4px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="color: #ffffff;">
                                    <strong>iLAP Group Limited</strong> (Company No. 12405171)
                                </td>
                                <td style="text-align: right; color: #ffffff;">
                                    Phone: +44 208 133 8086 | Email: info@ilap.org.uk | Web: www.ilap.org.uk
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pages = document.querySelectorAll('.pad-page-preview');
    if (!pages.length) return;

    const padImageUrl = pages[0].getAttribute('data-pad-image');
    if (!padImageUrl) return;

    const img = new Image();
    img.onload = function () {
        pages.forEach(function (page) {
            const containerWidth = 750;
            const fixedHeight = Math.round(containerWidth * (img.naturalHeight / img.naturalWidth));
            page.style.minHeight = fixedHeight + 'px';
        });
    };
    img.src = padImageUrl;
});
</script>
@endpush

@endsection

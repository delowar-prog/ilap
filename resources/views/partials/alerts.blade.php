{{-- resources/views/partials/alerts.blade.php --}}

{{-- Session Flash Messages (Normal Request) --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" 
         role="alert" id="session-alert">
        <i class="fas fa-check-circle me-2"></i>
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-danger border-4" 
         role="alert">
        <i class="fas fa-times-circle me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-start border-warning border-4" 
         role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Warning!</strong> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show shadow-sm border-start border-info border-4" 
         role="alert">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Info!</strong> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-start border-danger border-4" 
         role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Livewire Dynamic Alerts (Toast Style - Fixed Position) --}}
<div id="livewire-alert-container" 
     class="position-fixed top-0 end-0 p-3" 
     style="z-index: 9999; max-width: 400px;">
</div>

@push('scripts')
<script>
    // Auto-dismiss after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('session-alert');
        if (alert) {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        }
    });

    // Livewire Alert Listener (Livewire v4)
    window.addEventListener('show-alert', event => {
        const { type, message } = event.detail;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const colors = {
            success: 'success',
            error: 'danger',
            warning: 'warning',
            info: 'info'
        };

        const alertHtml = `
            <div class="alert alert-${colors[type] || 'info'} alert-dismissible fade show shadow border-start border-${colors[type] || 'info'} border-4" 
                 role="alert">
                <i class="fas ${icons[type] || icons.info} me-2"></i>
                <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        const container = document.getElementById('livewire-alert-container');
        container.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alertEl = container.querySelector('.alert');
            if (alertEl) {
                const bsAlert = new bootstrap.Alert(alertEl);
                bsAlert.close();
            }
        }, 5000);
    });
</script>
@endpush
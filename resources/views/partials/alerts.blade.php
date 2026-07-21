{{-- resources/views/partials/alerts.blade.php --}}

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<!-- Toastr JS & SweetAlert2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Premium Toastr Styling */
    #toast-container > div {
        opacity: 0.95 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        border-radius: 8px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 0.85rem !important;
    }
    .toast-success { background-color: #10b981 !important; }
    .toast-error { background-color: #ef4444 !important; }
    .toast-warning { background-color: #f59e0b !important; }
    .toast-info { background-color: #3b82f6 !important; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Toastr configuration & trigger
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "2000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if (session('success'))
                toastr.success("{!! addslashes(session('success')) !!}");
            @endif

            @if (session('error'))
                toastr.error("{!! addslashes(session('error')) !!}");
            @endif

            @if (session('warning'))
                toastr.warning("{!! addslashes(session('warning')) !!}");
            @endif

            @if (session('info'))
                toastr.info("{!! addslashes(session('info')) !!}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{!! addslashes($error) !!}");
                @endforeach
            @endif
        }

        // 2. Global SweetAlert Confirm Interceptor (Pure Vanilla JS for maximum safety)
        function initSweetAlertConfirms() {
            const confirmElements = document.querySelectorAll('[onclick*="confirm"]');
            confirmElements.forEach(element => {
                if (element.getAttribute('data-swal-initialized')) return;
                
                const originalOnClick = element.getAttribute('onclick');
                if (!originalOnClick) return;

                let message = 'Are you sure you want to perform this action?';
                
                // Extract message
                let match = originalOnClick.match(/confirm\(['"](.*?)['"]\)/);
                if (match) {
                    message = match[1];
                } else {
                    const originalConfirm = window.confirm;
                    window.confirm = function(msg) {
                        message = msg;
                        return false;
                    };
                    try {
                        new Function(originalOnClick).call(element);
                    } catch(err) {}
                    window.confirm = originalConfirm;
                }

                // Remove onclick permanently to prevent native dialog
                element.removeAttribute('onclick');
                element.setAttribute('data-swal-initialized', 'true');

                // Bind click event
                element.addEventListener('click', function(e) {
                    // If already confirmed by Swal, let the click proceed to trigger submit/navigation
                    if (element.getAttribute('data-swal-confirmed') === 'true') {
                        element.removeAttribute('data-swal-confirmed');
                        return;
                    }
                    
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const isDelete = message.toLowerCase().includes('delete') || 
                                     element.classList.contains('text-danger') || 
                                     originalOnClick.toLowerCase().includes('delete') || 
                                     originalOnClick.toLowerCase().includes('destroy');

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: isDelete ? 'Are you sure?' : 'Confirmation Required',
                            text: message.replace(/\\n/g, '\n'),
                            icon: isDelete ? 'warning' : 'question',
                            showCancelButton: true,
                            confirmButtonColor: isDelete ? '#ef4444' : '#4f46e5',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: isDelete ? 'Yes, Delete it!' : 'Yes, Proceed!',
                            cancelButtonText: 'Cancel',
                            heightAuto: false,
                            customClass: {
                                popup: 'rounded-4 shadow',
                                confirmButton: 'px-4 py-2 fw-semibold btn shadow-none',
                                cancelButton: 'px-4 py-2 fw-semibold btn shadow-none'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                element.setAttribute('data-swal-confirmed', 'true');
                                element.click(); // Trigger native click event
                            }
                        });
                    } else {
                        // Fallback to native confirm if Swal not loaded
                        if (confirm(message)) {
                            element.setAttribute('data-swal-confirmed', 'true');
                            element.click();
                        }
                    }
                });
            });
        }

        // Run initially
        initSweetAlertConfirms();

        // Observe changes to document body for dynamically added elements (Livewire, Ajax)
        if (typeof MutationObserver !== 'undefined') {
            const observer = new MutationObserver(function() {
                initSweetAlertConfirms();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        }
    });

    // Livewire Alerts integration (for dynamic actions)
    window.addEventListener('show-alert', event => {
        const { type, message } = event.detail;
        if (type === 'success') toastr.success(message);
        else if (type === 'error') toastr.error(message);
        else if (type === 'warning') toastr.warning(message);
        else toastr.info(message);
    });
</script>
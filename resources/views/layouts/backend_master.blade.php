<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Universitas Law Chambers </title>

    @stack('head_scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @includeIf('backend/admin_component/css/style')
    @livewireStyles
    @stack('css')
</head>

<body>
    @impersonating
        <div
            style="background: red; color: white; text-align: center; padding: 10px; position: fixed; top: 0; width: 100%; z-index: 9999;">
            ⚠️ You are currently viewing <strong>{{ auth()->user()->name }}</strong> account.

            {{-- POST রিকোয়েস্ট পাঠানোর জন্য ছোট ফর্ম --}}
            <form action="{{ route('impersonate.leave.custom') }}" method="POST" style="display: inline; margin-left: 10px;">
                @csrf
                {{-- বাটনটিকে CSS দিয়ে সাধারণ লিংকের মতো স্টাইল করা হয়েছে --}}
                <button type="submit"
                    style="
                background: none; 
                border: none; 
                color: yellow; 
                font-weight: bold; 
                text-decoration: underline; 
                cursor: pointer; 
                font-size: inherit; 
                padding: 0;
            ">
                    (Leave)
                </button>
            </form>
        </div>

        {{-- ব্যানারের কারণে মূল কন্টেন্ট যেন ঢাকা না পড়ে --}}
        <div style="margin-top: 50px;"></div>
    @endImpersonating
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">


            <!-- navbar deafult end here  -->
            {{-- navbar 5 --}}
            @includeIf('backend/admin_component/navbar0_dubble_top')
            @includeIf('backend/admin_component/navbar1_verticale')
            @includeIf('backend/admin_component/navbar2_top')

            <div class="content">

                @includeIf('backend/admin_component/navbar3_top_single_header')
                @includeIf('backend/admin_component/navbar4_combo')


                <!-- ===============================================-->
                <!--    End of Main Content-->
                <!-- ===============================================-->


                @yield('admin_contents')


                <!-- ===============================================-->
                <!--    End of Main Content-->
                <!-- ===============================================-->
                @includeIf('backend/admin_component/footer')
            </div>

        </div>
    </main>

    @includeIf('backend/admin_component/offcanvas_customize')
    @includeIf('backend/admin_component/js/script')
    {{-- 🎯 সেন্ট্রাল মেসেজ এরিয়া --}}
    @include('partials.alerts')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#description',
                    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                    height: 400,
                    license_key: 'gpl',
                });
            } else {
                console.error("TinyMCE not loaded — check file path!");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Apply "Other" dynamic field logic to any select
            function handleOtherSelect(selectElement) {
                let select = $(selectElement);
                let name = select.attr('name');
                if (!name) return;

                // Skip select elements that have custom logic or are ignored
                if (select.attr('id') === 'highest_qualification_select' || 
                    select.attr('name')?.includes('result_type') || 
                    select.data('custom-other-handled') === true) {
                    return;
                }

                let selectedOption = select.find('option:selected');
                let selectedText = selectedOption.text().trim().toLowerCase();
                let selectedValue = selectedOption.val().trim().toLowerCase();

                // Check if "other" is selected
                let isOtherSelected = (
                    selectedValue === 'other' || 
                    selectedValue === 'others' || 
                    selectedText === 'other' || 
                    selectedText === 'others' ||
                    selectedText.startsWith('other ')
                );

                let container = select.next('.dynamic-other-container');

                if (isOtherSelected) {
                    if (container.length === 0) {
                        container = $('<div class="dynamic-other-container mt-2"></div>');
                        let label = $('<label class="form-label font-12 text-muted mb-1">Please specify <span class="text-danger">*</span></label>');
                        let input = $('<input type="text" class="form-control" placeholder="Please specify details..." />');
                        
                        if (select.attr('required')) {
                            input.attr('required', 'required');
                        }
                        
                        container.append(label).append(input);
                        select.after(container);

                        // Update select option value on typing
                        input.on('input', function() {
                            let val = $(this).val().trim();
                            if (!selectedOption.data('original-value')) {
                                selectedOption.data('original-value', selectedOption.val());
                            }
                            if (val !== '') {
                                selectedOption.val(val);
                            } else {
                                selectedOption.val(selectedOption.data('original-value'));
                            }
                        });
                    }
                    container.show();
                    let input = container.find('input');
                    if (select.attr('required')) {
                        input.attr('required', 'required');
                    }
                } else {
                    if (container.length > 0) {
                        container.hide();
                        let input = container.find('input');
                        input.removeAttr('required');
                        input.val('');

                        // Restore original value for any modified option
                        select.find('option').each(function() {
                            let opt = $(this);
                            if (opt.data('original-value')) {
                                opt.val(opt.data('original-value'));
                                opt.removeData('original-value');
                            }
                        });
                    }
                }
            }

            // Attach listener
            $(document).on('change', 'select', function() {
                handleOtherSelect(this);
            });

            // Run on page load for all select elements
            $('select').each(function() {
                let select = $(this);
                let name = select.attr('name');
                if (!name) return;

                // Skip ignored select elements
                if (select.attr('id') === 'highest_qualification_select' || 
                    select.attr('name')?.includes('result_type')) {
                    return;
                }

                let currentValue = select.attr('data-current-value') || '';
                currentValue = currentValue.trim();

                if (currentValue === '') return;

                // Check if any option has exactly this value
                let hasExactOption = false;
                select.find('option').each(function() {
                    if ($(this).val() === currentValue) {
                        hasExactOption = true;
                    }
                });

                let otherOption = select.find('option').filter(function() {
                    let val = $(this).val().toLowerCase();
                    let text = $(this).text().toLowerCase();
                    return val === 'other' || val === 'others' || text === 'other' || text === 'others';
                });

                if (!hasExactOption && otherOption.length > 0) {
                    // It is a custom "Other" value
                    otherOption.val(currentValue);
                    otherOption.prop('selected', true);
                    handleOtherSelect(select[0]);
                    
                    let container = select.next('.dynamic-other-container');
                    if (container.length > 0) {
                        container.find('input').val(currentValue);
                    }
                } else if (hasExactOption) {
                    // If the selected value is literally "other" or "others"
                    if (currentValue.toLowerCase() === 'other' || currentValue.toLowerCase() === 'others') {
                        otherOption.prop('selected', true);
                        handleOtherSelect(select[0]);
                    }
                }
            });

            // Automatically set placeholder inside select2 search inputs when opened
            $(document).on('select2:open', function(e) {
                const target = $(e.target);
                const isTagging = target.hasClass('select2-location-select') || target.hasClass('select2-tags');
                const placeholder = isTagging ? 'If not found, write here...' : 'Search...';
                setTimeout(function() {
                    const searchField = document.querySelector('.select2-search__field');
                    if (searchField) {
                        searchField.placeholder = placeholder;
                    }
                }, 10);
            });
        });
    </script>
    @include('components.signature_pad_modal')
    @livewireScripts
    @stack('scripts')
</body>

</html>

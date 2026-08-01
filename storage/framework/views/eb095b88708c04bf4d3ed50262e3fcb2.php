<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Universitas Law Chambers </title>

    <?php echo $__env->yieldPushContent('head_scripts'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.12.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <?php if ($__env->exists('backend/admin_component/css/style')) echo $__env->make('backend/admin_component/css/style', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo $__env->yieldPushContent('css'); ?>
</head>

<body>
    <?php if (is_impersonating()) : ?>
        <div
            style="background: red; color: white; text-align: center; padding: 10px; position: fixed; top: 0; width: 100%; z-index: 9999;">
            ⚠️ You are currently viewing <strong><?php echo e(auth()->user()->name); ?></strong> account.

            
            <form action="<?php echo e(route('impersonate.leave.custom')); ?>" method="POST" style="display: inline; margin-left: 10px;">
                <?php echo csrf_field(); ?>
                
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

        
        <div style="margin-top: 50px;"></div>
    <?php endif; ?>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    <main class="main" id="top">
        <div class="container-fluid" data-layout="container">


            <!-- navbar deafult end here  -->
            
            <?php if ($__env->exists('backend/admin_component/navbar0_dubble_top')) echo $__env->make('backend/admin_component/navbar0_dubble_top', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if ($__env->exists('backend/admin_component/navbar1_verticale')) echo $__env->make('backend/admin_component/navbar1_verticale', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if ($__env->exists('backend/admin_component/navbar2_top')) echo $__env->make('backend/admin_component/navbar2_top', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="content">

                <?php if ($__env->exists('backend/admin_component/navbar3_top_single_header')) echo $__env->make('backend/admin_component/navbar3_top_single_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if ($__env->exists('backend/admin_component/navbar4_combo')) echo $__env->make('backend/admin_component/navbar4_combo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                <!-- ===============================================-->
                <!--    End of Main Content-->
                <!-- ===============================================-->


                <?php echo $__env->yieldContent('admin_contents'); ?>


                <!-- ===============================================-->
                <!--    End of Main Content-->
                <!-- ===============================================-->
                <?php if ($__env->exists('backend/admin_component/footer')) echo $__env->make('backend/admin_component/footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

        </div>
    </main>

    <?php if ($__env->exists('backend/admin_component/offcanvas_customize')) echo $__env->make('backend/admin_component/offcanvas_customize', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if ($__env->exists('backend/admin_component/js/script')) echo $__env->make('backend/admin_component/js/script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


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
    <?php echo $__env->make('components.signature_pad_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\iLap\resources\views\layouts\backend_master.blade.php ENDPATH**/ ?>
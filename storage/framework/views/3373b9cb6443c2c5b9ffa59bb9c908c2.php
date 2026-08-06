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

    <?php echo $__env->yieldPushContent('scripts'); ?>
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

                
                <?php echo $__env->make('partials.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
     <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

     <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\ilap\resources\views/layouts/backend_master.blade.php ENDPATH**/ ?>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    

    <meta name="theme-color" content="#ffffff">
    <script src="<?php echo e(asset('contents/backend/assets')); ?>/assets/js/config.js"></script>
    <script src="<?php echo e(asset('contents/backend/assets')); ?>/vendors/simplebar/simplebar.min.js"></script>
    <script src="<?php echo e(asset('contents/backend/assets')); ?>/assets/js/tinymce.min.js"></script>
    <!-- Dropzone CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('contents/backend/assets')); ?>/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('contents/backend/assets')); ?>/assets/css/theme-rtl.min.css" rel="stylesheet" id="style-rtl">
    <link href="<?php echo e(asset('contents/backend/assets')); ?>/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    <link href="<?php echo e(asset('contents/backend/assets')); ?>/assets/css/user-rtl.min.css" rel="stylesheet" id="user-style-rtl">
    <link href="<?php echo e(asset('contents/backend/assets')); ?>/assets/css/user.min.css" rel="stylesheet" id="user-style-default">
    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script><?php /**PATH C:\laragon\www\iLap\resources\views\backend\admin_component\css\style.blade.php ENDPATH**/ ?>
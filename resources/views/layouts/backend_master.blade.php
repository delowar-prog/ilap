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

    @stack('scripts')
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

                {{-- 🎯 সেন্ট্রাল মেসেজ এরিয়া --}}
                @include('partials.alerts')
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
     @livewireScripts
     @stack('scripts')
</body>

</html>

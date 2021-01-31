<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title> Dashboard | @yield('title','Inventory Management')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('ui/backend/dist')}}/assets/images/favicon.ico">

        <!-- App css -->
        <link href="{{ asset('ui/backend/dist')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('ui/backend/dist')}}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('ui/backend/dist')}}/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('ui/backend/src/js/pages/global-css/customthemecolor-global.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/plugins/data-table/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/plugins/data-table/data-table-custom.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/dist/assets/libs/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/src/js/pages/global-css/select2-global.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/plugins/swal-sweet-alert/sweetalert.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/dist/assets/libs/jquery-toast/jquery.toast.min.css') }}">
        <link rel="stylesheet" href="{{ asset('ui/backend/src/print-css/print.css') }}">

        @stack('css')
    </head>
    <body class="sidebar-enable" data-keep-enlarged="">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            @include('backend.layouts.partials.header')


            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            @include('backend.layouts.partials.leftsidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">
                    @yield('content')
                </div> <!-- content -->

                <!-- Footer Start -->
                @include('backend.layouts.partials.footer')
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        @include('backend.layouts.partials.right-sidebar')
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        
        <script src="{{ asset('ui/backend/dist')}}/assets/js/pages/jquery.min.js"></script>
        <script src="{{ asset('ui/backend/dist')}}/assets/js/vendor.min.js"></script>


        <script src="{{ asset('ui/backend/dist')}}/assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="{{ asset('ui/backend/dist')}}/assets/libs/peity/jquery.peity.min.js"></script>

        <!-- Sparkline charts -->
        <script src="{{ asset('ui/backend/dist')}}/assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- init js -->
        <script src="{{ asset('ui/backend/dist')}}/assets/js/pages/dashboard-1.init.js"></script>

        <!-- App js -->
        <script src="{{ asset('ui/backend/dist')}}/assets/js/app.min.js"></script>
        <script src="{{ asset('ui/backend/config.js')}}"></script>
        <script>
            // $('button.button-menu-mobile').trigger('click');
        </script>
        <script src="{{ asset('ui/backend/plugins/data-table/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('ui/backend/plugins/data-table/sum().js') }}"></script>
        <script src="{{ asset('ui/backend/dist/assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ asset('ui/backend/plugins/swal-sweet-alert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('ui/backend/dist/assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
        <script src="{{ asset('ui/backend/src/js/pages/global-js/init-global-toast.js') }}"></script>
        <script src="{{ asset('ui/backend/src/js/pages/global-js/global-common.js') }}"></script>
        
        @stack('js')        
    </body>
</html>
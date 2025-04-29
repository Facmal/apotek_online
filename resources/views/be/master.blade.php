<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $title }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('be/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('be/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('be/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('be/vendors/jquery-bar-rating/css-stars.css')}}" />
    <link rel="stylesheet" href="{{asset('be/vendors/font-awesome/css/font-awesome.min.css')}}" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{asset('be/css/demo_1/style.css')}}" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{asset('be/images/favicon.png')}}" />
</head>

<body id="body">
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @yield('sidebar')
        <!-- partial -->
        <div class="main-panel">
            @yield('navbar')
            @yield('content')
            @yield('footer')

        </div>

        <!-- main-panel ends -->
    </div>
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
        </div>

        <div>
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block"> Distributed By: <a href="https://themewagon.com/" target="_blank">Themewagon</a></span>
        </div>
    </footer>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{asset('be/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('be/vendors/jquery-bar-rating/jquery.barrating.min.js')}}"></script>
    <script src="{{asset('be/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('be/vendors/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('be/vendors/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('be/vendors/flot/jquery.flot.categories.js')}}"></script>
    <script src="{{asset('be/vendors/flot/jquery.flot.fillbetween.js')}}"></script>
    <script src="{{asset('be/vendors/flot/jquery.flot.stack.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('be/js/off-canvas.js')}}"></script>
    <script src="{{asset('be/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('be/js/misc.js')}}"></script>
    <script src="{{asset('be/js/settings.js')}}"></script>
    <script src="{{asset('be/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('be/js/dashboard.js')}}"></script>
    <!-- End custom js for this page -->
    <script src="{{asset('be/vendors/select2/select2.min.js')}}"></script>
    <script src="{{asset('be/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset('be/js/file-upload.js')}}"></script>
    <script src="{{asset('be/js/typeahead.js')}}"></script>
    <script src="{{asset('be/js/select2.js')}}"></script>

    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
</body>

</html>
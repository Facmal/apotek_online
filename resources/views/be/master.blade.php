<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $title }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="be/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="be/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="be/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="be/vendors/jquery-bar-rating/css-stars.css" />
    <link rel="stylesheet" href="be/vendors/font-awesome/css/font-awesome.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="be/css/demo_1/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="be/images/favicon.png" />
</head>

<body>
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
    <script src="be/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="be/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="be/vendors/chart.js/Chart.min.js"></script>
    <script src="be/vendors/flot/jquery.flot.js"></script>
    <script src="be/vendors/flot/jquery.flot.resize.js"></script>
    <script src="be/vendors/flot/jquery.flot.categories.js"></script>
    <script src="be/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="be/vendors/flot/jquery.flot.stack.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="be/js/off-canvas.js"></script>
    <script src="be/js/hoverable-collapse.js"></script>
    <script src="be/js/misc.js"></script>
    <script src="be/js/settings.js"></script>
    <script src="be/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="be/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>

</html>
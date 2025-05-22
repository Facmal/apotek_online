<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="{{asset('fe/fonts/icomoon/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="{{asset('fe/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fe/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('fe/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('fe/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('fe/css/owl.theme.default.min.css')}}">


    <link rel="stylesheet" href="{{asset('fe/css/aos.css')}}">

    <link rel="stylesheet" href="{{asset('fe/css/style.css')}}">

</head>

<body id="body">

    <div class="site-wrap">
        @yield('navbar')
        @yield('content')
        @yield('footer')
    </div>

    <script src="{{asset('fe/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('fe/js/jquery-ui.js')}}"></script>
    <script src="{{asset('fe/js/popper.min.js')}}"></script>
    <script src="{{asset('fe/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('fe/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('fe/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('fe/js/aos.js')}}"></script>

    <script src="{{asset('fe/js/main.js')}}"></script>
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">

</body>

</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Joyaria - Fronte</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('front/assets/fonts/font-awesome/css/font-awesome.min.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('front/assets/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/select2.css')}}">

    

        <script src="{{ asset('assets/js/modernizr.custom.js')}}"></script>


        <!-- Fonts -->
        
     
    </head>
    <body class="ct-headroom--scrollUpBoth cssAnimate">
        <div id="app">
            <router-view></router-view>
        </div>
        
        <script src="{{ asset('/js/app.js') }}"></script>
    </body>
    
    <script src="{{ asset('front/assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery-ui/jquery-ui.js')}}"></script>

    <script src="{{ asset('front/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/jquery.placeholder.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/jquery.easing.1.3.js')}}"></script>
    <script src="{{ asset('front/assets/js/device.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/jquery.browser.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/snap.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/jquery.appear.js')}}"></script>

    <script src="{{ asset('front/assets/plugins/headroom/headroom.js')}}"></script>
    <script src="{{ asset('front/assets/plugins/headroom/jQuery.headroom.js')}}"></script>
    <script src="{{ asset('front/assets/plugins/headroom/init.js')}}"></script>

    <script src="{{ asset('front/assets/form/js/contact-form.js')}}"></script>

    <script src="{{ asset('front/assets/js/select2/select2.min.js')}}"></script>
    <script src="{{ asset('front/assets/js/stacktable/stacktable.js')}}"></script>


    <script src="{{ asset('front/assets/plugins/owl/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('front/assets/plugins/owl/init.js')}}"></script>

    <script src="{{ asset('front/assets/js/elevate-zoom/jquery.elevatezoom.js')}}"></script>
    <script src="{{ asset('front/assets/js/elevate-zoom/init.js')}}"></script>

    <script src="{{ asset('front/assets/js/main.js')}}"></script>

</html>

@php
    $styleToken = 'frontend/assets/css/styles'. (app()->getLocale() == "ar" ? '-rtl' : '') .'.css';
    $customToken = 'frontend/assets/css/custom'. (app()->getLocale() == "ar" ? '-rtl' : '') .'.css';

    $styleTokenM = substr(md5(filemtime($styleToken)), 0, 6);
    $customTokenM = substr(md5(filemtime($customToken)), 0, 6);
@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="_token" content="{{ csrf_token() }}" />
    {{-- <title>Analytics Dashboard - This is an example dashboard created using build-in elements and components.</title> --}}
    <title>CABES | {{ $data['title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="icon" href="{{ asset('frontend/images/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital@1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tammudu+2&display=swap" rel="stylesheet">

    @if (app()->getLocale() == "ar")
        {{-- Naskh font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@500&display=swap" rel="stylesheet">

        {{-- Tajawal font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">

        {{-- Cairo font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    @endif


    {{-- Styles --}}

    {!! Html::style('frontend/assets/css/plugins/bootstrap.min.css') !!}
    {!! Html::style('frontend/assets/css/plugins/iconfont.css') !!}
    {!! Html::style('frontend/flaticon/font/flaticon.css') !!}
    {!! Html::style('node_modules/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! Html::style('node_modules/fortawesome/fontawesome-free/css/all.css') !!}
    {{-- {!! Html::style('node_modules/fortawesome/fontawesome-free/css/all.css') !!} --}}
    {!! Html::style('node_modules/noty/lib/noty.css') !!}
    {!! Html::style('node_modules/noty/lib/themes/sunset.css') !!}
    {!! Html::style('node_modules/flag-icon-css/css/flag-icon.min.css') !!}


    {!! Html::style('frontend/assets/css/colors.css') !!}

    <link rel="stylesheet" type="text/css" href="{{ asset($styleToken.'?v='.$styleTokenM) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($customToken.'?v='.$customToken) }}">

    <style>
        .uc {
            text-transform: uppercase
        }
        a.disabled, button.disabled, .btn.disabled {
            pointer-events: unset !important;
            cursor: not-allowed;
        }
    </style>

    @yield('styles')

</head>
<body class="purple-skin" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : '' }}">

    {{-- Preloader --}}
    <div id="preloader"><div class="preloader"><span></span><span></span></div></div>

    <div id="main-wrapper" style="min-height: 300px">
        @include('frontend.layouts.header')

        @yield('content')

        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
    </div>
    @include('frontend.layouts.footer')
    {{-- Scripts --}}

    {!! Html::script('frontend/assets/js/jquery.min.js') !!}
    {!! Html::script('frontend/assets/js/popper.min.js') !!}
    {!! Html::script('frontend/assets/js/bootstrap.min.js') !!}
    {!! Html::script('frontend/assets/js/select2.min.js') !!}
    {!! Html::script('frontend/assets/js/slick.js') !!}
    {!! Html::script('frontend/assets/js/jquery.counterup.min.js') !!}
    {!! Html::script('frontend/assets/js/counterup.min.js') !!}
    {!! Html::script('node_modules/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
    {!! Html::script('frontend/assets/js/custom.js') !!}

    {!! Html::script('node_modules/noty/lib/noty.min.js') !!}

     <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('.lang-select').selectpicker({
                'width': '70px'
            });

            $('.daira-select').selectpicker({
                'dropupAuto': false
            });

            $('button[type="submit"]').on('click', function(e) {
                if ($('form').valid()) {
                    $('button[type="submit"]').attr('disabled', true);
                    $('form').submit();
                }
            });

            $(window).on('resize', function() {
                if ($(window).width() <= 1069) {

                }
            });
        });
    </script>

    <script>
        function openNav() {
            document.getElementById("filter-sidebar").style.width = "320px";
        }

        function closeNav() {
            document.getElementById("filter-sidebar").style.width = "0";
        }
    </script>

    @yield('scripts')

</body>
</html>

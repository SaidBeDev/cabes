<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>Analytics Dashboard - This is an example dashboard created using build-in elements and components.</title> --}}
    <title>CABAS | {{ $data['title'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="msapplication-tap-highlight" content="no">

    {{-- Styles --}}

    {!! Html::style('backend/css/custom.css') !!}
    {!! Html::style('node_modules/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('backend/css/main.css') !!}
    {!! Html::style('node_modules/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! Html::style('node_modules/noty/lib/noty.css') !!}
    {!! Html::style('node_modules/noty/lib/themes/sunset.css') !!}
    {!! Html::style('node_modules/font-awesome/css/font-awesome.min.css') !!}


    <style>
        .bg-asteroid {
            background-image: linear-gradient(to right, #104a42, #20666d, #46ccbf) !important;
        }
    </style>
    @yield('styles')

</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        {{-- @include('backend.layouts.settings') --}}
        @include('backend.layouts.header')

        <div class="app-main">
            @include('backend.layouts.aside')
            <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div style="margin-right: 15px">
                                    <img src="{{ asset('backend/assets/images/gattaz.jpg') }}" alt="" width="90">
                                </div>
                                <div>Yvon Gattaz
                                    <div class="page-title-subheading" style="font-size: 18px; font-weight: 600"><b style="font-weight: bolder;font-size: 25px">???</b> Pour la succession des entreprises familiales, les patrons se partagent en deux cat??gories : ceux qui croient que le g??nie est h??r??ditaire et ceux qui n'ont pas d'enfants.<b style="font-weight: bolder;font-size: 25px">???</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Main content --}}
                    @yield('content')

                    {{-- @include('backend.layouts.footer') --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}

    {!! Html::script('node_modules/jquery/dist/jquery.min.js') !!}
    {!! Html::script('node_modules/bootstrap/dist/js/bootstrap.min.js') !!}
    {!! Html::script('backend/assets/scripts/main.js') !!}
    {!! Html::script('node_modules/bootstrap-select/dist/js/bootstrap-select.min.js') !!}
    {!! Html::script('node_modules/noty/lib/noty.min.js') !!}

    {{--
    {!! Html::script('vendor/jsvalidation/js/jsvalidation.min.js') !!} --}}

    {{-- Text editor library --}}
    <script src="https://cdn.tiny.cloud/1/x05d0l9mc1ak7aihiecw6buqnn1sd7t29fo3c9ejmy9s67a7/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
       });
    </script>

    <script>
        $(document).ready(function() {
            $('.daira-select').selectpicker({
                'dropupAuto': false
            })
        });
    </script>

    @yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    {!! Html::style('frontend/assets/css/plugins/bootstrap.min.css') !!}
    {!! Html::style('frontend/assets/css/styles' . (app()->getLocale() == 'ar' ? '-rtl' : '') . '.css') !!}
    {!! Html::style('frontend/assets/css/custom' . (app()->getLocale() == 'ar' ? '-rtl' : '') . '.css') !!}
    <style>
        .header {
            position: relative;
            text-align: center;
            background: linear-gradient(60deg, rgba(84, 58, 183, 1) 0%, rgba(0, 172, 193, 1) 100%);
            color: white;
        }

        .logo {
            width: 50px;
            fill: white;
            padding-right: 15px;
            display: inline-block;
            vertical-align: middle;
        }

        .inner-header {
            height: 65vh;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .flex {
            /*Flexbox for containers*/
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .waves {
            position: relative;
            width: 100%;
            height: 15vh;
            margin-bottom: -7px;
            /*Fix for safari gap*/
            min-height: 100px;
            max-height: 150px;
        }

        .content {
            position: relative;
            height: 20vh;
            text-align: center;
            background-color: white;
        }

        /* Animation */

        .parallax>use {
            animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
        }

        .parallax>use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }

        .parallax>use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }

        .parallax>use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }

        .parallax>use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }

        @keyframes move-forever {
            0% {
                transform: translate3d(-90px, 0, 0);
            }

            100% {
                transform: translate3d(85px, 0, 0);
            }
        }

        /*Shrinking for mobile*/
        @media (max-width: 768px) {
            .waves {
                height: 40px;
                min-height: 40px;
            }

            .content {
                height: 30vh;
            }

            h1 {
                font-size: 24px;
            }
        }

        /* Footer */

        .ocean {
            height: 5%;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            background: #015871;
        }

        .wave {
            background: url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg) repeat-x;
            position: absolute;
            top: -198px;
            width: 6400px;
            height: 198px;
            animation: wave 7s cubic-bezier(0.36, 0.45, 0.63, 0.53) infinite;
            transform: translate3d(0, 0, 0);
        }

        .wave:nth-of-type(2) {
            top: -175px;
            animation: wave 7s cubic-bezier(0.36, 0.45, 0.63, 0.53) -.125s infinite, swell 7s ease -1.25s infinite;
            opacity: 1;
        }

        @keyframes wave {
            0% {
                margin-left: 0;
            }

            100% {
                margin-left: -1600px;
            }
        }

        @keyframes swell {

            0%,
            100% {
                transform: translate3d(0, -25px, 0);
            }

            50% {
                transform: translate3d(0, 5px, 0);
            }
        }

    </style>
</head>

<body>

    <!--Hey! This is the original version
of Simple CSS Waves-->

    <div class="header">

        <!--Content before waves-->
        <div class="inner-header flex">
            <div class="image-cover hero_banner" data-overlay="0">
                <div class="container">
                    <!-- Type -->
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="banner-search-2 transparent">
                                <h1 class="big-header-capt cl_2 mb-2 f_2">{{ trans('frontend.banner_tl') }}</h1>
                                <p class="fs-17">{{ trans('frontend.banner_txt') }}</p>
                                <div class="mt-4">
                                    @if (empty(Auth::user()))
                                        <a href="{{ route('auth.registerForm') }}"
                                            class="btn btn-modern dark">{{ trans('frontend.reg_now') }}<span><i
                                                    class="ti-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i></span></a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="flixio pt-5">
                                <img class="img-fluid" src="{{ asset('frontend/assets/img/edu_2.png') }}" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Waves Container-->
        <div>
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave"
                        d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </div>
        <!--Waves end-->

    </div>

    <div style="height: 100px"></div>
    <!--Header ends-->
    <footer class="dark-footer skin-dark-footer">
        <div style="background: url('https://www.pngkit.com/png/full/167-1670699_blue-divider-png.png'); height: 160px;">

        </div>
        <div>
            <div class="container">
                <div class="row">

                    <div class="col-lg-5 col-md-3">
                        <div class="footer-widget">
                            <img src="{{ asset('frontend/images/logo0.png') }}" class="img-footer" alt="" />
                            <div class="footer-add">
                                <p>
                                    {{ trans('frontend.about_p') }}
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-lg-3 col-md-3">
                        <div class="footer-widget">
                            <h4 class="widget-title">{{ trans('frontend.navigations') }}</h4>
                            <ul class="footer-menu">
                                <li><a href="{{ route('frontend.about.index') }}">{{ trans('menu.about') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('frontend.sessions.index') }}">{{ trans('frontend.find_session') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('frontend.teachers.index') }}">{{ trans('frontend.find_tutor') }}</a>
                                </li>
                                <li><a href="#">{{ trans('menu.contact') }}</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-6">
                        <p style="font-size: 17px;color:#bbb; text-align: center;margin:0"><strong
                                style="color:#ddd">{{ trans('frontend.main_site') }}</strong> ©
                            {{ trans('frontend.copyright_footer') }} {{ now()->year }}</p>
                    </div>

                    <div class="col-lg-6 col-md-6 text-left">
                        <ul class="footer-bottom-social">

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </footer>

</body>

</html>

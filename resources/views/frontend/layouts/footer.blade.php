
<footer class="dark-footer skin-dark-footer">

    {{-- <svg id="wave" class="d-none d-lg-block" style="transform:rotate(0deg);transition: 0.3s;position: absolute;top: -87px;" viewBox="0 0 1440 100" version="1.1" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0"><stop stop-color="rgba(211, 103, 239, 1)" offset="0%"></stop><stop stop-color="rgba(211, 103, 239, 1)" offset="100%"></stop></linearGradient></defs><path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,60L80,50C160,40,320,20,480,21.7C640,23,800,47,960,60C1120,73,1280,77,1440,71.7C1600,67,1760,53,1920,50C2080,47,2240,53,2400,53.3C2560,53,2720,47,2880,48.3C3040,50,3200,60,3360,55C3520,50,3680,30,3840,33.3C4000,37,4160,63,4320,70C4480,77,4640,63,4800,60C4960,57,5120,63,5280,58.3C5440,53,5600,37,5760,30C5920,23,6080,27,6240,35C6400,43,6560,57,6720,61.7C6880,67,7040,63,7200,56.7C7360,50,7520,40,7680,43.3C7840,47,8000,63,8160,73.3C8320,83,8480,87,8640,83.3C8800,80,8960,70,9120,68.3C9280,67,9440,73,9600,71.7C9760,70,9920,60,10080,56.7C10240,53,10400,57,10560,55C10720,53,10880,47,11040,43.3C11200,40,11360,40,11440,40L11520,40L11520,100L11440,100C11360,100,11200,100,11040,100C10880,100,10720,100,10560,100C10400,100,10240,100,10080,100C9920,100,9760,100,9600,100C9440,100,9280,100,9120,100C8960,100,8800,100,8640,100C8480,100,8320,100,8160,100C8000,100,7840,100,7680,100C7520,100,7360,100,7200,100C7040,100,6880,100,6720,100C6560,100,6400,100,6240,100C6080,100,5920,100,5760,100C5600,100,5440,100,5280,100C5120,100,4960,100,4800,100C4640,100,4480,100,4320,100C4160,100,4000,100,3840,100C3680,100,3520,100,3360,100C3200,100,3040,100,2880,100C2720,100,2560,100,2400,100C2240,100,2080,100,1920,100C1760,100,1600,100,1440,100C1280,100,1120,100,960,100C800,100,640,100,480,100C320,100,160,100,80,100L0,100Z"></path></svg>
     --}}

    <div>
        <div class="container">
            <div class="row">

                <div class="col-lg-5 col-md-3">
                    <div class="footer-widget">
                        <img src="{{ asset('frontend/images/logo0.png') }}" class="img-footer" alt="" />
                        <div class="footer-add">
                            <p>
                                Cabes Foundation fournit des services professionnels dans le domaine de l'éducation et la formation en se servant des moyens technologiques pour mieux atteindre ses objectifs. Parmi nos services, l'enseignement et la formation à distance qui est un projet ambitieux.
                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-lg-3 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">Navigations</h4>
                        <ul class="footer-menu">
                            <li><a href="{{ route('frontend.about.index') }}">{{ trans('menu.about') }}</a></li>
                            <li><a href="{{ route('frontend.sessions.index') }}">{{ trans('frontend.find_session') }}</a></li>
                            <li><a href="{{ route('frontend.teachers.index') }}">{{ trans('frontend.find_tutor') }}</a></li>
                            <li><a href="#">{{ trans('menu.contact') }}</a></li>
                        </ul>
                    </div>
                </div>
{{--
                <div class="col-lg-2 col-md-3">
                    <div class="footer-widget">
                        <h4 class="widget-title">Lien utiles</h4>
                        <ul class="footer-menu">
                            <li><a href="#">Documentation</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Faqs</a></li>
                        </ul>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6">
                    <p style="font-size: 17px;color:#bbb; text-align: center;margin:0"><strong style="color:#ddd">{{ trans('frontend.main_site') }}</strong>  © {{ now()->year }} . {{ trans('frontend.copyright_footer') }}</p>
                </div>

                <div class="col-lg-6 col-md-6 text-right">
                    <ul class="footer-bottom-social">
                        @foreach ($menu['social_accounts'] as $contact)
                            <li><a href="{{ $contact->content }}"><i class="ti-{{ $contact->contact_type->name }}"></i></a></li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
</footer>

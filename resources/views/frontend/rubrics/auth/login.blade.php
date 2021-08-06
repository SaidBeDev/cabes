
@extends('frontend.layouts.master')

@section('content')
    <section>
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-9 col-sm-12">
                    <div class="log_wrap">
                        <h4>{{ trans('frontend.login_page_txt') }}</h4>

                       {{--  <div class="social-login light single mb-3">
                            <ul>
                                <li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Login with Facebook</a></li>
                                <li><a href="#" class="btn connect-google"><i class="ti-google"></i>Login with Google</a></li>
                            </ul>
                        </div>

                        <div class="modal-divider"><span>{{ trans('frontend.or') }}</span></div> --}}

                        <div class="login-form">
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => route('auth.login'),
                                'name' => 'login',
                                'id' => 'login'
                            ]) !!}

                                @if ($errors->any())
                                <div class="form-row">
                                    <div class="alert alert-danger">
                                        <div class="col-xl-12">
                                            <div class="col-xl-6">
                                                <div class="uk-alert uk-alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label>{{ trans('frontend.email') }}</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('frontend.password') }}</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="social-login mb-3">
                                    <ul>
                                        <li style="flex: 2 !important">
                                            <input id="reg" class="checkbox-custom" name="remember" type="checkbox">
                                            <label for="reg" class="checkbox-custom-label">{{ trans('frontend.remember_me') }}</label>
                                        </li>
                                        <li class="right"><a href="{{ route('auth.resetPasswordForm') }}" class="theme-cl">{{ trans('frontend.forget_pass') }}</a></li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width pop-login">{{ trans('frontend.login') }}</button>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

 @section('styles')
     <style>
         label {
             font-weight: 600
         }

        @media (min-width: 485px) {
            .social-login ul li {
                flex: unset;
                width: unset !important;
            }
        }
     </style>
 @endsection

 @section('scripts')
    {{-- {!! Html::script('vendor/jsvalidation/js/jsvalidation.min.js') !!} --}}

    @include('frontend._partials.notif')
 @endsection

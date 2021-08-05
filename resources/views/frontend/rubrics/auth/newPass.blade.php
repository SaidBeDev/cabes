@php
    $user = $data['user'];
@endphp

@extends('frontend.layouts.master')

@section('content')
    <section>
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-9 col-sm-12">
                    <div class="log_wrap">
                        <h4>{{ trans('frontend.login_page_txt') }}</h4>

                        <div class="login-form">
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => route('auth.resetPassword'),
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
                                    <label>{{ trans('frontend.new_password') }}</label>
                                    <input type="hidden" name="code" value="{{ $data['code'] }}">
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <input type="password" name="password" class="form-control" required>
                                    <label for="">{{ trans('frontend.confirm_password') }}</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width pop-login">{{ trans('frontend.save') }}</button>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

 @section('scripts')
    {{-- {!! Html::script('vendor/jsvalidation/js/jsvalidation.min.js') !!} --}}
    {!! $data['validator']->selector('#login') !!}

    @include('frontend._partials.notif')
 @endsection

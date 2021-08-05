
@extends('frontend.layouts.master')

@section('content')
    <section>
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-9 col-sm-12">
                    <div class="log_wrap">
                        <h4>{{ trans('frontend.reset_pass') }}</h4>

                        <div class="login-form">
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => route('auth.SendResetMail'),
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
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width pop-login">{{ trans('frontend.send_link') }}</button>
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

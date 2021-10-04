
@extends('frontend.layouts.master')

@section('content')
    <section class="error-wrap" style="background-color: #efefef">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-10">
                    <div class="text-center">

                        <div class="alert alert-info">
                            <h4 style="color: unset"><i class="fa fa-check"></i> {{ trans('frontend.welcome_txt') }}</h4>
                            <p style="font-size: 17px"><b><i class="fa fa-hand-paper"></i></b> {{ trans('frontend.go_email_txt') }}</p>
                        </div>

                        {{-- <a class="btn btn-outline-theme" href="{{ route('auth.loginForm') }}">{{ trans('frontend.login') }}</a> --}}

                    </div>

                    @if(!empty(session()->has('isTeacher')) and session('isTeacher') == true)
                        <div class="alert alert-info mt-3">
                            <h4>{{ trans('frontend.note') . ' :' }}</h4>
                            <p>{{ trans('frontend.not_verified_txt') }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .error-wrap {
            padding: 110px 0;
        }
    </style>
@endsection


@section('scripts')
    <script>
        $(document).ready(function(){
            @if(!empty(session()->has('success')))
                @if(session('success') == true)
                    new Noty({
                        type: 'success',
                        theme: 'sunset',
                        text: "{{ session('message') }}"
                    }).show();
                @elseif(session('success') == false)
                    new Noty({
                            type: 'error',
                            theme: 'sunset',
                            text: "{{ session('message') }}"
                        }).show();
                @endif
            @elseif(session()->has('error'))
                new Noty({
                        type: 'error',
                        theme: 'sunset',
                        text: "Une erreur est survenue"
                    }).show();
            @endif
        });
    </script>
@endsection

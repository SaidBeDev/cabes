
@extends('frontend.layouts.master')

@section('content')
    <section class="error-wrap" style="background-color: #efefef">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-6 col-md-10">
                    <div class="text-center">


                        <h4><i class="fa fa-hand-paper"></i> {{ trans('frontend.not_verified_tlt') }}</h4>
                        <p style="{{ app()->getLocale() == 'ar' ? 'text-align: unset' : '' }}">{{ trans('frontend.not_verified_txt') }}</p>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('styles')
    <style>
        .error-wrap {
            padding: 130px 0;
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

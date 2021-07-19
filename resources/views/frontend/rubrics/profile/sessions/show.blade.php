@php
    $user = Auth::user();
    $session = $data['session'];

    $d1 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_from);
    $d2 = Carbon::createFromFormat('H:i', '15:00');
    $now = Carbon::now();

@endphp

@extends('frontend.layouts.master')

@section('content')

<section class="gray pt-0">
    <div class="container-fluid">

        <!-- Row -->
        <div class="row">
            @include('frontend.rubrics.profile.__partials.aside')


            <div class="col-lg-9 col-md-9 col-sm-12">

                {{-- Breadcrumbs --}}
                @include('frontend.rubrics.profile.__partials.breadcrumbs')

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.mng_sessions') }}</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body p-4">
                                <div class="row">

                                    <div class="col-lg-8">
                                        <div class="property_video xl">
                                            <div class="thumb">
                                                <img class="pro_img img-fluid w100" src="{{ asset(!empty($session->image) ? config('SaidTech.images.sessions.upload_path') . $session->image : 'frontend/assets/img/co-1.jpg') }}" alt="7.jpg">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4">

                                        <!-- Course info -->
                                        <div class="ed_view_box style_3">

                                            <div class="property_video sm">
                                                <div class="thumb">
                                                    {{-- <img class="pro_img img-fluid w100" src="{{ asset('frontend/assets/img/banner-5.jpg') }}" alt="7.jpg"> --}}

                                                </div>
                                            </div>

                                            @if (!empty(Auth::user()))
                                                <div class="ed_view_price pl-4">

                                                    <h2 class="theme-cl">{{ '-'. $session->credit_cost .' '. trans('frontend.da') }}</h2>
                                                </div>
                                            @endif

                                            <div class="ed_view_short pl-4 pr-4 pb-2">
                                                <p>{{ $session->desc }}</p>
                                            </div>

                                            <div class="ed_view_features half_list pl-4 pr-3">
                                                <span>{{ trans('frontend.course_car') }}</span>
                                                <ul>

                                                    <li><i class="ti-user"></i>{{ $session->capacity .' '. trans('frontend.students') }}</li>
                                                    <li><i class="ti-time"></i>{{ getSessionLen($session) .'h'. ' 00' }}</li>
                                                </ul>

                                            </div>

                                            @php
                                                $d1 = Carbon::createFromFormat('H:i', $session->periods->first()->hour_from);
                                                $now = Carbon::now();
                                            @endphp
                                            @if (($now->diffInMinutes($d1) <= 15 && $now->lt($d1)) or ($now->gte($d1)))
                                                <div class="ed_view_features pl-4">
                                                    <h6 class="fs-14">{{ trans('frontend.session_link') }}</h6>
                                                    <a href="{{ $session->link }}" class="btn btn-info" target="_blank"
                                                        onclick="window.open('{{ $session->link }}',
                                                                    'newwindow',
                                                                    'width=600,height=450');
                                                        return false;"
                                                        >{{ trans('frontend.session_link') }}</a>
                                                </div>
                                            @endif

                                            <div class="ed_view_link">
                                                <a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}" class="btn btn-secondary enroll-btn" target="_blank">{{ trans('frontend.go_session') }}<i class="ti-angle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

<script>
    $(document).ready(function() {
        // Set equivalent height to tr (s)
        $('tr.h_height').css('height', $('tr.d_height').height() + 'px');
        $(document).on('click', '', function() {

        });
    });
</script>
@endsection

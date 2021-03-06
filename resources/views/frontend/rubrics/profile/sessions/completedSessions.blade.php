{{-- @foreach ($data['list_sessions'] as $key => $sessions)
    @foreach ($sessions as $session)
        {{ dd($session) }}
    @endforeach
@endforeach --}}
@extends('frontend.layouts.master')

@section('content')

<section class="gray pt-0">
    <div class="container-fluid">

        <!-- Row -->
        <div class="row">
            @include('frontend.rubrics.profile.__partials.aside')

            <div class="col-lg-9 col-md-9 col-sm-12">

                {{-- Breadcrumbs --}}
                {!! Breadcrumbs::render('completed_sessions') !!}

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.completed_sessions') }}</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body p-4">
                                @foreach ($data['list_sessions'] as $key => $sessions)

                                    <!-- Single Course -->
                                    <div class="dashboard_single_course">
                                        <div class="dashboard_single_course_thumb">
                                            <img src="{{ !empty($sessions->first()->image) ? asset(config('SaidTech.images.sessions.upload_path') . $sessions->first()->image) : 'https://via.placeholder.com/700x500' }}" class="img-fluid" alt="" />
                                            <div class="dashboard_action">
                                                <a href="{{ route('frontend.profile.sessions.show', ['id' => $sessions->first()->id]) }}" class="btn btn-ect">{{ trans('frontend.browse') }}</a>
                                            </div>
                                        </div>
                                        <div class="dashboard_single_course_caption">
                                            <div style="text-align: end; margin-bottom: 10px">
                                                <a href="{{ route('frontend.profile.sessions.enrolledStudents', ['id' => $sessions->first()->id]) }}" class="btn btn-outline-primary btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.enrolled_list') }}"><i class="fa fa-users"></i></a>
                                            </div>
                                            <div class="dashboard_single_course_head">
                                                <div class="dashboard_single_course_head_flex">
                                                    <h4 class="dashboard_course_title">{{ !empty($sessions->first()->title) ? $sessions->first()->title : '' }}</h4>
                                                </div>

                                                <div class="dc_head_right">
                                                    @if (Auth::user()->profile_type->name == "teacher")
                                                        <h4 class="dc_price_rate theme-cl" style="color: {{ $sessions['total_credit'] < 0 ? '#da0b4e' : 'green' }}">{{ ($sessions['total_credit'] >= 0 ? '+' : '-'). $sessions['total_credit'] .' '. trans('frontend.da') }}</h4>
                                                    @else
                                                        <h4 class="dc_price_rate theme-cl" style="color: {{ 'green' }}">{{ ('-'). $sessions->first()->credit_cost .' '. trans('frontend.da') }}</h4>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="dashboard_single_course_des">
                                                <p>{{ $sessions->first()->desc }}</p>
                                            </div>
                                            <div class="dashboard_single_course_progress">

                                                <div class="dashboard_single_course_progress_2">
                                                    <ul class="m-0">
                                                        @if (Auth::user()->profile_type->name == "teacher")
                                                            <li class="list-inline-item"><i class="ti-user mr-1"></i>{{ $sessions->first()->students->count() .' '. trans('frontend.enrolled_nb') }}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
    <style>
        .dashboard_single_course_progress{
            position: relative;
        }
        .dashboard_single_course_progress_2{
            position: absolute;
            right: 0
        }

    </style>
@endsection

@section('scripts')
    @include('frontend._partials.notif')
@endsection

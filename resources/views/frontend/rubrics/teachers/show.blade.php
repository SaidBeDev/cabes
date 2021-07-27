@php
    $user = $data['user'];
@endphp

@extends('frontend.layouts.master')

@section('content')

<div class="image-cover ed_detail_head invers" style="background:#0b1c38;" data-overlay="0">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="viewer_detail_wraps">
                    <div class="viewer_detail_thumb">
                        <img src="{{ asset( !empty($user->image) ? $user->image : ($user->gender == 'male' ? 'frontend/images/default/user-m.png' : 'frontend/images/default/user-f.png')) }}" class="img-fluid" alt="" />
                        {{-- <div class="viewer_status"><i class="fas fa-check-circle"></i></div> --}}
                    </div>
                    <div class="caption">
                        <div class="viewer_package_status">{{ $user->teacher->experience .' '. trans('frontend.experience_nb')}}</div>
                        <div class="viewer_header">
                            <h4>{{ $user->full_name }}</h4>
                            <ul class="instructor_info">
                                @foreach ($user->teacher->modules as $module)
                                    <li class="badge badge-light fs-10"><i class="ti-tag"></i>{{ $module->name }}</li>
                                @endforeach
                            </ul>
                            <div class="viewer_location mb-1"><b><i class="fas fa-certificate"></i> {{ $user->teacher->diploma }}</b></div>
                            {{-- <span class="viewer_location">{{ $user->commune->name . ', ' . $user->commune->daira->wilaya->name }}</span> --}}
                            <ul>
                                <li><strong>{{ $user->teacher->sessions->count() }}</strong> {{ trans('menu.sessions') }}</li>
                                <li><strong>{{ $user->total_hours }}</strong> {{ trans('frontend.teacher_hrs') }}</li>
                            </ul>
                        </div>
                        <div class="viewer_header">
                            <ul class="badge_info">
                                {{-- <li class="started"><i class="ti-rocket"></i></li>
                                <li class="medium"><i class="ti-cup"></i></li>
                                <li class="platinum"><i class="ti-thumb-up"></i></li>
                                <li class="elite unlock"><i class="ti-medall"></i></li>
                                <li class="power unlock"><i class="ti-crown"></i></li> --}}
                                @foreach ($user->getSocialCntacts() as $contact)
                                    @if (!in_array($contact->contact_type->name, ['viber', 'whatsapp']))
                                        <li><a href="{{ $contact->content }}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ $contact->contact_type->name }}"><i class="fab fa-{{ $contact->contact_type->icon }}"></i></a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<section>
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-6 col-sm-12">
                <div class="tab_box_info mt-4">

                    <div class="tab-content" id="pills-tabContent">

                        <!-- Overview Detail -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <!-- Overview -->
                            <div class="edu_wraper">
                                <h4 class="edu_title">{{ trans('frontend.desc') }}</h4>
                                <p class="fs-17">{{ $user->teacher->desc }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                @if (!empty($user->teacher->video_link))
                    <div>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe itemprop="video" src={{ str_replace('watch?v=', 'embed/', $user->teacher->video_link) }} frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="dashboard_container">
                    <div class="dashboard_container_header">
                        <div class="dashboard_fl_1">
                            <h4 class="uc"><i class="fas fa-calendar-alt"></i> {{ trans('frontend.available_table') }} </h4>
                        </div>
                    </div>
                    <div class="dashboard_container_body p-4">
                        @if ($user->profile_type->name == "teacher")
                            <div class="form-row mt-3 pl-3">

                                <div class="table-container">
                                    <table class="table table-striped table-bordered hours-tbl">
                                        <tbody>
                                            @foreach ($data['list_periods'] as $period)
                                                <tr class="h_height">
                                                    <td>{{ $period->hour_from .'-'. $period->hour_to }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-bordered days-tbl">
                                        <thead>
                                            <th>{{ trans('frontend.sat') }}</th>
                                            <th>{{ trans('frontend.sun') }}</th>
                                            <th>{{ trans('frontend.mon') }}</th>
                                            <th>{{ trans('frontend.tue') }}</th>
                                            <th>{{ trans('frontend.wed') }}</th>
                                            <th>{{ trans('frontend.thur') }}</th>
                                            <th>{{ trans('frontend.fri') }}</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                                            @endphp

                                            @foreach ($data['list_periods'] as $period)
                                            @php
                                                $ind = $loop->index;
                                            @endphp
                                                <tr>
                                                    @for ($i = 0; $i < count($days); $i++)
                                                        @php
                                                            $contained = [];
                                                            $status = [];
                                                            $nextDate = Carbon::createFromTimestamp(strtotime('next '.$days[$i]));

                                                            foreach ($user->teacher->shedules as $shedule) {
                                                                $contained[$shedule->day][$shedule->period_id] = ($shedule->period_id == $period->id) && ($shedule->day == $days[$i]);
                                                                $status[$shedule->day][$shedule->period_id] = $shedule->status_id;
                                                            }
                                                        @endphp
                                                        @if (isset($contained[$days[$i]][$period->id]) && $contained[$days[$i]][$period->id])
                                                            @if ($status[$days[$i]][$period->id] == 3)
                                                                @php
                                                                    $shedule = null;

                                                                    foreach ($user->teacher->shedules as $sh) {
                                                                        if ($sh->day == $days[$i] && $sh->period_id == $period->id && $sh->status->id == 3) {
                                                                            $shedule = $sh;
                                                                            break;
                                                                        }
                                                                    }
                                                                @endphp
                                                                {{-- Check if session is overdate or canceled --}}
                                                                @if ((!empty($shedule->session) and $shedule->session->is_canceled == 1) || Carbon::now()->gte(Carbon::createFromFormat('Y-m-d H:i', $shedule->date .' '. $period->hour_from)))
                                                                    <td class="bg-light">.{{-- ucfirst(trans('frontend.occupied')) --}}</td>
                                                                {{-- Check if session is occupied --}}
                                                                @elseif (!empty($shedule->session) ? ((int)$shedule->session->students->count() == (int)$shedule->session->capacity) : false)
                                                                    <td class="bg-grey">{{ ucfirst(trans('frontend.out_capacity')) }}</td>
                                                                @else
                                                                    <td class="bg-blue"><a style="color: #03a9f4;display: block" data-toggle="tooltip" data-html="true" data-template='<div class="tooltip" role="tooltip alert alert-primary"><div class="tooltip-inner alert alert-primary"></div></div>' title="<b><i class='fa fa-info-circle'></i> {{ trans('frontend.title') .': '. $shedule->session->title }}</b><br/><b><i class='fab fa-leanpub'></i> {{ trans('frontend.objectives') .': ' }}</b>{!! nl2br(e($shedule->session->objectives)) !!}" target="_blank" href="{{ route('frontend.sessions.show', ['slug' => $shedule->session->slug]) }}">.{{-- ucfirst(trans('frontend.session')) --}}</a></td>
                                                                @endif

                                                            @else
                                                                <td class="bg-green">{{-- ucfirst(trans('frontend.available')) --}}</td>
                                                            @endif

                                                        @else
                                                            <td class="bg-light">.{{-- ucfirst(trans('frontend.occupied')) --}}</td>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
    <style>
        .min-h {
            min-height: 900px;
        }
        .dtl-section {
            padding-top: 15px;
        }
        .dtl-list ul {
            list-style: none;
            padding-left: 0
        }
        .dtl-list ul li {
            display: inline-block;
        }
        .dtl-list ul li:not(:first-child) {
            margin-left: 10px
        }

        ul.soc li{
            display: inline-block;
        }

        .table-container{
            width: 100%;
            display: block;
            position: relative;
            height: 620px;
            overflow: scroll;
        }

        @media (max-width: 1140px) {
            .table-container .hours-tbl{
                width: 35% !important
            }
            .table-container .days-tbl{
                display: block;
                width: 82% !important;
                right: -65px !important;
            }
        }
        .table-container .hours-tbl{
            width: 15%;
            position: absolute;
            left: 0;
            bottom: 0;
            top: 9%;
        }
        .table-container .days-tbl{
            width: 85%;
            position: absolute;
            max-height: 100%;
            right: 0;
            bottom: 0;
            top: 0;
        }
        .table-container .days-tbl tbody{
            color: #fff
        }

        .bg-green{
            background-color: forestgreen
        }
        .bg-grey{
            background-color: gray
        }
        .bg-danger {
            background-color: orangered
        }
        .bg-yellow {
            background-color: orange
        }

        .bg-blue a, .bg-blue a:hover{
            color: #fff
        }

        .tooltip-inner{
            text-align: start
        }
    </style>
@endsection

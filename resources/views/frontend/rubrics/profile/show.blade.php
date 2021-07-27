@php
    $user = $data['user'];
    /* #a434fa */
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
                {!! Breadcrumbs::render('profile_show') !!}

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.mng_profile') }}</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body p-4">
                                <div class="form-row">
                                    {{-- <input type="hidden" name="profile_type_id" value="{{ $user->profile_type_id }}"> --}}
                                    <div class="mr-3">
                                        <img class="rounded-circle" src="{{ !empty($user->avatar) ? asset('frontend/images/avatars/'. $user->avatar) : asset('backend/assets/images/avatars/default.jpg') }}" alt="" width=150>
                                    </div>
                                    <div class="col-md-6 dtl-section">
                                        <h4>{{ $user->full_name }}</h4>
                                        @if ($user->profile_type->name == "teacher")
                                            @foreach ($user->teacher->modules as $module)
                                                <div class="mb-2 mr-2 badge badge-alternate">{{ $module->name }}</div>
                                            @endforeach
                                        @else
                                            <div class="mb-2 mr-2 badge badge-alternate">{{ $user->student->study_year->name }}</div>
                                        @endif
                                        <p>{{ $user->address }}</p>
                                        <div class="dtl-list">
                                            <ul>
                                                <li><b>{{ $user->credit }}</b> {{ trans('frontend.credits') }}</li>
                                                <li><b>{{ $user->total_hours }}</b> {{ $user->profile_type->name == "teacher" ? trans('frontend.teacher_hrs') : trans('frontend.studied_hrs') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row mt-3 pl-3">
                                    <div>
                                        <h5>{{ trans('frontend.desc') }}</h5>
                                        <p>{{ !empty($user->teacher->desc) ? $user->teacher->desc : '' }}</p>
                                    </div>
                                    <div class="coordinates">
                                        <h5>{{ trans('frontend.coordinates') }}</h5>
                                        <ul>
                                            <li><strong>{{ trans('frontend.email') }}: </strong> {{ $user->email }}</li>
                                            <li><strong>{{ trans('frontend.tel') }}: </strong> {{ $user->tel }}</li>

                                            @foreach ($user->contacts as $contact)
                                                @switch($contact->contact_type->name)
                                                    @case('viber')
                                                        <li><i class="icofont-brand-viber" style="color: blueviolet"></i> <strong>{{ trans('frontend.viber') .': ' }}</strong>{{  $contact->content  }}</li>
                                                        @break
                                                    @case('whatsapp')
                                                        <li><i class="icofont-brand-whatsapp" style="color: limegreen"></i> <strong>{{ trans('frontend.whatsapp') .': ' }}</strong>{{  $contact->content  }}</li>
                                                        @break
                                                    @default
                                                @endswitch
                                            @endforeach
                                        </ul>

                                        @if ($user->contacts->isNotEmpty())
                                            <ul class="soc" style="list-style: none">
                                                @foreach ($user->contacts as $contact)
                                                    @switch($contact->contact_type->name)
                                                        @case('facebook')
                                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-primary btn-sm"><i class="icofont-facebook"></i> {{ trans('frontend.facebook') }}</a> </li>
                                                            @break
                                                        @case('twitter')
                                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-info btn-sm"><i class="icofont-twitter"></i> {{ trans('frontend.twitter') }}</a> </li>
                                                            @break
                                                        @case('instagram')
                                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-alternate btn-sm"><i class="icofont-instagram"></i> {{ trans('frontend.instagram') }}</a> </li>
                                                            @break
                                                        @case('linkedin')
                                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-info btn-sm"><i class="icofont-linkedin"></i> {{ trans('frontend.linkedin') }}</a> </li>
                                                            @break
                                                    @endswitch
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="dashboard_container">
                    <div class="dashboard_container_header">
                        <div class="dashboard_fl_1">
                            <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.available_table') }} <a href="{{ route('frontend.profile.editAvailability', ['id' => $user->id]) }}" class="btn btn-outline-theme"><i class="fa fa-edit"></i> {{ trans('menu.edit_availability') }}</a></h4>
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


@section('scripts')
    @include('frontend._partials.notif')

    <script>
        $(document).ready(function() {
            // Set equivalent height to tr (s)
            $('tr.h_height').css('height', $('tr.d_height').height() + 'px');
            $(document).on('click', '', function() {

            });
        });
    </script>
@endsection

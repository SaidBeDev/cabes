@php
    $periods = App\Period::orderBy('hour_from')->get();
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
                {!! Breadcrumbs::render('sessions') !!}

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
                                @foreach ($data['list_sessions'] as $session)
                                    <!-- Single Course -->
                                    <div class="dashboard_single_course">
                                        <div class="dashboard_single_course_thumb">
                                            <img src="{{ !empty($session->image) ? asset(config('SaidTech.images.sessions.upload_path') . $session->image) : 'https://via.placeholder.com/700x500' }}" class="img-fluid" alt="" />
                                            <div class="dashboard_action">
                                                <a href="{{ route('frontend.profile.sessions.edit', ['id' => $session->id]) }}" class="btn btn-ect">{{ trans('frontend.edit') }}</a>
                                                <a href="{{ route('frontend.profile.sessions.show', ['id' => $session->id]) }}" class="btn btn-ect">{{ trans('frontend.browse') }}</a>
                                            </div>
                                        </div>
                                        <div class="dashboard_single_course_caption">
                                            @if (Auth::user()->profile_type->name == "teacher")
                                                <div style="text-align: end; margin-bottom: 10px">
                                                    @php
                                                        $d1 = Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->period->hour_to);
                                                        $d2 = Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->period->hour_from);
                                                        $now = Carbon::now();
                                                    @endphp
                                                    @if ($now->gt($d1))
                                                        <a href="#" class="btn {{ $session->is_completed ? 'btn-success' : 'btn-outline-success' }} btn-sm btn-circle mark-btn" data-action="mark_comp" data-sessionId="{{ $session->id }}" data-isCompleted="{{ $session->is_completed }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.mark_completed') }}"><i class="fa fa-check"></i></a>
                                                    @endif
                                                    @if ($now->lt($d2))
                                                        <a href="#" class="btn btn-outline-danger btn-sm btn-circle mark-btn"  data-action="mark_canc" data-sessionId="{{ $session->id }}" data-isCompleted="{{ $session->is_canceled }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.mark_canceled') }}"><i class="fa fa-times"></i></a>
                                                    @endif

                                                    <a href="{{ route('frontend.profile.sessions.enrolledStudents', ['id' => $session->id]) }}" class="btn btn-outline-primary btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.enrolled_list') }}"><i class="fa fa-users"></i></a>
                                                </div>
                                            @endif
                                            <div class="dashboard_single_course_head">
                                                <div class="dashboard_single_course_head_flex">
                                                    <h4 class="dashboard_course_title">{{ !empty($session->title) ? $session->title : '' }}</h4>
                                                </div>

                                                <div class="dc_head_right">
                                                    <h4 class="dc_price_rate theme-cl">{{ (Auth::user()->profile_type->name == "teacher" ? '' : '-') . $session->credit_cost }}</h4>
                                                </div>
                                            </div>
                                            <div class="dashboard_single_course_des">
                                                <p>{{ $session->desc }}</p>
                                            </div>
                                            <div class="dashboard_single_course_progress">
                                                @if (Auth::user()->profile_type->name == "teacher")
                                                    <div class="dashboard_single_course_progress_2">
                                                        <ul class="m-0">
                                                            <li class="list-inline-item"><i class="ti-user mr-1"></i>{{ $session->students->count() .' '. trans('frontend.enrolled_nb') }}</li>
                                                        </ul>
                                                    </div>
                                                @endif
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

<script>
    $(document).ready(function() {


        $('a.mark-btn').one('click', function(e) {
            action = $(this).attr('data-action');
            isCompleted = $(this).attr('data-isCompleted');
            sessionId = $(this).attr('data-sessionId');

            if(window.confirm(action == "mark_comp" ? '{{ trans("confirmations.mark_comp") }}' : '{{ trans("confirmations.mark_canc") }}')) {

                // Start AJAX Request
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                if (action == "mark_comp")
                {
                    route    = "{{ route('frontend.profile.sessions.markAsCompleted', ['id' => 'sessionID']) }}".replace('sessionID', sessionId);
                    method   = 'POST';
                    newClass = isCompleted ? 'btn-outline-success' : 'btn-success';

                }
                else if (action == "mark_canc")
                {
                    route    = "{{ route('frontend.profile.sessions.markAsCanceled', ['id' => 'sessionID']) }}".replace('sessionID', sessionId);
                    method   = 'POST';
                    newClass = isCompleted ? 'btn-outline-danger' : 'btn-danger';
                }

                // Ajax Request
                $.ajax({
                    url: route,
                    method: method
                })
                .done(function(response) {
                    if (response.success) {
                        setTimeout(function(){ location.reload(); }, 3000);

                        new Noty({
                            type: 'success',
                            theme: 'sunset',
                            text: response.message
                        }).show();
                    }
                    else if (response.success == 0) {
                        new Noty({
                            type: 'error',
                            theme: 'sunset',
                            text: response.message
                        }).show();
                    }
                })
                .error(function() {
                    new Noty({
                            type: 'error',
                            theme: 'sunset',
                            text: "Un erreur est survenue"
                        }).show();
                })

            }else{
                e.preventDefault();
            }
        });
    });
</script>

@endsection

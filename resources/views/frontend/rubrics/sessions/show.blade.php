@php
    use \Carbon\Carbon;
    $session = $data['session'];
    $dead_date = Carbon::createFromFormat('Y-m-d', '2021-02-03');
    $now = Carbon::createFromFormat('Y-m-d', '2021-02-03');

@endphp

@extends('frontend.layouts.master')

@section('content')

    <!-- ============================ Course Header Info Start================================== -->
    <div class="image-cover ed_detail_head lg" style="background:#f4f4f4 url({{ asset('frontend/assets/img/banner-4.jpg') }});" data-overlay="8">
        <div class="container">
            <div class="row">

                <div class="col-lg-7 col-md-9">
                    <div class="ed_detail_wrap light">
                        <ul class="cources_facts_list">
                            <li class="facts-1">{{ $session->module->name }}</li>
                        </ul>
                        <div class="ed_header_caption">
                            <h2 class="ed_title">{{ $session->title }}</h2>
                            <ul>
                                <li><i class="ti-calendar"></i>{{ $session->date }}</li>
                                @if ($session->periods->count() == 1)
                                    <li><i class="ti-time"></i>{{ $session->periods->first()->hour_from .'-'. $session->periods->first()->hour_to }}</li>
                                @elseif ($session->periods->count() == 2)
                                    <li><i class="ti-time"></i>{{ $session->periods->first()->hour_from .'-'. $session->periods->last()->hour_to }}</li>
                                @endif
                                <li><i class="ti-user"></i>{{ $session->students->count() .' '. trans('frontend.enrolled_nb') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================ Course Header Info End ================================== -->

    <!-- ============================ Course Detail ================================== -->
    <section class="bg-light">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-8">


                    <div class="property_video xl">
                        <div class="thumb">
                            <img class="pro_img img-fluid w100" src="{{ asset(!empty($session->image) ? config('SaidTech.images.sessions.upload_path') . $session->image : 'frontend/assets/img/co-1.jpg') }}" alt="7.jpg">
                            {{-- <div class="overlay_icon">
                                <div class="bb-video-box">
                                    <div class="bb-video-box-inner">
                                        <div class="bb-video-box-innerup">
                                            <img src="{{ asset(!empty($session->image) ? config('SaidTech.images.sessions.upload_path') . $session->image : 'frontend/assets/img/co-1.jpg') }}" class="img-featured" />
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <div class="instructor_over_info">
                            <ul>
                                <li>
                                    <div class="ins_info">
                                        <div class="ins_info_thumb">
                                            <img src="{{ asset('frontend/assets/img/user-1.jpg') }}" class="img-fluid" alt="" />
                                        </div>
                                        <div class="ins_info_caption">
                                            <span>{{ trans('frontend.teacher') }}</span>
                                            <h4>{{ $session->teacher->user->full_name }}</h4>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <span>{{ trans('frontend.module') }}</span>
                                    {{ $session->module->name }}
                                </li>

                            </ul>
                        </div>

                    </div>

                    <!-- All Info Show in Tab -->
                    <div class="tab_box_info mt-4">
                        <ul class="nav nav-pills mb-3 light" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="overview-tab" data-toggle="pill" href="#overview" role="tab" aria-controls="overview" aria-selected="true">{{ trans('frontend.overview') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="instructor-tab" data-toggle="pill" href="#instructor" role="tab" aria-controls="instructor" aria-selected="false">{{ trans('frontend.teacher') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">

                            <!-- Overview Detail -->
                            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                <!-- Overview -->
                                <div class="edu_wraper">
                                    <h4 class="edu_title">{{ trans('frontend.course_overview') }}</h4>
                                    <p>{{ $session->desc }}</p>

                                    <h6>{{ trans('frontend.lesson_objectives') }}</h6>
                                    {{-- <ul class="lists-3">
                                        <li>At vero eos et accusamus et iusto odio dignissimos ducimus</li>
                                    </ul> --}}
                                    <p>
                                        {!! nl2br(e($session->objectives)) !!}
                                    </p>
                                </div>

                            </div>

                            <!-- Instructor Detail -->
                            <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                                <div class="single_instructor">
                                    <div class="single_instructor_thumb">
                                        <a href="#"><img src="{{ asset('frontend/assets/img/user-5.jpg') }}" class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="single_instructor_caption">
                                        <h4><a href="#">{{ $session->teacher->user->full_name }}</a></h4>
                                        <ul class="instructor_info">
                                            {{-- <li><i class="ti-video-camera"></i>72 Videos</li> --}}
                                            <li><i class="ti-control-forward"></i>{{ $session->teacher->user->total_hours .' '. trans('frontend.teacher_hrs') }}</li>
                                            <li><i class="ti-user"></i>{{ $session->teacher->experience .' '. trans('frontend.experience_nb') }}</li>
                                        </ul>
                                        <p>{{ $session->teacher->desc }}</p>
                                        <ul class="social_info">
                                            @foreach ($session->teacher->user->getSocialCntacts() as $contact)
                                                <li><a href="{{ $contact->content }}" target="_blank"><i class="ti-{{ $contact->contact_type->name }}"></i></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

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
                                <span>{{ trans('frontend.price') }}</span>
                                <h2 class="theme-cl">{{ $session->credit_cost .' '. trans('frontend.da') }}</h2>
                            </div>
                        @endif

                        <div class="ed_view_short pl-4 pr-4 pb-2">
                            <p>Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
                        </div>

                        <div class="ed_view_features half_list pl-4 pr-3">
                            <span>{{ trans('frontend.course_car') }}</span>
                            <ul>

                                <li><i class="ti-user"></i>{{ $session->capacity .' '. trans('frontend.students') }}</li>
                                <li><i class="ti-time"></i>2 hour 30 min</li>
                            </ul>
                        </div>
                        <div class="ed_view_link">
                            @if (!empty(Auth::user()))
                                @if (Auth::user()->profile_type->name == "student")
                                    @if ($session->students->contains(Auth::user()->student->id))
                                        {{-- Check if user can cancel the enrollement --}}
                                        @php
                                            $d1 = Carbon::createFromFormat('Y-m-d', $session->date);
                                            $now = Carbon::now();
                                        @endphp
                                        @if ($now->lt($d1))
                                            <a href="#" class="btn btn-danger enroll-btn" data-action="unroll" data-isEnrolled="1" data-sessionId="{{ $session->id }}">{{ trans('frontend.unroll') }}<i class="ti-angle-right"></i></a>
                                        @else
                                            <a href="#" class="btn btn-secondary disabled enroll-btn" >{{ trans('frontend.enrolled') }}<i class="ti-angle-right"></i></a>
                                        @endif
                                    @else
                                        @if ((int)$session->students->count() < (int)$session->capacity)
                                            <a href="#" class="btn btn-theme enroll-btn" data-action="enroll" data-isEnrolled="0" data-sessionId="{{ $session->id }}">{{ trans('frontend.enroll') }}<i class="ti-angle-right"></i></a>
                                        @else
                                            <a href="#" class="btn btn-secondary disabled enroll-btn" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.atteinted_msg') }}">{{ trans('frontend.atteinted') }}<i class="ti-angle-right"></i></a>
                                        @endif
                                    @endif
                                @endif
                            @else
                                <a href="#" class="btn btn-theme unallowed" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.auth_rule') }}">{{ trans('frontend.enroll') }} {{-- <i class="ti-angle-right"></i> --}}</a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ============================ Course Detail ================================== -->
@endsection

@section('scripts')
    @include('frontend._partials.notif')

    <script>
        $(document).ready(function() {
            @if(!empty(Auth::user()))
                $('a.enroll-btn').one('click', function() {

                    action = $(this).attr('data-action');
                    isEnrolled = $(this).attr('data-isEnrolled');
                    sessionId = $(this).attr('data-sessionId');

                    // Start AJAX Request
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    if (action == "enroll")
                    {
                        route = "{{ route('frontend.profile.sessions.joinSession', ['id' => $session->id]) }}";
                        method = 'POST';

                    }
                    else if (action == "unroll")
                    {
                        route = "{{ route('frontend.profile.sessions.exitFromSession', ['id' => $session->id]) }}";
                        method = 'POST';
                    }else {
                        return false;
                    }

                    // Ajax Request
                    $.ajax({
                        url: route,
                        method: method,
                        data: {
                            student_id: {{ Auth::user()->id }}
                        }
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

                });
            @endif
        });
    </script>
@endsection

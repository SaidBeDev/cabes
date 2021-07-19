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
                                <p>{{ $user->teacher->desc }}</p>
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
    </div>
</section>
@endsection

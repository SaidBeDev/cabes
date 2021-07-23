
@php
    $session = $data['session'];
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
                {!! Breadcrumbs::render('enrolled_students') !!}

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="edu_wraper p-0">

                            @foreach ($session->students as $student)
                                <!-- Single Instructor -->
                                <div class="single_instructor border">
                                    <div class="single_instructor_thumb">
                                        <a href="#"><img src="{{ asset( !empty($student->user->image) ? $student->user->image : ($student->user->gender == 'male' ? 'frontend/images/default/user-m.png' : 'frontend/images/default/user-f.png')) }}" class="img-fluid" alt=""></a>
                                    </div>
                                    <div class="single_instructor_caption">
                                        <h4><a href="#">{{ $student->user->full_name }}</a></h4>
                                        <ul class="instructor_info">
                                            <li class="badge badge-success fs-10"><i class="ti-tag"></i>{{ $student->study_year->name }}</li>
                                            <li class="badge badge-light fs-10" style="color: #555"><i class="fa fa-hourglass"></i>{{ $student->user->total_hours .' '. trans('frontend.studied_hours') }}</li>
                                        </ul>
                                        <p>
                                            <ul>
                                                <li><b>{{ trans('frontend.address') }}: </b>{{ $student->user->address .', '. $student->user->commune->name .' '. $student->user->commune->daira->wilaya->name }}</li>
                                                <li><b>{{ trans('frontend.email') }}: </b>{{ $student->user->email }}</li>

                                            </ul>
                                        </p>
                                        {{-- <ul class="social_info">
                                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                                        </ul> --}}
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@extends('frontend.layouts.master')

@section('content')

<section class="pt-0">
    <div class="container">

        @include('frontend.rubrics.sessions._partials.aside')

        <!-- Row -->
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">

                <!-- Row -->
                <div class="row align-items-center mb-3">

                </div>
                <!-- /Row -->

                <div class="row">

                    @foreach ($data['list_sessions'] as $session)
                        <!-- Cource Grid 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="education_block_grid style_2">

                                <div class="education_block_thumb n-shadow">
                                    <a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}"><img src="{{ asset(!empty($session->image) ? config('SaidTech.images.sessions.upload_path') . $session->image : 'frontend/assets/img/co-1.jpg') }}" class="img-fluid" alt=""></a>
                                </div>

                                <div class="education_block_body">
                                    <h4 class="bl-title"><a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}">{{ $session->title }}</a></h4>
                                </div>

                                <div class="cources_facts">
                                    <ul class="cources_facts_list">
                                        <li class="facts-1">{{ $session->module->name }}</li>
                                    </ul>
                                </div>

                                <div class="cources_info">
                                    <div class="cources_info_first">
                                        <ul>
                                            <li><strong>{{ $session->students->count() .' '. trans('frontend.enrolled_nb') }}</strong></li>
                                            <li class="theme-cl">{{ getDiffHours($session->periods->first()->hour_from, $session->periods->last()->hour_to) }}</li>
                                        </ul>
                                    </div>
                                    @if (!empty(Auth::user()))
                                        <div class="cources_info_last">
                                            <h3>{{ $session->credit_cost .' '. trans('frontend.da') }}</h3>
                                        </div>
                                    @endif
                                </div>

                                <div class="education_block_footer">
                                    <div class="education_block_author">
                                        <div class="path-img">
                                            <a href="{{ route('frontend.teachers.show', ['id' => $session->teacher->user->id]) }}" target="_blank">
                                                <img src="{{ asset(!empty($session->teacher->user->avatar) ? 'frontend/images/avatars/' . $session->teacher->user->avatar : ($session->teacher->user->gender == 'male' ? 'frontend/images/default/user-m.png' : 'frontend/images/default/user-f.png')) }}" class="img-fluid" alt="" />
                                            </a>
                                        </div>
                                        <h5><a href="{{ route('frontend.teachers.show', ['id' => $session->teacher->user->id]) }}">{{ $session->teacher->user->full_name }}</a></h5>
                                    </div>
                                    <span class="education_block_time"><i class="ti-calendar mr-1"></i>{{ $session->date }}</span>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>
        <!-- Row -->
    </div>
</section>
@endsection

@section('styles')
    <style>
        .education_block_thumb .img-fluid{
            min-height: 245px;
        }
    </style>
@endsection

 @section('scripts')
    @include('frontend._partials.notif')
 @endsection

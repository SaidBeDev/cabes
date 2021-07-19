
@extends('frontend.layouts.master')

@section('content')
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                @include('frontend._partials.breadcrumbs', ['title' => trans('menu.teachers')])

            </div>
        </div>
    </div>
</section>

<section class="pt-0">
<div class="container-fluid">

    <!-- Row -->
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-9 col-md-9 col-sm-12">

            <!-- Row -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="edu_wraper p-0">

                        @foreach ($data['list_teachers'] as $user)
                            <!-- Single Instructor -->
                            <div class="single_instructor border">
                                <div class="single_instructor_thumb">
                                    <a href="{{ route('frontend.teachers.show', ['id' => $user->id]) }}"><img src="{{ asset( !empty($user->image) ? $user->image : ($user->gender == 'male' ? 'frontend/images/default/user-m.png' : 'frontend/images/default/user-f.png')) }}" class="img-fluid" alt=""></a>
                                </div>
                                <div class="single_instructor_caption">
                                    <h4><a href="{{ route('frontend.teachers.show', ['id' => $user->id]) }}">{{ $user->full_name }}</a></h4>
                                    <ul class="instructor_info">
                                        @foreach ($user->teacher->modules as $module)
                                            <li class="badge badge-alternate fs-10"><i class="ti-tag"></i>{{ $module->name }}</li>
                                        @endforeach
                                    </ul>
                                    <ul class="instructor_info">
                                        <li class="badge badge-light fs-10" style="color: #555"><i class="fa fa-hourglass"></i>{{ $user->total_hours .' '. trans('frontend.teacher_hrs') }}</li>
                                    </ul>

                                    <p>
                                        {{ $user->teacher->desc }}
                                       {{-- <ul>
                                            <li><b>{{ trans('frontend.address') }}: </b>{{ $user->address .', '. $user->commune->name .' '. $user->commune->daira->wilaya->name }}</li>
                                            <li><b>{{ trans('frontend.email') }}: </b>{{ $user->email }}</li>

                                        </ul> --}}
                                    </p>
                                    <ul class="social_info">
                                        @foreach ($user->getSocialCntacts() as $contact)
                                            @if (!in_array($contact->contact_type->name, ['viber', 'whatsapp']))
                                                <li><a href="{{ $contact->content }}" target="_blank" data-toggle="tooltip" data-placement="top" title="{{ $contact->contact_type->name }}"><i class="fab fa-{{ $contact->contact_type->icon }}"></i></a></li>
                                            @endif
                                        @endforeach
                                    </ul>
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


@php
    foreach ($data['list_contacts'] as $contact) {
        switch ($contact->contact_type->name) {
            case 'address':
                $address = $contact->content;
                break;
            case 'phone':
                $phone = $contact->content;
                break;
            case 'email':
                $email = $contact->content;
                break;
        }
    }
@endphp

@extends('frontend.layouts.master')

@section('content')
    <section class="bg-light">

        <div class="container">
            @if ($errors->any())
                    <div class="form-row">
                        <div class="alert alert-danger">
                            <div class="col-xl-12">
                                <div class="col-xl-6">
                                    <div class="uk-alert uk-alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {!! Form::open([
                    'method' => 'POST',
                    'url' => route('frontend.contact.store'),
                    'name' => 'register',
                    'id' => 'register'
                ]) !!}
                <!-- row Start -->
                <div class="row">

                    <div class="col-md-12 mb-5">
                        <div class="prc_wrap" style="width: 70%; margin: auto; text-align: center">
                            <div class="prc_wrap_header">
                                <h2 class="property_block_title">{{ trans('frontend.need_help') }}</h2>
                            </div>

                            <div class="prc_wrap-body">
                                <p class="fs-17">
                                    {{ trans('frontend.contact_txt') }}
                                </p>
                            </div>
                        </div>
                    </div>
                <div class="col-lg-8 col-md-7 contact">
                    <div class="prc_wrap">

                        <div class="prc_wrap_header">
                            <h4 class="property_block_title">{{ trans('frontend.fill_form') }}</h4>
                        </div>

                        <div class="prc_wrap-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('frontend.full_name') }}</label>
                                        <input type="text" class="form-control simple">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('frontend.email') }}</label>
                                        <input type="email" class="form-control simple">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{ trans('frontend.subject') .' '. trans('frontend.optional') }}</label>
                                <input name="subject" type="text" class="form-control simple">
                            </div>

                            <div class="form-group">
                                <label>{{ trans('frontend.message') }}</label>
                                <textarea name="msg" class="form-control simple"></textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-theme" type="submit">{{ trans('frontend.send') }}</button>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-lg-4 col-md-5">

                    <div class="prc_wrap contact">

                        <div class="prc_wrap_header">
                            <h4 class="property_block_title">{{ trans('frontend.reach_us') }}</h4>
                        </div>

                        <div class="prc_wrap-body">
                            <div class="contact-info">

                                <div class="cn-info-detail">
                                    <div class="cn-info-icon">
                                        <i class="ti-home"></i>
                                    </div>
                                    <div class="cn-info-content">
                                        <h4 class="cn-info-title">{{ trans('frontend.address') }}</h4>
                                        {!! !empty($address) ? $address : '' !!}
                                    </div>
                                </div>

                                <div class="cn-info-detail">
                                    <div class="cn-info-icon">
                                        <i class="ti-email"></i>
                                    </div>
                                    <div class="cn-info-content">
                                        <h4 class="cn-info-title">{{ trans('frontend.email') }}</h4>
                                        {!! !empty($email) ? $email : '' !!}
                                    </div>
                                </div>

                                <div class="cn-info-detail">
                                    <div class="cn-info-icon">
                                        <i class="ti-mobile"></i>
                                    </div>
                                    <div class="cn-info-content">
                                        <h4 class="cn-info-title">{{ trans('frontend.tel') }}</h4>
                                        {!! !empty($phone) ? $phone : '' !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /row -->
            {!! Form::close() !!}

        </div>

    </section>
@endsection

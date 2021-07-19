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
                @include('frontend.rubrics.profile.__partials.breadcrumbs')

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.edit_session') }}</h4>
                                </div>
                                <div class="dashboard_fl_2">
                                    <ul class="mb0">
                                        <li class="list-inline-item"><button data-locale="fr" data-selected=1 class="btn btn-secondary">{{ trans('frontend.fr') }}</button></li>
                                        <li class="list-inline-item"><button data-locale="ar" data-selected=0 class="btn btn-light">{{ trans('frontend.ar') }}</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dashboard_container_body p-4">
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
                                        'method' => 'PUT',
                                        'url' => route('frontend.profile.sessions.update', ['id' => $session->id]),
                                        'name' => 'register',
                                        'id' => 'register',
                                        'files' => true
                                    ]) !!}

                                <div class="form-row fr">
                                    <div class="form-group col-md-12 fr">
                                        <label>{{ trans('frontend.title') }} ({{ trans('frontend.fr') }})</label>
                                        <input type="hidden" name="teacher_id" value="{{ Auth::user()->teacher->id }}">
                                        <input type="text" name="title_fr" class="form-control" value="{{ $session->translate('fr')->title }}" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>{{ trans('frontend.desc') }} ({{ trans('frontend.fr') }})</label>
                                        <textarea name="desc_fr" class="form-control">{{ $session->translate('fr')->desc }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>{{ trans('frontend.objectives') }} ({{ trans('frontend.fr') }})</label>
                                        <textarea name="objectives_fr" class="form-control">{{ $session->translate('fr')->objectives }}</textarea>
                                    </div>
                                </div>

                                <div class="form-row ar"  style="display: none">
                                    <div class="form-group col-md-12">
                                        <label>{{ trans('frontend.title') }} ({{ trans('frontend.ar') }})</label>
                                        <input type="text" name="title_ar" class="form-control" value="{{ $session->translate('ar')->title }}">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>{{ trans('frontend.desc') }} ({{ trans('frontend.ar') }})</label>
                                        <textarea name="desc_ar" class="form-control">{{ $session->translate('ar')->title }}</textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>{{ trans('frontend.objectives') }} ({{ trans('frontend.ar') }})</label>
                                        <textarea name="objectives_ar" class="form-control">{{ $session->translate('ar')->objectives }}</textarea>
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="form-group col-md-6">
                                        <label class="d-block">{{ trans('frontend.image') }}</label>
                                        <input type="file" name="image" class="file" accept="image/*">
                                    </div>
                                    {{-- <div class="form-group col-md-6">
                                        <img src="{{ !empty($session->image) ? asset(config('SaidTech.images.sessions.upload_path') . $session->image) : 'https://via.placeholder.com/700x500' }}" class="" alt="" />
                                    </div> --}}
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="d-block">{{ trans('frontend.study_year') }}</label>
                                        <select name="study_year_id" class="form-control selectpicker" data-width="auto" required>
                                            @foreach ($data['study_years'] as $year)
                                                <option value="{{ $year->id }}" {{ $year->id == $session->study_year_id ? 'selected' : '' }}>{{ $year->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="d-block">{{ trans('frontend.module') }}</label>
                                        <select name="module_id" class="form-control selectpicker" data-width="auto" required>
                                            @foreach ($data['list_modules'] as $module)
                                                <option value="{{ $module->id }}" {{ $module->id == $session->module_id ? 'selected' : '' }}>{{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>{{ trans('frontend.link') }}</label>
                                        <input type="url" name="link" class="form-control" value="{{ $session->link }}" required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>{{ trans('frontend.capacity') }}</label>
                                        <input type="number" name="capacity" class="form-control" required value={{ (int)$session->capacity }}>
                                    </div>

                                </div><!-- end form row -->
                                <div class="form-group col-lg-12 col-md-12">
                                    <button class="btn btn-theme" type="submit"><i class="fa fa-save"></i> {{ trans('frontend.save') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        @if(!empty(session()->has('success')))
            @if(session('success') == true)
                new Noty({
                    type: 'success',
                    theme: 'sunset',
                    text: "{{ session('message') }}"
                }).show();
            @elseif(session('success') == false)
                new Noty({
                        type: 'error',
                        theme: 'sunset',
                        text: "{{ session('message') }}"
                    }).show();
            @endif
        @elseif(session()->has('error'))
            new Noty({
                    type: 'error',
                    theme: 'sunset',
                    text: "Une erreur est survenue"
                }).show();
        @endif
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', 'li button', function() {
            var locale   = $(this).attr('data-locale');
            var selected = $(this).attr('data-selected');


           if ($(this).hasClass('btn-secondary') && selected == 0) {
               $('li button.btn-light').removeClass('btn-light').addClass('btn-secondary').attr('data-selected', 0);

                $(this).removeClass('btn-secondary').addClass('btn-light').attr('data-selected', 1);
           }
           else if($(this).hasClass('btn-light') && selected == 0) {
                $('li button.btn-secondary').removeClass('btn-secondary').addClass('btn-light').attr('data-selected', 0);

                $(this).removeClass('btn-light').addClass('btn-secondary').attr('data-selected', 1);

           }

           if (locale == "fr") {
               $('.ar').hide();
               $('.fr').show();
           }

           else {
               $('.fr').hide();
               $('.ar').show();
           }

        });
    });
</script>
@endsection

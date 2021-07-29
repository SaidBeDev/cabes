
@php
    $minDate = null;
    $maxDate = null;

    $d1 = Carbon::createFromTimestamp(strtotime("+1 weeks"));
    $now = Carbon::now();

    if ($now->format('l') != "Thursday") {
        $d2 = Carbon::createFromTimestamp(strtotime($d1->format('d-m-Y') . " next thursday"));
    }else {
        $d2 = Carbon::createFromTimestamp(strtotime("next thursday"));
    }

    $minDate = $now->format('Y-m-d');
    $maxDate = $d2->format('Y-m-d');
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
                    {!! Breadcrumbs::render('create_session') !!}

                    <!-- Row -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="dashboard_container">
                                <div class="dashboard_container_header">
                                    <div class="dashboard_fl_1">
                                        <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.create_session') }}</h4>
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
                                            'method' => 'POST',
                                            'url' => route('frontend.profile.sessions.store'),
                                            'name' => 'register',
                                            'id' => 'register',
                                            'files' => true
                                        ]) !!}

                                    <div class="form-row fr">
                                        <div class="form-group col-md-12 fr">
                                            <label>{{ trans('frontend.title') }} ({{ trans('frontend.fr') }})</label>
                                            <input type="hidden" name="teacher_id" value="{{ Auth::user()->teacher->id }}">
                                            <input type="text" name="title_fr" class="form-control" value="{{ old('title_fr') }}" required>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ trans('frontend.support') }} ({{ trans('frontend.fr') }})</label>
                                            <textarea name="desc_fr" class="form-control">{{ old('desc_fr') }}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ trans('frontend.objectives') }} ({{ trans('frontend.fr') }})</label>
                                            <textarea name="objectives_fr" class="form-control">{{ old('objectives_fr') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-row ar"  style="display: none">
                                        <div class="form-group col-md-12">
                                            <label>{{ trans('frontend.title') }} ({{ trans('frontend.ar') }})</label>
                                            <input type="text" name="title_ar" class="form-control" value="{{ old('title_ar') }}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ trans('frontend.support') }} ({{ trans('frontend.ar') }})</label>
                                            <textarea name="desc_ar" class="form-control">{{ old('desc_ar') }}</textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>{{ trans('frontend.objectives') }} ({{ trans('frontend.ar') }})</label>
                                            <textarea name="objectives_ar" class="form-control">{{ old('objectives_ar') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-row mb-2">
                                        <div class="form-group col-md-12">
                                            <label>{{ trans('frontend.drive_link') }}</label>
                                            <input type="text" name="g_link" class="form-control" value="{{ old('g_link') }}">
                                        </div>
                                    </div>

                                    <div class="form-row mb-2">
                                        <div class="form-group col-md-6">
                                            <label class="d-block">{{ trans('frontend.image') }}</label>
                                            <input type="file" name="image" class="file" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label class="d-block">{{ trans('frontend.study_year') }}</label>
                                            <select name="study_year_id" class="form-control selectpicker" data-width="auto" required>
                                                @foreach ($data['spec_years'] as $year)
                                                    <option style="font-weight: bold" value="{{ $year->id }}" {{ old('study_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                                @endforeach
                                                @foreach ($data['study_years'] as $year)
                                                    <option value="{{ $year->id }}" {{ old('study_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="d-block">{{ trans('frontend.module') }}</label>
                                            <select name="module_id" class="form-control selectpicker modules-select" data-width="auto" required>
                                                @foreach ($data['spec_modules'] as $module)
                                                    <option style="font-weight: bold" value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                                                @endforeach
                                                @foreach ($data['list_modules'] as $module)
                                                    <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.link') }}</label>
                                            <input type="url" name="link" class="form-control" required value="{{ old('link') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.capacity') }}</label>
                                            <input type="number" name="capacity" class="form-control" required value={{ !empty(old('capacity')) ? old('capacity') : (int)$data['default_capacity'] }}>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.date') }}</label>
                                            <input type="date" name="date" class="form-control" min="{{ $minDate }}" max="{{ $maxDate }}" value="{{ old('date') }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="" class="d-block">{{ trans('frontend.hour_from') }}</label>
                                            <select name="period_id[]" class="form-control selectpicker period-select" data-width="auto" multiple data-max-options='2'>
                                                @foreach ($data['list_periods'] as $period)
                                                    <option value="{{ $period->id }}">{{ $period->hour_from .'-'. $period->hour_to }}</option>
                                                @endforeach
                                            </select>
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
    @include('frontend._partials.notif')

    {{-- Validation --}}
    {!! $data['validator']->selector('#register') !!}

<script>
    $(document).ready(function() {

        $('.period-select').on('change', function() {
            seOption = $('select.period-select option:selected');
            notSeOption = $('select.period-select option:not(:selected)');

            prevInd = $('select[name="period_id[]"]').val() ? $('select[name="period_id[]"]').val()[0] : 1;

            /* console.log(parseInt(prevInd)); */
            console.log($('select[name="period_id[]"]').val());

            notSeOption.map(function(key, value) {

                opt = $('.period-select option[value='+ value.value +']');

                if (seOption.length >= 2) {
                    opt.css('cursor', 'not-allowed').attr('disabled', true);
                }else if (seOption.length == 1) {
                    if (parseInt(value.value) == (parseInt(prevInd) + 1) || prevInd == 0) {
                        opt.css('cursor', 'pointer').attr('disabled', false);
                    }else {
                        opt.css('cursor', 'not-allowed').attr('disabled', true);
                    }
                } else if(seOption.length == 0) {
                    opt.css('cursor', 'pointer').attr('disabled', false);
                }
            });

            $('.selectpicker.period-select').selectpicker('refresh');
        });

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

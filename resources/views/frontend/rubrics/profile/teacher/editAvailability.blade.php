
@php
    $user = $data['user'];
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
            {!! Breadcrumbs::render('edit_avail') !!}

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
                            <!-- Basic info -->
                            <div class="submit-section">
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
                                    'url' => route('frontend.profile.updateAvailability' , ['id' => Auth::user()->id]),
                                    'name' => 'register',
                                    'id' => 'register'
                                ]) !!}

                                    @php
                                        $days = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                                        $daySlug = ['sat', 'sun', 'mon', 'tue', 'wed', 'thur', 'fri'];
                                    @endphp

                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <h5><i class="fa fa-info-circle"></i> {{ trans('frontend.note') .':' }}</h5>
                                            <p><b>{{ trans('frontend.edit_avai_txt') }}<b></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead class="thead-dark">
                                                <th scope="col">{{ trans('frontend.day') }}</th>
                                                <th scope="col">{{ trans('frontend.period') }}</th>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($days); $i++)
                                                    <tr>
                                                        <td class=""><b>{{ ucfirst(trans('frontend.' . $daySlug[$i])) }}</b></td>
                                                        <td>
                                                            <select name="{{ $days[$i] .'[]' }}" id="" class="selectpicker" data-width="auto" multiple>
                                                                @foreach ($data['list_periods'] as $period)

                                                                    @php
                                                                        $contained = [];
                                                                        $isSession = [];

                                                                        foreach ($user->teacher->shedules as $shedule) {
                                                                            $contained[$shedule->period_id] = ($shedule->period_id == $period->id) && ($shedule->status->id != 3) && ($shedule->day == $days[$i]);
                                                                        }

                                                                        foreach ($user->teacher->sessions as $session) {
                                                                            $d = strtolower(Carbon::createFromFormat('Y-m-d', $session->date)->format('l'));

                                                                            foreach($session->periods as $p) {
                                                                                $d1 = Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->last()->hour_to);
                                                                                $now = Carbon::now();

                                                                                /* $isSession[$d][$p->id] = true; */
                                                                                $isSession[$d][$p->id] = $now->gte($d1) ? false : true;
                                                                            }
                                                                        }
                                                                    @endphp

                                                                    <option value="{{ $period->id }}" {{ (isset($contained[$period->id]) && $contained[$period->id]) ? 'selected' : '' }}
                                                                        {{ (isset($isSession[$days[$i]]) && isset($isSession[$days[$i]][$period->id])
                                                                         ? ($isSession[$days[$i]][$period->id] ? 'disabled' : '') : '' ) }}>
                                                                        {{ $period->hour_from .'-'. $period->hour_to }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                 {{--    @for ($i = 0; $i < count($days); $i++)
                                        <div class="form-row mb-3">
                                            <input type="text" disabled value="{{ $days[$i] }}" />

                                            <select name="{{ $days[$i] .'[]' }}" id="" class="selectpicker" data-width="auto" multiple>
                                                @foreach ($data['list_periods'] as $period)
                                                    <option value="{{ $period->id }}">{{ $period->hour_from .'-'. $period->hour_to }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endfor --}}

                                    <button class="btn btn-primary" type="submit">{{ trans('frontend.save') }}</button>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('frontend._partials.notif')
@endsection

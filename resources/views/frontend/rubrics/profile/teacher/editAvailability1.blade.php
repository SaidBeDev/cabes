
@php
    use Spatie\OpeningHours\OpeningHours;
    $user  = $data['user'];
    $avail = unserialize($user->teacher->availability_hours);
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
                                    'url' => route('frontend.profile.updateAvailability', ['id' => $user->id]),
                                    'name' => 'register',
                                    'id' => 'register'
                                ]) !!}


                                <div class="form-row mt-3 pl-3">
                                    <h4>Table de disponibilité </h4>
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered hours-tbl">
                                            <tbody>
                                                @for ($i = 0; $i < count($data['available_hours']); $i++)
                                                    <tr class="h_height">
                                                        <td>{{ $data['available_hours'][$i] }}</td>
                                                    </tr>
                                                @endfor

                                            </tbody>
                                        </table>
                                        <table class="table table-striped table-bordered days-tbl">
                                            <thead>
                                                <th>{{ trans('frontend.sat') }}</th>
                                                <th>{{ trans('frontend.sun') }}</th>
                                                <th>{{ trans('frontend.mon') }}</th>
                                                <th>{{ trans('frontend.tue') }}</th>
                                                <th>{{ trans('frontend.wed') }}</th>
                                                <th>{{ trans('frontend.thur') }}</th>
                                                <th>{{ trans('frontend.fri') }}</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $days         = [ "Saturday", "Sunday", "Monday", "Thursday", "Wednesday", "Tuesday", "Friday" ];
                                                    $availability = !empty($user->teacher->availability_hours) ? unserialize($user->teacher->availability_hours) : null;
                                                    $op_hours     = !empty($availability) ?  OpeningHours::create($availability) : null;

                                                    $k = [];
                                                @endphp

                                                @if (!empty($availability))
                                                    @for ($i = 0; $i < count($data['available_hours']); $i++)
                                                        <tr>
                                                            @for ($j = 0; $j < count($days); $j++)

                                                                @php
                                                                    if (!isset($k[$days[$j]]))
                                                                        $k[$days[$j]] = 0;
                                                                @endphp

                                                                @if ($op_hours->isOpenOn($days[$j]))
                                                                    @if (array_key_exists(strtolower($days[$j]), $availability) ? (in_array($data['available_hours'][$i], $availability[strtolower($days[$j])]) ? true : ((isset($availability[strtolower($days[$j])][$k[$days[$j]]]) and is_array($availability[strtolower($days[$j])][$k[$days[$j]]])) ? in_array($data['available_hours'][$i], $availability[strtolower($days[$j])][$k[$days[$j]]]) : false ) ) : false)

                                                                        @if (isset($availability[strtolower($days[$j])][$k[$days[$j]]]['status']) && !empty($availability[strtolower($days[$j])][$k[$days[$j]]]['status']))

                                                                            <td class="bg-black">
                                                                                {{-- <select name="" id="" class="form-control selectpicker">
                                                                                    @foreach ($data['list_status'] as $status)
                                                                                        <option value="" {{ $status->name == $availability[strtolower($days[$j])][$k[$days[$j]]]['status']['name'] ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                                    @endforeach
                                                                                </select> --}}
                                                                                //
                                                                            </td>
                                                                        @else
                                                                            <td class="bg-green">Libre</td>
                                                                        @endif

                                                                        @php
                                                                            $k[$days[$j]] += 1;
                                                                        @endphp

                                                                    @else
                                                                        <td class="bg-black">
                                                                            <select name="" id="" class="form-control" style="max-width: 100%; max-height: 100%">
                                                                                @foreach ($data['list_status'] as $status)
                                                                                    <option value="{{ $status->name }}">{{ $status->name }}</option>
                                                                                @endforeach
                                                                            </select>

                                                                        </td>
                                                                    @endif
                                                                @else
                                                                <td class="bg-black">
                                                                    {{-- <select name="" id="" class="form-control selectpicker">
                                                                        @foreach ($data['list_status'] as $status)
                                                                            <option value="{{ $status->name }}">{{ $status->name }}</option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    /*
                                                                </td>

                                                                @endif
                                                            @endfor
                                                        </tr>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < count($data['available_hours']); $i++)
                                                        <tr class="d_height">
                                                            @for ($j = 0; $j < count($days); $j++)
                                                                <td class="bg-black">
                                                                    {{-- <select name="" id="" class="form-control">
                                                                        @foreach ($data['list_status'] as $status)
                                                                            <option value="{{ $status->name }}">{{ $status->name }}</option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                    ///
                                                                </td>
                                                            @endfor

                                                        </tr>
                                                    @endfor

                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                            <!-- Basic info -->

                        </div>

                    </div>
                </div>
            </div>
            <!-- /Row -->

        </div>
    </div>
</div>
</section>

@endsection


@section('styles')
    <style>
        .dtl-section {
            padding-top: 15px;
        }
        .dtl-list ul {
            list-style: none;
            padding-left: 0
        }
        .dtl-list ul li {
            display: inline-block;
        }
        .dtl-list ul li:not(:first-child) {
            margin-left: 10px
        }

        .coordinates ul li{
            margin-bottom: 10px
        }

        .coordinates .social li{
            display: inline-block;
        }

        .table-container{
            width: 100%;
            display: block;
            position: relative;
            height: 780px;
        }

        @media (max-width: 1140px) {
            .table-container .hours-tbl{
                width: 20% !important
            }
        }
        .table-container .hours-tbl{
            width: 15%;
            position: absolute;
            left: 0;
            bottom: 0;
            top: 11%;
        }
        .table-container .days-tbl{
            width: 85%;
            position: absolute;
            max-height: 100%;
            right: 0;
            bottom: 0;
            top: 0;
        }
        .table-container .days-tbl tbody{
            color: #fff
        }

        .bg-green{
            background-color: forestgreen
        }
        .bg-danger {
            background-color: orangered
        }
        .bg-yellow {
            background-color: orange
        }
        .bg-black {
            background-color: #000
        }
    </style>
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
        // Set equivalent height to tr (s)
        $('tr.h_height').css('height', $('tr.d_height').height() + 'px');
        $(document).on('click', '', function() {

        });
    });
</script>
@endsection

@php
    use Spatie\OpeningHours\OpeningHours;
    $user = $data['user'];
@endphp

@extends('backend.layouts.master')

@section('content')
    <a href="{{ route('backend.teachers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Profile</h5>

            <div class="form-row">
                {{-- <input type="hidden" name="profile_type_id" value="{{ $user->profile_type_id }}"> --}}
                <div class="mr-3">
                    <img class="rounded-circle" src="{{ !empty($user->picture) ? asset($user->picture) : asset('backend/assets/images/avatars/default.jpg') }}" alt="" width=150>
                </div>
                    <div class="col-md-6 dtl-section">
                        <h4>{{ $user->full_name }}</h4>
                        @foreach ($user->teacher->modules as $module)
                            <div class="mb-2 mr-2 badge badge-alternate">{{ $module->name }}</div>
                        @endforeach
                        <p>{{ $user->address }}</p>
                        <div class="dtl-list">
                            <ul>
                                <li><b>{{ $user->credit }}</b> Credit</li>
                                <li><b>{{ $user->total_hours }}</b> Heures enseignées</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3 pl-3">
                    <div>
                        <h5>Description</h5>
                        <p>{{ !empty($user->teacher->desc) ? $user->teacher->desc : '' }}</p>
                    </div>
                    <div class="coordinates">
                        <h5>Cordonnées</h5>
                        <ul>
                            <li><strong>E-mail: </strong> {{ $user->email }}</li>
                            <li><strong>Telephone: </strong> {{ $user->tel }}</li>
                        </ul>

                        @if ($user->contacts->isNotEmpty())
                            <ul class="social" style="list-style: none">
                                @foreach ($user->contacts as $contact)
                                    @switch($contact->contact_type->name)
                                        @case('facebook')
                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-facebook-square"></i> Facebook</a> </li>
                                            @break
                                        @case('twitter')
                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-twitter"></i> Twitter</a> </li>
                                            @break
                                        @case('instagram')
                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-alternate btn-sm"><i class="fa fa-instagram"></i> Instagram</a> </li>
                                            @break
                                        @case('youtube')
                                            <li><a href="{{ $contact->content }}" target="_blank" class="btn btn-alternate btn-sm"><i class="fa fa-youtube-play"></i> Youtube</a> </li>
                                            @break
                                        @default
                                    @endswitch
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="form-row mt-3 pl-3">
                    <h4>Table de disponibilité </h4>
                    <div class="table-container">
                        <table class="table table-striped table-bordered hours-tbl">
                            <tbody>
                                @for ($i = 0; $i < count($data['available_hours']); $i++)
                                    <tr>
                                        <td>{{ $data['available_hours'][$i] }}</td>
                                    </tr>
                                @endfor

                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered days-tbl">
                            <thead>
                                <th>Sat</th>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thur</th>
                                <th>Fri</th>
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

                                                            @switch($availability[strtolower($days[$j])][$k[$days[$j]]]['status']['name'])
                                                                @case("available")
                                                                    <td class="bg-green">Disponible</td>
                                                                    @break
                                                                @case("session")
                                                                    <td class="bg-blue">Séance</td>
                                                                    @break
                                                                @case("occupied")
                                                                    <td class="bg-gray">Occupé</td>
                                                                    @break
                                                                @case("not_decised")
                                                                    <td class="bg-yellow">Pas de décision</td>
                                                                    @break
                                                                @default
                                                                <td class="bg-green">/Libre</td>
                                                            @endswitch
                                                        @else
                                                            <td class="bg-green">Libre</td>
                                                        @endif

                                                        @php
                                                            $k[$days[$j]] += 1;
                                                        @endphp

                                                    @else
                                                        <td class="bg-danger">/</td>
                                                    @endif
                                                @else
                                                    <td class="bg-danger">/</td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endfor
                                @else
                                    @for ($i = 0; $i < count($data['available_hours']); $i++)
                                        <tr>
                                            @for ($j = 0; $j < count($days); $j++)
                                                <td class="bg-danger text-center">/</td>
                                            @endfor
                                        </tr>
                                    @endfor

                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
            height: 500px;
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
            top: 10%;
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
        .bg-blue {
            background-color: cornflowerblue
        }
        .bg-yellow {
            background-color: orange
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

@endsection

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
                        <div class="mb-2 mr-2 badge badge-alternate">{{ $user->student->study_year->name }}</div>
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
                    <div class="coordinates">
                        <h5>Cordonnées</h5>
                        <ul>
                            <li><strong>E-mail: </strong> {{ $user->email }}</li>
                            <li><strong>Telephone: </strong> {{ $user->tel }}</li>
                        </ul>

                        @if ($user->contacts->isNotEmpty())
                            <ul class="social" style="list-style: none">
                                @switch($user->contact->contact_type->name)
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
                            </ul>
                        @endif
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

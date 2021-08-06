
@extends('backend.layouts.master')

@section('content')
<div class="main-card mb-3 card">

    <div class="card-header">Liste des Séances</div>
    <div class="table-responsive">
        <table class="align-middle mb-0 table table-borde rless table-striped table-hover">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Titre</th>
                <th>Lien de Meeting</th>
                <th>Date/Heure</th>
                <th>Module</th>
                <th class="text-center">Niveau</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($data['list_sessions'] as $session)
                    <tr>
                        <td class="text-center text-muted">{{ $loop->index + 1 }}</td>
                        <td>
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left mr-3">
                                        <div class="widget-content-left">
                                            <img width="40" class="rounded-circle" src="{{ asset('backend/assets/images/avatars/default.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="widget-content-left flex2">
                                        <div class="widget-heading"><a href="{{ route('frontend.sessions.show', ['id' => $session->slug]) }}">{{ $session->title }}</a></div>
                                        <div class="widget-subheading opacity-7">{{ "" }}</div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td><a href="{{ $session->link }}" class="btn btn-info" target="_blank"><i class="fa fa-google"></i></a></td>
                        <td class="tex-center">{{ $session->date .' '. $session->hour_from }}</td>
                        <td class="tex-center">{{ $session->module->name }}</td>
                        <td class="tex-center">{{ $session->study_year->name }}</td>
                        @php
                            $d1 = Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->last()->hour_to);
                            $d2 = Carbon::createFromFormat('Y-m-d H:i', $session->date .' '. $session->periods->first()->hour_from);
                            $now = Carbon::now();
                        @endphp
                        <td class="text-center">
                            @if ($now->lte($d2))
                                <div class="badge badge-primary">En attente</div>
                            @elseif ($now->gt($d1))
                                <div class="badge badge-secondary">Passé</div>
                            @endif

                        </td>
                        <td class="text-center">

                            @if ($now->gt($d1))
                                <a href="#" class="btn btn-outline-success rounded-circle btn-sm mark-btn" data-action="mark_comp" data-sessionId="{{ $session->id }}" data-isCompleted="{{ $session->is_completed }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.mark_completed') }}"><i class="fa fa-check"></i></a>
                            @endif
                            @if ($now->lt($d2))

                                <a href="#" class="btn btn-outline-danger rounded-circle btn-sm mark-btn" data-action="mark_canc" data-sessionId="{{ $session->id }}" data-isCompleted="{{ $session->is_canceled }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.mark_canceled') }}"><i class="fa fa-times"></i></a>
                                <a href="{{ route('backend.sessions.edit', ['id' => $session->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
                            @endif

                            <a href="{{ route('backend.sessions.edit', ['id' => $session->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
                            {{-- <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal"  data-placement="top" title="Bloquer"><i class="fa fa-trash"></i></a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-block text-center card-footer">

    </div>
</div>

@endsection

@section('styles')
    <style>
        .btn-warning {
            background-color: orangered;
            border-color: orangered;
            color: #fff
        }
        .btn-warning:hover {
            background-color: orangered;
            border-color: orangered;
            color: #fff
        }

        .custom-control {
            display: inline-block;
            cursor: pointer;
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
            $('a.mark-btn').one('click', function(e) {
                action = $(this).attr('data-action');
                isCompleted = $(this).attr('data-isCompleted');
                sessionId = $(this).attr('data-sessionId');

                if(window.confirm(action == "mark_comp" ? '{{ trans("confirmations.mark_comp") }}' : '{{ trans("confirmations.mark_canc") }}')) {

                    // Start AJAX Request
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    if (action == "mark_comp")
                    {
                        route    = "{{ route('frontend.profile.sessions.markAsCompleted', ['id' => 'sessionID']) }}".replace('sessionID', sessionId);
                        method   = 'POST';
                        newClass = isCompleted ? 'btn-outline-success' : 'btn-success';

                    }
                    else if (action == "mark_canc")
                    {
                        route    = "{{ route('frontend.profile.sessions.markAsCanceled', ['id' => 'sessionID']) }}".replace('sessionID', sessionId);
                        method   = 'POST';
                        newClass = isCompleted ? 'btn-outline-danger' : 'btn-danger';
                    }

                    // Ajax Request
                    $.ajax({
                        url: route,
                        method: method,
                        data: {
                            "_token": "{{ csrf_token() }}"
                        }
                    })
                    .done(function(response) {
                        if (response.success) {
                            setTimeout(function(){ location.reload(); }, 3000);

                            new Noty({
                                type: 'success',
                                theme: 'sunset',
                                text: response.message
                            }).show();
                        }
                        else if (response.success == 0) {
                            new Noty({
                                type: 'error',
                                theme: 'sunset',
                                text: response.message
                            }).show();
                        }
                    })
                    .error(function() {
                        new Noty({
                                type: 'error',
                                theme: 'sunset',
                                text: "Un erreur est survenue"
                            }).show();
                    })

                }else{
                    e.preventDefault();
                }
            });
        });
    </script>

@endsection

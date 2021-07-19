
@extends('backend.layouts.master')

@section('content')
<div class="main-card mb-3 card">

    <div class="card-header">Liste des Enseignants</div>
    <div class="table-responsive">
        <table class="align-middle mb-0 table table-borde rless table-striped table-hover">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Nom complet</th>
                <th class="text-center">Email</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($data['list_teachers'] as $user)
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
                                        <div class="widget-heading"><a href="{{ route('backend.teachers.show', ['id' => $user->id]) }}">{{ $user->full_name }}</a></div>
                                        <div class="widget-subheading opacity-7">{{ $user->profile_type->name }}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">{{ $user->email }}</td>

                        <td class="text-center">
                            <a href="{{ route('backend.sessions.getCompletedSessions', ['id' => $user->teacher->id]) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Voir les séances terminées"><i class="fa fa-calendar-check-o"></i></a>
                            <a href="{{ route('backend.sessions.getCanceledSessions', ['id' => $user->teacher->id]) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Voir les séances annulées"><i class="fa fa-calendar-times-o"></i></a>
                            <a href="{{ route('backend.sessions.index', ['id' => $user->teacher->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Voir les séances"><i class="fa fa-arrow-right"></i></a>
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
        /*
        *
        * ==========================================
        * CUSTOM UTIL CLASSES
        * ==========================================
        *
        */
        /* toggle switches with bootstrap default colors */
        .custom-control-input-success:checked ~ .custom-control-label::before {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .custom-control-input-danger:checked ~ .custom-control-label::before {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .custom-control-input-warning:checked ~ .custom-control-label::before {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
        }

        .custom-control-input-info:checked ~ .custom-control-label::before {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }

        /* Large toggl switches */
        .custom-switch-lg .custom-control-label::before {
            left: -2.25rem;
            width: 3rem;
            border-radius: 1.5rem;
        }

        .custom-switch-lg .custom-control-label::after {
            top: calc(.25rem + 3px);
            left: calc(-2.25rem + 4px);
            width: calc(1.5rem - 6px);
            height: calc(1.5rem - 6px);
            border-radius: 1.5rem;
        }

        .custom-switch-lg .custom-control-input:checked ~ .custom-control-label::after {
            transform: translateX(1.4rem);
        }

        .custom-switch-lg .custom-control-label::before {
            height: 1.5rem;
        }

        .custom-switch-lg .custom-control-label {
            padding-left: 1.5rem;
            line-height: 1.7rem;
        }

        /*
        *
        * ==========================================
        * FOR DEMO PURPOSE
        * ==========================================
        *
        */
        body {
            min-height: 100vh;
            background: #121618;
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


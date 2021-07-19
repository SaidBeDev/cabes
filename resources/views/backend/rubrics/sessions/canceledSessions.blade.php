
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
                <th>Date/Heure</th>
                <th>Module</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($data['list_sessions'] as $sessions)
                @php
                    $session = $sessions->first();
                @endphp
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
                                        <div class="widget-heading"><a href="{{ route('backend.sessions.show', ['id' => $session->id]) }}">{{ $session->title }}</a></div>
                                        <div class="widget-subheading opacity-7">{{ "" }}</div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="tex-center">{{ $session->date .' '. $session->hour_from }}</td>
                        <td class="tex-center">{{ $session->module->name }}</td>
                        <td class="tex-center">{{ $session->study_year->name }}</td>
                        <td class="text-center">
                            <div class="badge badge-danger">َAnnulé</div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('backend.sessions.show', ['id' => $session->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Consulter"><i class="fa fa-arrow-right"></i></a>
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
@endsection

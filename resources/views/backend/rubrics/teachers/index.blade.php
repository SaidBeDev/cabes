
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
                <th class="text-center">Ville</th>
                <th class="text-center">Status</th>
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
                        <td class="text-center">{{ $user->commune->name . ', ' . $user->commune->daira->wilaya->name }}</td>
                        {{-- <td class="text-center">
                            <div class="badge badge-warning">Pending</div>
                        </td> --}}
                        <td class="text-center">
                            <a href="#" class="btn {{ $user->teacher->is_checked == 1 ? 'btn-success' : 'btn-secondary' }} btn-sm rounded-circle status" data-userId="{{ $user->teacher->id }}" data-isChecked={{ $user->teacher->is_checked }}><i class="fa fa-{{ $user->teacher->is_checked == 1 ? 'check' : 'ban' }}"></i></a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('backend.teachers.editCredit', ['id' => $user->id]) }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier le credit"><i class="fa fa-plus"></i></a>
                            <a href="{{ route('backend.teachers.editHourPrices', ['id' => $user->id]) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Modifier le prix unitaire"><i class="fa fa-clock"></i></a>
                            <a href="{{ route('backend.teachers.edit', ['id' => $user->id]) }}" data-userId="{{ $user->id }}" class="btn btn-primary btn-sm edit" data-toggle="tooltip" data-placement="top" title="Modifier"><i class="fa fa-edit"></i></a>
                            {{-- <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal"  data-placement="top" title="Bloquer"><i class="fa fa-trash"></i></a> --}}
                            <div style="display: inline-block; cursor: pointer" data-toggle="tooltip" data-placement="top" title="Bloquer">
                                <p class="custom-control custom-switch custom-switch-lg m-0">
                                    <input data-userId={{ $user->id }} data-isBlocked={{ $user->is_blocked }} class="custom-control-input custom-control-input-danger block" id="customSwitch{{ $user->id }}" type="checkbox" {{ $user->is_blocked == 1 ? "checked" : "" }}>
                                    <label class="custom-control-label font-italic" for="customSwitch{{ $user->id }}"></label>
                                </p>
                            </div>
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
    @include('frontend._partials.notif')


    <script>

        $(document).ready(function() {

            $('input.block').click(function(e) {

                msg = $(this).attr('data-isBlocked') == "0" ? 'Voulez vous vraiment bloquer ce compte?' : 'Voulez vous vraiment débloquer ce compte?';
                status = window.confirm(msg);

                console.log(status === 'true' ? 'is true' : 'is false');
                if(status === 'true') {
                    elem      = $(this);
                    userId  = elem.attr('data-userId');
                    isBlocked = elem.attr('data-isBlocked') == 1 ? 0 : 1;

                    // CSRF TOKEN Setup
                    jQuery.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });

                    // Ajax requests
                    $.ajax({
                        url: "{{ route('backend.teachers.toggleBlock', ['id' => 'userID']) }}".replace('userID', userId),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            is_blocked: isBlocked
                        }
                    }).done(function(response) {
                        if (response.success) {
                            elem.attr('data-isBlocked', isBlocked);

                            new Noty({
                                timeout: 5000,
                                progressBar: true,
                                type: 'success',
                                theme: 'sunset',
                                text: response.message
                            }).show();
                        }
                    }).fail(function(response) {
                        new Noty({
                            timeout: 5000,
                            progressBar: true,
                            type: 'error',
                            theme: 'sunset',
                            text: response.message
                        }).show();
                    });
                } else {
                    e.preventDefault();
                    return false;
                }
            });

            $(document).on('click', 'a.status', function(e) {
                e.preventDefault();

                elem = $(this);
                userId  = elem.attr('data-userId');
                isChecked = elem.attr('data-isChecked') == "1" ? 0 : 1;
                oldClass = isChecked == 0 ? 'btn-success' : 'btn-secondary';
                newClass = isChecked == 1 ? 'btn-success' : 'btn-secondary';
                oldIcon = isChecked == 0 ? 'fa-check' : 'fa-ban';
                newIcon = isChecked == 1 ? 'fa-check' : 'fa-ban';

                // CSRF TOKEN Setup
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                // Ajax requests
                $.ajax({
                    url: "{{ route('backend.teachers.toggleCheck', ['id' => 'userID']) }}".replace('userID', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_checked: isChecked
                    }
                }).done(function(response) {
                    if (response.success) {
                        elem.attr('data-isChecked', isChecked);
                        elem.removeClass(oldClass).addClass(newClass);

                        elem.children('i').removeClass(oldIcon).addClass(newIcon);
                        new Noty({
                            timeout: 5000,
                            progressBar: true,
                            type: 'success',
                            theme: 'sunset',
                            text: response.message
                        }).show();
                    }else {
                        new Noty({
                            timeout: 5000,
                            progressBar: true,
                            type: 'error',
                            theme: 'sunset',
                            text: response.message
                        }).show();
                    }
                }).fail(function(response) {
                    new Noty({
                        timeout: 5000,
                        progressBar: true,
                        type: 'error',
                        theme: 'sunset',
                        text: response.message
                    }).show();
                });
            });
        });

    </script>
@endsection

{{-- Modals --}}
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Voulez-vous vraiment supprimer ce compte?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <a href="{{ route('admin.users.destroy', ['id' => $teacher->id]) }}" class="btn btn-danger btn-sm">Supprimer</a>
            </div>
        </div>
    </div>
</div> --}}

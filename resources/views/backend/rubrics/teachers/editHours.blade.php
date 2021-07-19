@php
    $user = $data['user'];
@endphp

@extends('backend.layouts.master')

@section('content')
    <a href="{{ route('backend.teachers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Modifier le prix unitaire (Credit / Par Heure)</h5>

            <div class="form-row">
                {{-- <input type="hidden" name="profile_type_id" value="{{ $user->profile_type_id }}"> --}}

                <div class="col-md-4">
                    <label for="validationCustom02" class="d-block">Prix d'Heure</label>
                    <input type="text" name="credit" class="form-control d-inline-block credit" style="width: 80%" id="validationCustom02" value="{{ $user->teacher->hour_price }}" required="">
                    <a href="#" class="btn btn-success change" data-mode="hour" data-userId={{ $user->teacher->id }}><i class="fa fa-check"></i></a>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="validationCustom01" class="d-block">Prix de Séance</label>
                    <input type="text" name="credit" class="form-control d-inline-block credit" style="width: 80%" id="validationCustom01" value="{{ $user->teacher->group_price }}" required="">
                    <a href="#" class="btn btn-success change" data-mode="group" data-userId={{ $user->teacher->id }}><i class="fa fa-check"></i></a>
                </div>
            </div>
        </div>
    </div>
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
            /* Change Price */
            $('a.change').click(function() {

                elem = $(this);
                mode = elem.attr('data-mode');
                input = $(this).siblings('input');
                userId = elem.attr('data-userId');


                switch (mode) {
                    case "hour":
                        url = "{{ route('backend.teachers.changeHourlyPrice', ['id' => 'userID']) }}".replace('userID', userId);
                        data = {
                            _token: '{{ csrf_token() }}',
                            hour_price: input.val()
                        };
                        break;
                    case "group":
                        url = "{{ route('backend.teachers.changeGroupPrice', ['id' => 'userID']) }}".replace('userID', userId);
                        data = {
                            _token: '{{ csrf_token() }}',
                            group_price: input.val()
                        };
                        break;
                }

                console.log(data);

                // CSRF TOKEN Setup
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                // Ajax requests
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data
                }).done(function(response) {
                    if (response.success) {
                        new Noty({
                            timeout: 5000,
                            progressBar: true,
                            type: 'success',
                            theme: 'sunset',
                            text: response.message
                        }).show();
                    }
                    if (!response.success) {
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

@php
    $user = $data['teacher'];
@endphp

@extends('backend.layouts.master')

@section('content')
    <a href="{{ route('backend.teachers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Modifier le crédit de l'enseignant</h5>

            <div class="form-row">

            </div>
            <div class="form-row">
                <input type="hidden" name="profile_type_id" value="{{ $user->profile_type_id }}">

                <div class="col-md-6">
                    <h5>Dernier Credit:</h5>
                    <a href="#" class="btn btn-info">{{ $user->credit }}</a>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="validationCustom01" class="d-block">Credit</label>
                    <input type="text" name="credit" class="form-control d-inline-block price" style="width: 80%" id="validationCustom01" value="{{ $user->credit }}" required="">
                    <a href="#" class="btn btn-success price" data-userId={{ $user->id }}><i class="fa fa-check"></i></a>
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
            $('a.price').click(function() {

                elem = $(this);
                input = $('input.price');
                userId = elem.attr('data-userId');

                // CSRF TOKEN Setup
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                // Ajax requests
                $.ajax({
                    url: "{{ route('backend.teachers.changeCredit', ['id' => 'userID']) }}".replace('userID', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        credit:  input.val()
                    }
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

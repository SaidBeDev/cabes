
@extends('backend.layouts.master')

@section('content')
    <a href="{{ route('backend.teachers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Configuration</h5>

            @foreach ($data['list_configs'] as $config)
                <div class="form-row">
                    <div class="col-md-6">
                        <h5>{{ trans('config.' . $config->name) }}</h5>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="content" class="form-control d-inline-block config" style="width: 80%" id="validationCustom01" value="{{ $config->content }}" required="">
                        <a href="#" class="btn btn-success config" data-configId={{ $config->id }}><i class="fa fa-check"></i></a>
                    </div>
                </div>
            @endforeach
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
            $(document).on('click', 'a.config', function() {

                elem = $(this);
                input = $(this).siblings('input');
                configId = elem.attr('data-configId');

                // CSRF TOKEN Setup
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                // Ajax requests
                $.ajax({
                    url: "{{ route('backend.configs.update', ['id' => 'userID']) }}".replace('userID', configId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        content:  input.val()
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

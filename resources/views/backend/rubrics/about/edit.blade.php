
@php
    $article = $data['article'];
@endphp

@extends('backend.layouts.master')

@section('content')

    <a href="#" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title"><i class="fa fa-cogs"></i> Modifier les informations de page "{{ trans('menu.about') }}"</h5>
            {!! Form::open([
                'method' => 'PUT',
                'url' => route('backend.about.update'),
                'name' => 'profile',
                'id' => 'profile',
                'files' => true
            ]) !!}

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

                {{-- Image --}}
                <div class="form-row">
                    <div class="col-md-12">
                        <h2 class="mb-3 mt-3">Image</h2>
                    </div>

                    <div class="col-md-6">
                        <a href="#" id="opImg"><img id="blah" style="max-width: 100%; max-height: 485px" src="{{ asset(config('SaidTech.images.about.upload_path') . $article->image) }}" alt=""></a>
                    </div>
                    <div class="col-md-6" style="visibility: hidden">
                        <input type="file" name="image" accept="image/*" id="imgInp">
                    </div>
                </div>
                {{-- Francais --}}
                <div class="form-row">

                    <h2 class="mb-3 mt-3">Français</h2>

                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Titre (Fr)</label>
                        <input type="text" name="name_fr" class="form-control" id="validationCustom01" value="{{ $article->translate('fr')->name }}" placeholder="Titre" required>

                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustomUsername">Description (Fr)</label>
                        <div class="input-group">
                            <textarea name="desc_fr" id="" rows="10" class="form-control">{{ $article->translate('fr')->desc }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom04">Detail (Fr)</label>
                        <div class="input-group">
                            <textarea name="detail_fr" id="" rows="10" class="form-control">{{ $article->translate('fr')->detail }}</textarea>
                        </div>
                    </div>
                </div>


                <div class="divider"></div>
                {{-- Arabic --}}
                <div class="form-row">
                    <h2 class="mb-3 mt-3">Arabic</h2>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Titre (Ar)</label>
                        <input type="text" name="name_ar" class="form-control" id="validationCustom01" value="{{ $article->translate('ar')->name }}" placeholder="Titre" required>

                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustomUsername">Description (Ar)</label>
                        <div class="input-group">
                            <textarea name="desc_ar" id="" cols="50" rows="10" class="form-control" dir="rtl">{{ $article->translate('ar')->desc }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom04">Detail (Ar)</label>
                        <div class="input-group">
                            <textarea name="detail_ar" id="" rows="10" class="form-control" dir="rtl">{{ $article->translate('ar')->detail }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        {!! Form::close() !!}
    </div>

    <button class="btn btn-primary mb-5" type="submit" form="profile">Enregistrer</button>

@endsection

@section('styles')
    <style>
        textarea {
            width: 100%
        }
    </style>
@endsection

@section('scripts')
    @include('frontend._partials.notif')

    {!! $data['validator']->selector('profile') !!}

    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }

        $(document).ready(function() {
            $('#opImg').on('click', function(e) {
                e.preventDefault();

                $('#imgInp').click();
            });
        });
    </script>
@endsection

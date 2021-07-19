
@php
$user = $data['user'];
@endphp

@extends('backend.layouts.master')

@section('content')
    <a href="{{ route('backend.students.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
    <div class="main-card mb-3 card">
        <div class="card-body">
            <h5 class="card-title">Informations en tant que utilisateur</h5>
            {!! Form::open([
                'method' => 'PUT',
                'url' => route('backend.students.update', ['id' => $user->id, 'profileId' => $user->student->id]),
                'name' => 'profile',
                'id' => 'profile'
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

                <div class="form-row">
                    <input type="hidden" name="profile_type_id" value="{{ $user->profile_type_id }}">

                    <div class="col-md-4 mb-3">
                        <label for="validationCustom01">Nom complet</label>
                        <input type="text" name="full_name" class="form-control" id="validationCustom01" value="{{ $user->full_name }}" placeholder="Nom complet" required="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="validationCustomUsername">E-mail</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                            </div>
                            <input type="text" name="email" class="form-control" id="validationCustomUsername" value="{{ $user->email }}" placeholder="example@domaine.com" aria-describedby="inputGroupPrepend" required="" disabled>

                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="validationCustom04">N° Telephone</label>
                        <input type="text" name="tel" class="form-control" value="{{ $user->tel }}" id="validationCustom04" placeholder="055329841" required="">
                    </div>
                </div>

                <div class="form-row">
                    {{-- <div class="col-md-3 mb-3">
                        <label for="validationCustom02">Mot de passe</label>
                        <input type="text" name="password" class="form-control" id="validationCustom02" placeholder="Mot de passe">
                    </div> --}}

                    <div class="col-md-4 mb-3">
                        <label for="validationCustom03" style="display: block">Ville/Wilaya</label>
                        <select name="daira_id" class="daira-select form-control selectpicker" data-live-search="true"  data-style="btn-info" data-width="auto">
                            @foreach ($data['list_wilayas'] as $wilaya)
                                <optgroup label="{{ $wilaya->name }}">
                                    @foreach ($wilaya->dairas as $daira)
                                        <option value="{{ $daira->id }}" {{ $user->daira_id == $daira->id ? 'selected' : '' }}>{{ $daira->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="validationCustom05">Adresse</label>
                        <input type="text" name="address" class="form-control" value="{{ $user->address }}" id="validationCustom05" placeholder="Adresse" required="">
                    </div>
                </div>

                <div class="form-row">

                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Informations en tant qu'étudiant</h5>
                <div class="form-row">

                    <div class="col-md-4 mb-3">
                        <label for="validationCustom01" style="display: block">Niveau d'étude</label>
                        <select name="study_year_id" class="module-select form-control selectpicker" data-style="btn-info" data-width="auto">
                            @foreach ($data['study_years'] as $year)
                                <option value="{{ $year->id }}" {{ !empty($user->student->study_year) ? ($user->student->study_year_id == $year->id ? 'selected' : '') : 1 }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

    <button class="btn btn-primary mb-1" type="submit" form="profile">Enregistrer</button>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.daira-select').change(function() {
                $(this).selectpicker('destroy');
                $(this).selectpicker('show');
                $('.daira-select').selectpicker({
                    'dropupAuto': false
                });
            });

        });
    </script>
@endsection


@php
$user = $data['user'];
@endphp

@extends('backend.layouts.master')

@section('content')
<a href="{{ route('backend.teachers.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ trans('frontend.back') }}</a>
<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Informations en tant que utilisateur</h5>
        {!! Form::open([
            'method' => 'PUT',
            'url' => route('backend.teachers.update', ['id' => $user->id, 'profileId' => $user->teacher->id]),
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

                    <select name="commune_id" class="daira-select form-control selectpicker" data-live-search="true" data-width="auto">
                        @foreach ($data['list_dairas'] as $daira)
                            <optgroup label="{{ $daira->name }}">
                                @foreach ($daira->communes as $commune)
                                    <option value="{{ $commune->id }}" {{ (!empty($user->commune->id) and $user->commune->id == $commune->id) ? 'selected' : '' }}>{{ $commune->name }}</option>
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
            <h5 class="card-title">Informations en tant qu'enseignant</h5>
            <div class="form-row">

                <div class="col-md-12 mb-3">
                    <label for="validationCustom01">Description</label>
                    <textarea name="desc" class="form-control" rows="5">{{ $user->teacher->desc }}</textarea>
                </div>

                <div class="form-group col-md-6 teacher">
                    <label for="">{{ trans('frontend.diploma') }}</label>
                    <input type="text" name="diploma" class="form-control" value="{{ $user->teacher->diploma }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="validationCustom01" style="display: block">Module</label>
                    <select name="module_id[]" class="module-select form-control selectpicker" multiple data-style="btn-info" data-width="auto">
                        @foreach ($data['spec_modules'] as $module)
                            <option style="font-weight: bold" value="{{ $module->id }}" {{ !empty($user->teacher->modules) ? ($user->teacher->modules->contains($module) ? 'selected' : '') : 1 }}>{{ $module->name }}</option>
                        @endforeach
                        @foreach ($data['list_modules'] as $module)
                            <option value="{{ $module->id }}" {{ !empty($user->teacher->modules) ? ($user->teacher->modules->contains($module) ? 'selected' : '') : 1 }}>{{ $module->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6 teacher">
                    <label for="" class="d-block">{{ trans('frontend.teaching_years'). ' '. trans('frontend.multiple') }}</label>
                    <select name="teaching_years[]" class="module-select form-control selectpicker" multiple data-width="auto" required>
                        @foreach ($data['spec_years'] as $year)
                            <option style="font-weight: bold" value="{{ $year->id }}" {{ !empty($user->teacher->teaching_years) ? ($user->teacher->teaching_years->contains($year) ? 'selected' : '') : 1 }}>{{ $year->name }}</option>
                        @endforeach
                        @foreach ($data['study_years'] as $year)
                            <option value="{{ $year->id }}" {{ !empty($user->teacher->teaching_years) ? ($user->teacher->teaching_years->contains($year) ? 'selected' : '') : 1 }}>{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6 teacher">
                    <label for="">{{ trans('frontend.experience_nb') }}</label>
                    <input type="number" name="experience" class="form-control" value="{{ $user->teacher->experience }}">
                </div>
                <div class="form-group col-md-6 teacher">
                    <label for="">{{ trans('frontend.present_video') }}</label>
                    <input type="text" name="video_link" class="form-control" value="{{ $user->teacher->video_link }}">
                </div>

                <div class="form-group col-md-6 teacher">
                    <label for="">{{ trans('frontend.port_link'). ' '. trans('frontend.optional') }}</label>
                    <input type="text" name="portfolio" class="form-control" value="{{ $user->teacher->portfolio }}">
                </div>

                <div class="form-group col-md-6 teacher">
                    <label for="" class="d-block">{{ trans('frontend.sector'). ' '. trans('frontend.multiple') }}</label>
                    <select name="sector[]" class="module-select form-control selectpicker" multiple data-width="auto" required>
                        @foreach ($data['list_sectors'] as $sector)
                            <option value="{{ $sector->id }}" {{ !empty($user->teacher->sectors) ? ($user->teacher->sectors->contains($sector) ? 'selected' : '') : 1 }}>{{ $sector->name }}</option>
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

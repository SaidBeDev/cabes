
@php
    $user = $data['user'];

    $profileId = $user->profile_type->name == "teacher" ? $user->teacher->id : $user->student->id;

    if (!empty($user->contacts)) {
        foreach ($user->contacts as $contact) {
            switch ($contact->contact_type->name) {
                case 'facebook':
                    $facebook = $contact->content;
                    break;
                case 'linkedin':
                    $linkedin = $contact->content;
                    break;
                case 'viber':
                    $viber = $contact->content;
                    break;
                case 'whatsapp':
                    $whatsapp = $contact->content;
                    break;
            }
        }
    }
@endphp

@extends('frontend.layouts.master')

@section('content')

<section class="gray pt-0">
    <div class="container-fluid">

        <!-- Row -->
        <div class="row">
            @include('frontend.rubrics.profile.__partials.aside')


            <div class="col-lg-9 col-md-9 col-sm-12">

                {{-- Breadcrumbs --}}
                {!! Breadcrumbs::render('setting') !!}

                <!-- Row -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="dashboard_container">
                            <div class="dashboard_container_header">
                                <div class="dashboard_fl_1">
                                    <h4 class="uc"><i class="fa fa-cogs"></i> {{ trans('frontend.mng_profile') }}</h4>
                                </div>
                            </div>
                            <div class="dashboard_container_body p-4">
                                <!-- Basic info -->
                                <div class="submit-section">
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

                                    {!! Form::open([
                                        'method' => 'PUT',
                                        'url' => route('frontend.profile.update', ['id' => $user->id, 'profileId' => $profileId]),
                                        'files' => true,
                                        'name' => 'register',
                                        'id' => 'register'
                                    ]) !!}

                                    {{-- <div class="form-row mb-3">
                                        <div class="col-md-12">
                                            <h6>{{ trans('frontend.profile_pic') }}</h6>
                                            <img src="{{ !empty(Auth::user()->picture) ? asset(config('SaidTech.images.profile.upload_path') . Auth::user()->picture) : 'https://via.placeholder.com/80x80' }}" id="preview" class="img-thumbnail">
                                        </div>
                                        <div class="col-md-4">
                                            <div id="msg"></div>
                                            <input type="file" name="image" class="file" accept="image/*" style="visibility: hidden">
                                            <div class="input-group my-3">
                                                <input type="text" class="form-control" disabled placeholder="Upload File" id="file">
                                                <div class="input-group-append">
                                                    <button type="button" class="browse btn btn-primary">{{ trans('frontend.browse') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="form-row mb-3">

                                        <div class="col-md-4">
                                            <label for="">{{ ucfirst(trans('frontend.avatar')) }}</label>
                                            <select name="avatar" class="selectpicker">
                                                @foreach ($data['list_avatars'] as $avatar)
                                                    <option value="{{ $avatar['uri'] }}" {{ $user->avatar == $avatar['uri'] ? 'selected' : '' }} data-content="<img height=30 src='{{ asset('frontend/images/avatars/' .$avatar['uri']) }}' /> <span class=''>{{  trans('frontend.avatar') .' '. $avatar['id'] }}</span>">{{ $avatar['uri'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-row">

                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.full_name') }}</label>
                                            <input type="hidden" name="profile_type_id" value="{{ $user->profile_type->id }}">
                                            <input type="text" name="full_name" class="form-control" value="{{ $user->full_name }}" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.email') }}</label>
                                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <input type="checkbox" name="is_new_password" class="new_pass_check" id="chk">
                                            <label class="f_low" for="chk"><strong>{{ trans('frontend.change_password') }}</strong></label>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="f_low">{{ trans('frontend.old_password') }}</label>
                                            <input type="password" name="old_password" class="form-control" disabled>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="f_low">{{ trans('frontend.new_password') }}</label>
                                            <input type="password" name="new_password" class="form-control" disabled>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.tel') }}</label>
                                            <input type="text" name="tel" class="form-control" value="{{ $user->tel }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="" class="d-block">{{ trans('frontend.city_wilaya') }}</label>
                                            <select name="commune_id" class="daira-select form-control selectpicker" data-live-search="true" data-width="auto">

                                                @foreach ($data['list_dairas'] as $daira)
                                                    <optgroup label="{{ app()->getLocale() == 'ar' ? $daira->name_ar : $daira->name }}">
                                                        @foreach ($daira->communes as $commune)
                                                            <option value="{{ $commune->id }}" {{ (!empty($user->commune->id) and $user->commune->id == $commune->id) ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? $commune->name_ar : $commune->name }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>{{ trans('frontend.address') }}</label>
                                            <input type="text" name="address" class="form-control" value="{{ $user->address }}" required>
                                        </div>

                                        <div class="form-group col-md-6"></div>

                                        @switch($user->profile_type->name)
                                            @case("teacher")
                                                {{-- Teacher's infos --}}
                                                <div class="form-group col-md-6 teacher">
                                                    <label for="">{{ trans('frontend.diploma') }}</label>
                                                    <input type="text" name="diploma" class="form-control" value="{{ $user->teacher->diploma }}">
                                                </div>

                                                <div class="form-group col-md-6 teacher">
                                                    <label for="" class="d-block">{{ trans('frontend.modules'). ' '. trans('frontend.multiple') }}</label>
                                                    <select name="module_id[]" class="module-select form-control selectpicker" multiple data-width="auto" required>
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

                                                 <div class="form-group teacher col-md-12">
                                                    <label for="">{{ trans('frontend.desc') .' '. trans('frontend.optional') }}</label>
                                                    <textarea name="desc" id="" class="form-control">{{ !empty($user->teacher->desc) ? $user->teacher->desc : '' }}</textarea>
                                                </div>
                                                @break

                                            @case("student")
                                                {{-- Student's Infos --}}
                                                <div class="form-group student">
                                                    <label for="" class="d-block">{{ trans('frontend.study_year') }}</label>
                                                    <select name="study_year_id" class="module-select form-control selectpicker" data-style="btn-info" data-width="auto">
                                                        @foreach ($data['spec_years'] as $year)
                                                            <option style="font-weight: bold" value="{{ $year->id }}" {{ !empty($user->student->study_year) ? ($user->student->study_year_id == $year->id ? 'selected' : '') : 1 }}>{{ $year->name }}</option>
                                                        @endforeach
                                                        @foreach ($data['study_years'] as $year)
                                                            <option value="{{ $year->id }}" {{ !empty($user->student->study_year) ? ($user->student->study_year_id == $year->id ? 'selected' : '') : 1 }}>{{ $year->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @break
                                            @default

                                        @endswitch


                                    </div>
                                </div>
                                <!-- Basic info -->

                                <!-- Social Account info -->
                                <div class="form-submit">
                                    <h4 class="pl-2 mt-2">{{ trans('frontend.social_accounts') }}</h4>
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label class="f_low">{{ trans('frontend.facebook') }}</label>
                                                <input type="text" name="facebook" class="form-control" value="{{ isset($facebook) ? $facebook : '' }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="f_low">{{ trans('frontend.linkedin') }}</label>
                                                <input type="text" name="linkedin" class="form-control" value="{{ isset($linkedin) ? $linkedin : '' }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="f_low">{{ trans('frontend.viber') }}</label>
                                                <input type="text" name="viber" class="form-control" value="{{ isset($viber) ? $viber : '' }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label class="f_low">{{ trans('frontend.whatsapp') }}</label>
                                                <input type="text" name="whatsapp" class="form-control" value="{{ isset($whatsapp) ? $whatsapp : '' }}">
                                            </div>

                                            <div class="form-group col-lg-12 col-md-12">
                                                <button class="btn btn-theme" type="submit"><i class="fa fa-save"></i> {{ trans('frontend.save') }}</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- / Social Account info -->

                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Row -->

            </div>
        </div>
    </div>
</section>

@endsection

@section('styles')
    <style>
        #preview {
            height: 150px;
            width: 150px
        }
        label {
            font-weight: bold
        }
        label.f_low{
            font-weight: normal
        }
    </style>
@endsection
@section('scripts')
    @include('frontend._partials.notif')

    <script>
        $(document).ready(function() {

            $(document).on('change', 'input#chk', function() {
                if ($(this).is(':checked') == 1){
                    $('input[name="old_password"], input[name="new_password"]').prop('disabled', false);
                }else {
                    $('input[name="old_password"], input[name="new_password"]').prop('disabled', true);
                }

            });


            // Image preview
            $(document).on("click", ".browse", function() {
                var file = $(this).parents().find(".file");
                file.trigger("click");
            });
            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $("#file").val(fileName);

                var reader = new FileReader();
                reader.onload = function(e) {
                    // get loaded data and render thumbnail.
                    document.getElementById("preview").src = e.target.result;
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection

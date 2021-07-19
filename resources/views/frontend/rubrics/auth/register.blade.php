
@extends('frontend.layouts.master')

@section('content')
    <section>
        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-7 col-md-9 col-sm-12">
                    <div class="log_wrap">
                        <h4>{{ trans('frontend.register_txt') }}</h4>

                        <div class="text-center">
                            <p class="mt-3">{{ trans('frontend.have_account') }} <a href="{{ route('auth.loginForm') }}" class="link">{{ trans('frontend.login') }}</a></p>
                        </div>

                        <div class="login-form">
                            {!! Form::open([
                                'method' => 'POST',
                                'url' => route('auth.register'),
                                'name' => 'register',
                                'id' => 'register'
                            ]) !!}

                                <div class="row">
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
                                    <div class="col-md-12">
                                        <label for="">{{ ucfirst(trans('frontend.avatar')) }}</label>
                                        <select name="avatar" class="selectpicker">
                                            @foreach ($data['list_avatars'] as $avatar)
                                                <option value="{{ $avatar['uri'] }}" data-content="<img height=30 src='{{ asset('frontend/images/avatars/' .$avatar['uri']) }}' /> <span class=''>{{  trans('frontend.avatar') .' '. $avatar['id'] }}</span>">{{ $avatar['uri'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('frontend.full_name') }}</label>
                                            <input type="text" name="full_name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('frontend.email') }}</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('frontend.password') }}</label>
                                    <input type="password" name="password" class="form-control" autocomplete="new-password" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('frontend.tel') }}</label>
                                    <input type="text" name="tel" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('frontend.birthday') }}</label>
                                    <input type="date" name="birthday" class="form-control" required>
                                </div>

                                {{-- Gender --}}
                                <div class="text-center">
                                    <label for="" class="d-block">{{ trans('frontend.gender') }}</label>
                                    <div class="form-check {{ app()->getLocale() == "ar" ? 'ml-3' : 'mr-3' }}" style="display: inline-block">
                                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios3" value="male" checked>
                                        <label class="form-check-label" for="exampleRadios3">
                                            <i class="fa fa-male"></i>
                                            {{ trans('frontend.male') }}
                                        </label>
                                    </div>
                                    <div class="form-check" style="display: inline-block">
                                        <input class="form-check-input" type="radio" name="gender" id="exampleRadios4" value="female">
                                        <label class="form-check-label" for="exampleRadios4">
                                            <i class="fa fa-female"></i>
                                            {{ trans('frontend.female') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="d-block">{{ trans('frontend.city_wilaya') }}</label>
                                    <select name="commune_id" class="daira-select form-control selectpicker" data-live-search="true"  data-style="btn-info" data-width="auto">

                                        @foreach ($data['list_dairas'] as $daira)
                                            <optgroup label="{{ $daira->name }}">
                                                @foreach ($daira->communes as $commune)
                                                    <option value="{{ $commune->id }}">{{ $commune->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('frontend.address') }}</label>
                                    <input type="text" name="address" class="form-control" required>
                                </div>

                                {{-- Profile Switcher --}}
                                <div class="text-center">
                                    <label for="" class="d-block">{{ trans('frontend.account_type') }}</label>
                                    <div class="form-check {{ app()->getLocale() == "ar" ? 'ml-3' : 'mr-3' }}" style="display: inline-block">
                                        <input class="form-check-input" type="radio" name="profile_type_id" id="exampleRadios1" value="2" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            <i class="fa fa-user-md"></i>
                                            {{ trans('frontend.teacher') }}
                                        </label>
                                    </div>
                                    <div class="form-check" style="display: inline-block">
                                        <input class="form-check-input" type="radio" name="profile_type_id" id="exampleRadios2" value="3">
                                        <label class="form-check-label" for="exampleRadios2">
                                            <i class="fa fa-user"></i>
                                            {{ trans('frontend.student') }}
                                        </label>
                                    </div>
                                </div>

                                {{-- Teacher's inputs --}}
                                <div class="form-group teacher">
                                    <label for="" class="d-block">{{ trans('frontend.modules') }}</label>
                                    <select name="module_id[]" class="module-select form-control selectpicker" multiple data-style="btn-info" data-width="auto">
                                        @foreach ($data['list_modules'] as $module)
                                            <option value="{{ $module->id }}" {{ $loop->index == 0 ? 'selected' : '' }}>{{ $module->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6 teacher">
                                        <label for="">{{ trans('frontend.diploma') }}</label>
                                        <input type="text" name="diploma" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6 teacher">
                                        <label for="">{{ trans('frontend.experience_nb') }}</label>
                                        <input type="number" name="experience" class="form-control">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6 teacher">
                                        <label for="">{{ trans('frontend.present_video') }}</label>
                                        <input type="text" name="video_link" class="form-control">
                                    </div>

                                    <div class="form-group col-md-6 teacher">
                                        <label for="" class="d-block">{{ trans('frontend.teaching_years'). ' '. trans('frontend.multiple') }}</label>
                                        <select name="teaching_years[]" class="module-select form-control selectpicker" multiple data-width="auto">
                                            @foreach ($data['study_years'] as $year)
                                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 teacher">
                                        <label for="" class="d-block">{{ trans('frontend.sector'). ' '. trans('frontend.multiple') }}</label>
                                        <select name="sector[]" class="module-select form-control selectpicker" multiple data-width="auto">
                                            @foreach ($data['list_sectors'] as $sector)
                                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group teacher">
                                    <label for="">{{ trans('frontend.desc') .' '. trans('frontend.optional') }}</label>
                                    <textarea name="desc" id="" class="form-control"></textarea>
                                </div>


                                {{-- Student's inputs --}}
                                <div class="form-group student">
                                    <label for="" class="d-block">{{ trans('frontend.study_year') }}</label>
                                    <select name="study_year_id" class="module-select form-control selectpicker" data-style="btn-info" data-width="auto">
                                        @foreach ($data['study_years'] as $year)
                                            <option value="{{ $year->id }}" {{ $loop->index == 8 ? 'selected' : '' }}>{{ $year->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Social accounts --}}
                                <!-- Social Account info -->
                                <div class="form-submit mt-4">
                                    <label for="" class="d-block">{{ trans('frontend.social_accounts') .' '. trans('frontend.optional') }}</label>
                                    <div class="submit-section">
                                        <div class="form-row">

                                            <div class="form-group col-md-6">
                                                <label>{{ trans('frontend.facebook') }}</label>
                                                <input type="url" name="facebook" class="form-control">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{ trans('frontend.linkedin') }}</label>
                                                <input type="url" name="linkedin" class="form-control">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{ trans('frontend.whatsapp') }}</label>
                                                <input type="text" name="whatsapp" class="form-control" placeholder="">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>{{ trans('frontend.viber') }}</label>
                                                <input type="text" name="viber" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / Social Account info -->

                                {{-- Submit button --}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md full-width pop-login">{{ trans('frontend.register_btn') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

 @section('styles')
     <style>
         label {
             font-weight: 600
         }
     </style>
 @endsection

 @section('scripts')
    {!! Html::script('vendor/jsvalidation/js/jsvalidation.min.js') !!}


     <script>
         $(document).ready(function() {
            if ($('input[name="profile_type_id"]').val() == "3") {
                $('.teacher').css('display', 'none');
                $('.student').css('display', 'block');
            }
            else if($('input[name="profile_type_id"]').val() == "2") {
                $('.teacher').css('display', 'block');
                $('.student').css('display', 'none');
            }
             $('input[name="profile_type_id"]').change(function() {
                 if ($(this).val() == "3") {
                    $('.teacher').css('display', 'none');
                    $('.student').css('display', 'block');
                 }
                 else if($(this).val() == "2") {
                    $('.teacher').css('display', 'block');
                    $('.student').css('display', 'none');
                 }

             });
         });
     </script>
 @endsection

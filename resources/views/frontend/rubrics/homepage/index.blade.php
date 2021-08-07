
@extends('frontend.layouts.master')

@section('content')

			<!-- ============================ Hero Banner  Start================================== -->
			<div class="image-cover hero_banner {{-- hero-inner-2 --}}" style="background:#7403ca;" data-overlay="0">
				<div class="container">
					<!-- Type -->
					<div class="row align-items-center">
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="banner-search-2 transparent">
								<h1 class="big-header-capt cl_2 mb-2 f_2">Se former à distance, une autre façon de goûter au plaisir d'apprendre</h1>
								<p>Choisis ton cours, ton prof préféré et travaille à ton aise!</p>
								<div class="mt-4">
									@if (empty(Auth::user()))
										<a href="{{ route('auth.registerForm') }}" class="btn btn-modern dark">{{ trans('frontend.reg_now') }}<span><i class="ti-arrow-right"></i></span></a>
									@else
										<a href="{{ route('auth.loginForm') }}" class="btn btn-modern dark">{{ trans('frontend.log_now') }}<span><i class="ti-arrow-right"></i></span></a>
									@endif
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="flixio pt-5">
                                <img class="img-fluid" src="{{ asset('frontend/assets/img/edu_2.png') }}" alt="">
                            </div>
						</div>

					</div>
				</div>
			</div>
			<!-- ============================ End Hero Banner End ================================== -->

			<!-- ============================ Trips Facts Start ================================== -->
			<div class="trips_wrap full light-colors">
				<div class="container">
					<div class="row m-0">

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="trips">
								<div class="trips_icons">
									<i class="fas fa-chalkboard-teacher"></i>
								</div>
								<div class="trips_detail">
									<h4>Formateurs qualifiés</h4>
									<p>Un accompagnement continu de nos élèves par des formateurs certifiés</p>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="trips">
								<div class="trips_icons">
									<i class="fas fa-book"></i>
								</div>
								<div class="trips_detail">
									<h4>Contenu riche</h4>
									<p>Un contenu pédagogique riche, varié et conforme aux programmes scolaires</p>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="trips none">
								<div class="trips_icons">
									<i class="fas fa-graduation-cap"></i>
								</div>
								<div class="trips_detail">
									<h4>Formations pratiques</h4>
									<p>Des formations pratiques pour développer les compétences de nos  apprenants</p>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- ============================ End Trips Facts Start ================================== -->

			<!-- ========================== Featured Category Section =============================== -->
			<section>
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-5 col-md-6 col-sm-12">
							<div class="sec-heading center">
								{{-- <p>Popular Category</p> --}}
								<h2><span class="theme-cl">{{ trans('frontend.modules') }}</span> {{ trans('frontend.famous') }}</h2>
							</div>
						</div>
					</div>

					<div class="row">
						{{-- <div class="col-lg-4 col-md-4 col-sm-6">
							<div class="edu_cat_2 cat-1">
								<div class="edu_cat_icons">
									<a class="pic-main" href="#"><img src="{{ asset('frontend/assets/img/content.png') }}" class="img-fluid" alt="" /></a>
								</div>
								<div class="edu_cat_data">
									<h4 class="title"><a href="#">Development</a></h4>
									<ul class="meta">
										<li class="video"><i class="ti-video-clapper"></i>{{ count($data['list_modules']) }} Classes</li>
									</ul>
								</div>
							</div>
						</div> --}}

                        @foreach ($data['list_modules'] as $module)
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <div class="edu_cat_2 cat-{{ $loop->index + 1 }}" style="background-color: unset{{-- $module->bg_color --}}">
                                    <div class="edu_cat_icons">
                                        <a class="pic-main" href="{{ route('frontend.teachers.getByModule', ['slug' => $module->slug]) }}"><img src="{{ asset('frontend/assets/img/' . (!empty($module->image) ? $module->image : 'briefcase.png')) }}" class="img-fluid" alt="" /></a>
                                    </div>
                                    <div class="edu_cat_data">
                                        <h4 class="title"><a href="{{ route('frontend.teachers.getByModule', ['slug' => $module->slug]) }}" style="color: #00adb6{{-- $module->color --}}">{{ ucfirst($module->name) }}</a></h4>
                                        <ul class="meta">
                                            <li class="video"><i class="ti-video-clapper"></i>{{ (!empty($module->teachers) ? $module->teachers->count() : '') .' '. trans('frontend.teacher') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
					</div>

				</div>
			</section>
			<!-- ========================== End Featured Category Section =============================== -->


			<!-- ============================ Featured Courses Start ================================== -->
			<section class="gray-bg">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-lg-5 col-md-6 col-sm-12">
							<div class="sec-heading center">
								{{-- <p>Hot & Trending</p> --}}
								<h2><span class="theme-cl">{{ trans('menu.sessions') }}</span> {{ trans('frontend.planned') }}</h2>
							</div>
						</div>
					</div>

					<div class="row">

                        @foreach ($data['list_sessions'] as $session)
                            <!-- Cource Grid 1 -->
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="education_block_list_layout">

                                    <div class="education_block_thumb n-shadow">
                                        <a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}"><img src="{{ asset(!empty($session->image) ? config('SaidTech.images.sessions.upload_path') . $session->image : 'frontend/assets/img/co-5.jpg') }}" class="img-fluid" alt=""></a>
                                    </div>

                                    <div class="list_layout_ecucation_caption">

                                        <div class="education_block_body">
                                            <h4 class="bl-title"><a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}">{{ $session->title }}</a></h4>
                                            <div class="mt-2 mb-2">
                                                <span class="badge badge-alternate">{{ $session->module->name }}</span>
                                            </div>
                                            <div class="cources_price">{{ $session->credit_cost .' '. trans('frontend.da') }}</div>
                                        </div>

                                        <div class="education_block_footer mt-3">
                                            <div class="education_block_author">
                                                <div class="path-img"><a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}" target="_blank">
                                                    <img src="{{ asset(!empty($session->teacher->user->avatar) ? 'frontend/images/avatars/' . $session->teacher->user->avatar : ($session->teacher->user->gender == 'male' ? 'frontend/images/default/user-m.png' : 'frontend/images/default/user-f.png')) }}" class="img-fluid" alt="" />
                                                </a>
                                            </div>
                                                <h5><a href="{{ route('frontend.teachers.show', ['id' => $session->teacher->user->id]) }}" target="_blank">{{ $session->teacher->user->full_name }}</a></h5>
                                            </div>
                                            <span class="education_block_time"><i class="ti-calendar mr-1"></i>{{ $session->date }}</span>
                                            {{-- <div class="cources_info_style3">
                                                <ul>
                                                    <li><a href="{{ route('frontend.sessions.show', ['slug' => $session->slug]) }}" target="_blank"><div class="foot_lecture"><i class="ti-control-skip-forward mr-2"></i>Continue</div></a></li>
                                                </ul>
                                            </div> --}}
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach

					</div>

				</div>
			</section>
			<!-- ============================ Featured Courses End ================================== -->

@endsection

@section('scripts')
    @include('frontend._partials.notif')
@endsection

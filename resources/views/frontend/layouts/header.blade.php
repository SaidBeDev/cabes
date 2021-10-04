
<!-- Start Navigation -->
<div class="header header-light head-shadow">
    <div class="container">
        <nav id="navigation" class="navigation navigation-landscape">
            <div class="nav-header">
                <a class="nav-brand" href="{{ route('frontend.index') }}">
                    <img src="{{ asset('frontend/images/logo2.png') }}" class="logo" alt="" />
                </a>
                <div class="nav-toggle"></div>
            </div>
            <div class="nav-menus-wrapper" style="transition-property: none;">
                <ul class="nav-menu">

                    @if (app()->getLocale() == "ar")
                        <li><a href="{{ route('frontend.contact.index') }}">{{ trans('menu.contact') }}</a></li>

                        <li><a href="{{ route('frontend.about.index') }}">{{ trans('menu.about') }}</a></li>

                        <li><a href="{{ route('frontend.sessions.index') }}">{{ trans('menu.sessions') }}<span class="submenu-indicator"></span></a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="#">{{ trans('frontend.by_module') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu duo-col">
                                        @foreach ($menu['spec_modules'] as $mod)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.sessions.getByModule', ['slug' => $mod->slug]) }}">{{ $mod->name }}</a></li>
                                        @endforeach

                                        @foreach ($menu['list_modules'] as $module)
                                            <li><a href="{{ route('frontend.sessions.getByModule', ['slug' => $module->slug]) }}">{{ $module->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="#">{{ trans('frontend.by_study_year') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu duo-col">
                                        @foreach ($menu['spec_years'] as $year)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.sessions.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                        @foreach ($menu['study_years'] as $year)
                                            <li><a href="{{ route('frontend.sessions.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>


                        <li><a href="{{ route('frontend.teachers.index') }}">{{ trans('frontend.find_tutor') }}<span class="submenu-indicator"></span></a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="#">{{ trans('frontend.by_module') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu duo-col">
                                        @foreach ($menu['spec_modules'] as $mod)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.teachers.getByModule', ['slug' => $mod->slug]) }}">{{ $mod->name }}</a></li>
                                        @endforeach

                                        @foreach ($menu['list_modules'] as $module)
                                            <li><a href="{{ route('frontend.teachers.getByModule', ['slug' => $module->slug]) }}">{{ $module->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="#">{{ trans('frontend.by_study_year') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu multi-col">
                                        @foreach ($menu['spec_years'] as $year)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.teachers.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                        @foreach ($menu['study_years'] as $year)
                                            <li><a href="{{ route('frontend.teachers.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="active"><a href="{{ route('frontend.index') }}">{{ trans('menu.homepage') }}</a></li>
                    @else
                        <li class="active"><a href="{{ route('frontend.index') }}">{{ trans('menu.homepage') }}</a></li>

                        <li><a href="{{ route('frontend.teachers.index') }}">{{ trans('frontend.find_tutor') }}<span class="submenu-indicator"></span></a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="#">{{ trans('frontend.by_module') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu duo-col">
                                        @foreach ($menu['spec_modules'] as $mod)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.teachers.getByModule', ['slug' => $mod->slug]) }}">{{ $mod->name }}</a></li>
                                        @endforeach

                                        @foreach ($menu['list_modules'] as $module)
                                            <li><a href="{{ route('frontend.teachers.getByModule', ['slug' => $module->slug]) }}">{{ $module->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="#">{{ trans('frontend.by_study_year') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu multi-col">
                                        @foreach ($menu['spec_years'] as $year)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.teachers.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                        @foreach ($menu['study_years'] as $year)
                                            <li><a href="{{ route('frontend.teachers.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li><a href="{{ route('frontend.sessions.index') }}">{{ trans('menu.sessions') }}<span class="submenu-indicator"></span></a>
                            <ul class="nav-dropdown nav-submenu">
                                <li><a href="#">{{ trans('frontend.by_module') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu duo-col">
                                        @foreach ($menu['spec_modules'] as $mod)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.sessions.getByModule', ['slug' => $mod->slug]) }}">{{ $mod->name }}</a></li>
                                        @endforeach

                                        @foreach ($menu['list_modules'] as $module)
                                            <li><a href="{{ route('frontend.sessions.getByModule', ['slug' => $module->slug]) }}">{{ $module->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="#">{{ trans('frontend.by_study_year') }}<span class="submenu-indicator"></span></a>
                                    <ul class="nav-dropdown nav-submenu duo-col">
                                        @foreach ($menu['spec_years'] as $year)
                                            <li><a style="font-weight: bold" href="{{ route('frontend.sessions.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                        @foreach ($menu['study_years'] as $year)
                                            <li><a href="{{ route('frontend.sessions.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li><a href="{{ route('frontend.about.index') }}">{{ trans('menu.about') }}</a></li>

                        <li><a href="{{ route('frontend.contact.index') }}">{{ trans('menu.contact') }}</a></li>
                    @endif

                </ul>

                @if (empty(Auth::user()))
                    <ul class="nav-menu nav-menu-social align-to-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">

                        <li class="login_click light">
                            <a href="{{ route('auth.loginForm') }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.login') }}"><i class="fas fa-sign-in-alt m9-show-inline d-lg-none"></i><span class="m9-hide-d" style="display: inline">{{ trans('menu.login') }}</span></a>
                        </li>
                        <li class="login_click theme-bg">
                            <a href="{{ route('auth.registerForm') }}" data-toggle="tooltip" data-placement="top" title="{{ trans('menu.register') }}"><i class="fas fa-user-plus m9-show-inline d-lg-none"></i> <span class="m9-hide-d" style="display: inline">{{ trans('menu.register') }}</span></a>
                        </li>
                    </ul>
                @elseif (!empty(Auth::user()) and Auth::user()->profile_type->name != "admin")
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse d-md-block" id="navbar-list-4">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ !empty(Auth::user()->avatar) ? asset('frontend/images/avatars/' . Auth::user()->avatar) : asset('frontend/images/default/user-m.png') }}" width="40" height="40" class="rounded-circle">
                                </a>
                                {{-- <a href="#" class="nav-link dropdown-toggle btn btn-outline-theme"  id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Profile</a>
                                 --}}

                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <div class="dropdown-item unclickable">{{ trans('frontend.credits') .': '. Auth::user()->credit }}</div>
                                    <a class="dropdown-item" href="{{ route('frontend.profile.show', ['id' => Auth::user()->id]) }}">{{ trans('menu.profile') }}</a>
                                    <a class="dropdown-item" href="{{ route('frontend.profile.edit', ['id' => Auth::user()->id]) }}">{{ trans('frontend.settings') }}</a>
                                    <a class="dropdown-item" href="{{ route('auth.logout') }}">{{ trans('frontend.logout') }}</a>
                                </div>
                            </li>
                        </ul>

                        {{-- Cart --}}
                        {{-- <a href="#" class="btn btn-danger "><i class="fa fa-shopping-cart"></i>{{ Auth::user()->credit .' '. trans('frontend.da') }}</a> --}}
                      </div>


                @endif
            </div>
        </nav>
    </div>
</div>
<!-- End Navigation -->
<div class="clearfix"></div>

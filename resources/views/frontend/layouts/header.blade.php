
<!-- Start Navigation -->
<div class="header header-light head-shadow">
    <div class="container">
        <nav id="navigation" class="navigation navigation-landscape">
            <div class="nav-header">
                <a class="nav-brand" href="#">
                    <img src="{{ asset('frontend/images/logo2.png') }}" class="logo" alt="" />
                </a>
                <div class="nav-toggle"></div>
            </div>
            <div class="nav-menus-wrapper" style="transition-property: none;">
                <ul class="nav-menu">

                    <li class="active"><a href="{{ route('frontend.index') }}">{{ trans('menu.homepage') }}</a></li>

                    <li><a href="{{ route('frontend.teachers.index') }}">{{ trans('frontend.find_tutor') }}<span class="submenu-indicator"></span></a>
                        <ul class="nav-dropdown nav-submenu">
                            <li><a href="#">{{ trans('frontend.by_module') }}<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu duo-col">
                                    @foreach ($menu['list_modules'] as $module)
                                        <li><a href="{{ route('frontend.teachers.getByModule', ['slug' => $module->slug]) }}">{{ $module->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="#">{{ trans('frontend.by_study_year') }}<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu multi-col">
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
                                    @foreach ($menu['list_modules'] as $module)
                                        <li><a href="{{ route('frontend.sessions.getByModule', ['slug' => $module->slug]) }}">{{ $module->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="#">{{ trans('frontend.by_study_year') }}<span class="submenu-indicator"></span></a>
                                <ul class="nav-dropdown nav-submenu duo-col">
                                    @foreach ($menu['study_years'] as $year)
                                        <li><a href="{{ route('frontend.sessions.getByYear', ['slug' => $year->slug]) }}">{{ $year->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li><a href="contact.html">Contact</a></li>

                </ul>

                @if (empty(Auth::user()))
                    <ul class="nav-menu nav-menu-social align-to-right">

                        <li class="login_click light">
                            <a href="{{ route('auth.loginForm') }}">{{ trans('menu.login') }}</a>
                        </li>
                        <li class="login_click theme-bg">
                            <a href="{{ route('auth.registerForm') }}">{{ trans('menu.register') }}</a>
                        </li>
                    </ul>
                @else
                   {{--  <ul class="nav-menu nav-menu-social align-to-right">

                        <li class="login_click theme-bg">
                            <a href="#">{{ Auth::user()->credit }}</a>
                        </li>
                        <li class="login_click theme-bg">
                            <a href="{{ route('frontend.profile.edit', ['id' => Auth::user()->id]) }}">{{ trans('frontend.profile') }}</a>
                        </li>
                    </ul> --}}
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                      </button>
                      <div class="collapse navbar-collapse d-none d-md-block" id="navbar-list-4">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <img src="{{ !empty(Auth::user()->avatar) ? asset('frontend/images/avatars/' . Auth::user()->avatar) : asset('frontend/images/default/user-m.png') }}" width="40" height="40" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <div class="dropdown-item unclickable">{{ trans('frontend.credits') .': '. Auth::user()->credit }}</div>
                                <a class="dropdown-item" href="{{ route('frontend.profile.edit', ['id' => Auth::user()->id]) }}">Dashboard</a>
                                <a class="dropdown-item" href="{{ route('frontend.profile.edit', ['id' => Auth::user()->id]) }}">Edit Profile</a>
                                <a class="dropdown-item" href="#">Log Out</a>
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

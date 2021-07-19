<div class="col-lg-3 col-md-3 p-0">
    <div class="dashboard-navbar">

        <div class="d-user-avater">
            <img src="{{ !empty(Auth::user()->avatar) ? asset('frontend/images/avatars/' . Auth::user()->avatar) : asset('frontend/images/default/user-m.png') }}" class="img-fluid avater" alt="">
            <h4>{{ Auth::user()->full_name }}</h4>
            <span style="color: #ccc">{{ trans('frontend.' . Auth::user()->profile_type->name) }}</span>
        </div>

        <div class="d-navigation">
            <ul id="side-menu">
                {{-- <li><a href="dashboard.html"><i class="ti-user"></i>Dashboard</a></li> --}}
                <li class='{{ ($data['uri'] == "view_profile") ? "active" : '' }}'><a href="{{ route('frontend.profile.show', ['id' => Auth::user()->id]) }}"><i class="ti-user"></i>{{ trans('menu.my_profile') }}</a></li>
                @if (Auth::user()->profile_type->name == "teacher")
                    <li class='{{ $data['uri'] == "add_course" ? "active" : '' }}'><a href="{{ route('frontend.profile.sessions.create') }}"><i class="ti-plus"></i>{{ trans('menu.add_course') }}</a></li>
                @endif
                <li class='{{ $data['uri'] == "my_courses" ? "active" : '' }}'><a href="{{ route('frontend.profile.sessions.index') }}"><i class="ti-layers"></i>{{ trans('menu.my_courses') }}</a></li>
                <li class='{{ $data['uri'] == "completed_sessions" ? "active" : '' }}'><a href="{{ route('frontend.profile.sessions.getCompletedSessions', ['id' => Auth::user()->id]) }}"><i class="ti-layers"></i>{{ trans('frontend.completed_sessions') }}</a></li>

                <li class='{{ $data['uri'] == "canceled_sessions" ? "active" : '' }}'><a href="{{ route('frontend.profile.sessions.getCanceledSessions', ['id' => Auth::user()->id]) }}"><i class="ti-layers"></i>{{ trans('frontend.canceled_sessions') }}</a></li>
                {{-- <li><a href="saved-courses.html"><i class="ti-heart"></i>Saved Courses</a></li> --}}

                <li class="{{ $data['uri'] == "edit_profile" ? 'active' : '' }}"><a href="{{ route('frontend.profile.edit', ['id' => Auth::user()->id]) }}"><i class="ti-settings"></i>{{ trans('frontend.settings') }}</a></li>
                <li><a href="{{ route('auth.logout') }}"><i class="ti-power-off"></i>{{ trans('frontend.logout') }}</a></li>
            </ul>
        </div>
    </div>
</div>

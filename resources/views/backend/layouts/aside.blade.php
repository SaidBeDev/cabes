<div class="app-sidebar sidebar-shadow bg-asteroid sidebar-text-light">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                {{-- Backend --}}
                <li class="app-sidebar__heading">tableau de bord</li>
                {{-- Teachers --}}
                <li>
                    <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.teachers') ? 'mm-active' : '') : '' }}">
                        <i class="metismenu-icon pe-7s-box2"></i>
                        Enseignants
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('backend.teachers.index') }}"><i class="metismenu-icon"></i>Tous les enseignants</a>
                        </li>
                    </ul>
                </li>
                {{-- Students --}}
                <li>
                    <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.students') ? 'mm-active' : '') : '' }}">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Étudiants
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('backend.students.index') }}">
                                <i class="metismenu-icon"></i>
                                Tous les étudiants
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Sessions --}}
                <li>
                    <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.sessions') ? 'mm-active' : '') : '' }}">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Séances
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('backend.sessions.getTeachers') }}">
                                <i class="metismenu-icon"></i>
                                Liste des enseignant
                            </a>
                            {{-- <a href="{{ route('backend.sessions.index') }}">
                                <i class="metismenu-icon"></i>
                                Les séances annulées
                            </a>
                            <a href="{{ route('backend.sessions.index') }}">
                                <i class="metismenu-icon"></i>
                                Les séances passées
                            </a> --}}
                        </li>
                    </ul>
                </li>

                {{-- About Us --}}
                <li>
                    <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.about') ? 'mm-active' : '') : '' }}">
                        <i class="metismenu-icon pe-7s-user"></i>
                        {{ trans('menu.about') }}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('backend.about.edit') }}">
                                <i class="metismenu-icon"></i>
                                Modifier
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Contacts --}}
                <li>
                    <a href="{{ route('backend.contact.index') }}" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.contact') ? 'mm-active' : '') : '' }}">
                        <i class="metismenu-icon pe-7s-settings"></i>
                        Contacts
                    </a>
                </li>

                {{-- Configs --}}
                <li>
                    <a href="{{ route('backend.configs.index') }}" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.configs') ? 'mm-active' : '') : '' }}">
                        <i class="metismenu-icon pe-7s-settings"></i>
                        Configurations
                    </a>
                </li>

                    @if (1 == 0)
                    {{-- Frontend --}}
                    <li class="app-sidebar__heading">Façade du site</li>

                    {{-- Services --}}
                    <li>
                        <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.services_front') ? 'mm-active' : '') : '' }}">
                            <i class="metismenu-icon pe-7s-tools"></i>
                            Notre Services
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{-- route('admin.servicesFront.index') --}}">
                                    <i class="metismenu-icon"></i>
                                    Tous les Services
                                </a>
                                <a href="{{-- route('admin.servicesFront.create') --}}">
                                    <i class="metismenu-icon"></i>
                                    Nouveau Service
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Contacts --}}
                    <li>
                        <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.contacts') ? 'mm-active' : '') : '' }}">
                            <i class="metismenu-icon pe-7s-map-marker"></i>
                            Contacts
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{-- route('admin.contacts.index') --}}">
                                    <i class="metismenu-icon"></i>
                                    Tous les Contacts
                                </a>
                            </li>
                            <li>
                                <a href="{{-- route('admin.contacts.create') --}}">
                                    <i class="metismenu-icon"></i>
                                    Nouveau Contact
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- About us --}}
                    <li>
                        <a href="#" class="{{ isset($info['title']) ? ($info['title'] == trans('menu.services_front') ? 'mm-active' : '') : '' }}">
                            <i class="metismenu-icon pe-7s-tools"></i>
                            A propos de nous
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                        <li>
                            <a href="{{-- route('frontend.about.index') --}}">
                                <i class="metismenu-icon"></i>
                                Modifier
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

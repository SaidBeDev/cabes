<?php

use Illuminate\Support\Facades\Auth;

// Profile
Breadcrumbs::for('profile', function ($trail) {
    $trail->push(ucfirst(trans('menu.profile')), '#');
});

// Profile > Show
Breadcrumbs::for('profile_show', function ($trail) {
    $trail->parent('profile');
    $trail->push(ucfirst(trans('menu.profile')), route('frontend.profile.show', ['id' => !empty(Auth::user()) ? Auth::user()->id : 0]));
});

// Profile > Setting
Breadcrumbs::for('setting', function ($trail) {
    $trail->parent('profile');
    $trail->push(ucfirst(trans('frontend.settings')), route('frontend.profile.edit', ['id' => !empty(Auth::user()) ? Auth::user()->id : 0]));
});
// Profile > Edit availability
Breadcrumbs::for('edit_avail', function ($trail) {
    $trail->parent('profile');
    $trail->push(ucfirst(trans('menu.edit_availability')), route('frontend.profile.editAvailability', ['id' => !empty(Auth::user()) ? Auth::user()->id : 0]));
});

// Profile > Sessions
Breadcrumbs::for('sessions', function ($trail) {
    $trail->parent('profile');
    $trail->push(ucfirst(trans('menu.sessions')), route('frontend.profile.sessions.index'));
});

// Profile > Sessions > Sessions Completed
Breadcrumbs::for('completed_sessions', function ($trail) {
    $trail->parent('sessions');
    $trail->push(ucfirst(trans('frontend.completed_sessions')), '#');
});

// Profile > Sessions > Sessions Canceled
Breadcrumbs::for('canceled_sessions', function ($trail) {
    $trail->parent('sessions');
    $trail->push(ucfirst(trans('frontend.canceled_sessions')), '#');
});

// Profile > Sessions > Sessions Create
Breadcrumbs::for('create_session', function ($trail) {
    $trail->parent('sessions');
    $trail->push(ucfirst(trans('frontend.create_session')), route('frontend.profile.sessions.create'));
});

// Profile > Sessions > Sessions Edit
Breadcrumbs::for('edit_session', function ($trail, $id) {
    $trail->parent('sessions');
    $trail->push(ucfirst(trans('frontend.edit_session')),
     route('frontend.profile.sessions.edit', ['id' => $id]));
});

// Profile > Sessions > Sessions Edit
Breadcrumbs::for('show_session', function ($trail, $session) {
    $trail->parent('sessions');
    $trail->push(ucfirst($session->title), route('frontend.profile.sessions.edit', ['id' => $session->id]));
});

// Profile > Sessions > Sessions Edit
Breadcrumbs::for('enrolled_students', function ($trail) {
    $trail->parent('sessions');
    $trail->push(ucfirst(trans('frontend.enrolled_list')), '#');
});


/**
 * Front Breads
 */

// Homepage
Breadcrumbs::for('homepage', function ($trail) {
    $trail->push(ucfirst(trans('menu.homepage')), route('frontend.index'));
});

// Home > Teachers
Breadcrumbs::for('teachers', function ($trail) {
    $trail->parent('homepage');
    $trail->push(ucfirst(trans('frontend.find_tutor')), route('frontend.teachers.index'));
});

// Home > Sessions
Breadcrumbs::for('h_sessions', function ($trail) {
    $trail->parent('homepage');
    $trail->push(ucfirst(trans('frontend.find_session')), route('frontend.sessions.index'));
});

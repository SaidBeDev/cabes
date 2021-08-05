<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Admin Routes
 */
Route::group([
    'namespace' => "Backend",
    'middleware' => ['guest']
], function() {
    Route::name('backend.')->prefix(env('ADMIN_PREFIX'))->group(function() {
        // Login to administration
        Route::get('/login', 'Profile\LoginController@create')->name('loginForm');
        Route::post('/auth', 'Profile\LoginController@login')->name('login');

        Route::post('/logout', 'Profile\LoginController@logout')->name('logout');

    });
});

Route::group([
    'namespace' => "Backend",
    'middleware' => ['authAdmin']
], function() {
    Route::name('backend.')->prefix(env('ADMIN_PREFIX'))->group(function() {

        Route::get('/', 'Teachers\ManageTeachersController@index')->name('index');
        // Dashboard Index Route

        // Manage Teachers
        Route::namespace('Teachers')->name('teachers.')->prefix('teachers')->group(function() {
            Route::get('/', 'ManageTeachersController@index')->name('index');

            Route::get('/{id}', 'ManageTeachersController@show')->name('show');

            Route::get('/edit/{id}', 'ManageTeachersController@edit')->name('edit');

            Route::put('/update/{id}/{profileId}', 'ManageTeachersController@update')->name('update');

            Route::get('/edit-availability/{id}', 'ManageTeachersController@editAvailability')->name('editAvailability');

            Route::post('/update-availability/{id}', 'ManageTeachersController@updateAvailability')->name('updateAvailability');

            Route::get('/edit-hour-price/{id}', 'ManageTeachersController@editHourPrices')->name('editHourPrices');

            Route::post('/change-hour-price/{id}', 'ManageTeachersController@changeHourlyPrice')->name('changeHourlyPrice');

            Route::post('/change-group-price/{id}', 'ManageTeachersController@changeGroupPrice')->name('changeGroupPrice');

            Route::get('/edit-credit/{id}', 'ManageTeachersController@editCredit')->name('editCredit');
            Route::post('/change-credit/{id}', 'ManageTeachersController@changeCredit')->name('changeCredit');

            Route::post('/check/{id}', 'ManageTeachersController@toggleCheck')->name('toggleCheck');
            Route::post('/block/{id}', 'ManageTeachersController@toggleBlock')->name('toggleBlock');

            Route::get('/history/{id}', 'ManageTeachersController@showHistory')->name('showHistory');
        });

          // Manage Students
          Route::namespace('Students')->name('students.')->prefix('students')->group(function() {
            Route::get('/', 'ManageStudentsController@index')->name('index');

            Route::get('/{id}', 'ManageStudentsController@show')->name('show');

            Route::get('/edit/{id}', 'ManageStudentsController@edit')->name('edit');

            Route::put('/update/{id}/{profileId}', 'ManageStudentsController@update')->name('update');

            Route::get('/edit-credit/{id}', 'ManageStudentsController@editCredit')->name('editCredit');
            Route::post('/change-credit/{id}', 'ManageStudentsController@changeCredit')->name('changeCredit');

            Route::post('/block/{id}', 'ManageStudentsController@toggleBlock')->name('toggleBlock');

            Route::get('/history/{id}', 'ManageStudentsController@showHistory')->name('showHistory');
          });

        // Manage Sessions
        Route::namespace('Sessions')->name('sessions.')->prefix('sessions')->group(function() {

        Route::get('/{id}/list', 'ManageSessionsController@index')->name('index');

        Route::get('/', 'ManageSessionsController@getTeachers')->name('getTeachers');

        Route::get('/{id}', 'ManageSessionsController@show')->name('show');
        Route::get('/{id}/edit', 'ManageSessionsController@edit')->name('edit');

        Route::get('joined-students/{id}', 'ManageSessionsController@getEnrolledStudents')->name('getEnrolledStudents');
        Route::get('completed-sessions/{id}', 'ManageSessionsController@getCompletedSessions')->name('getCompletedSessions');
        Route::get('canceled-sessions/{id}', 'ManageSessionsController@getCanceledSessions')->name('getCanceledSessions');

        Route::post('mark-completed/{id}', 'ManageSessionsController@markAsCompleted')->name('markAsCompleted');

        Route::post('mark-canceled/{id}', 'ManageSessionsController@markAsCanceled')->name('markAsCanceled');
        });

        // About Us
        Route::namespace('About')->name('about.')->prefix(trans('routes.about'))->group(function() {
            Route::get('/edit', 'AboutUsController@edit')->name('edit');
            Route::put('/update', 'AboutUsController@update')->name('update');
        });

        // Contact Us
        Route::namespace('Contact')->name('contact.')->prefix(trans('routes.contact'))->group(function() {
            Route::get('/', 'ContactUsController@index')->name('index');

            Route::get('/{id}/edit', 'ContactUsController@edit')->name('edit');

            Route::put('/{id}/update', 'ContactUsController@update')->name('update');

        });

        // Manage Conifgs
        Route::namespace('Configs')->name('configs.')->prefix('configs')->group(function() {
        Route::get('/', 'ManageConfigsController@index')->name('index');

        Route::post('/update/{id}', 'ManageConfigsController@update')->name('update');
        });
    });
});


/**
 * Auth Routes
 */
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'namespace' => 'Auth'
], function() {
    Route::name('auth.')->group(function() {
        // Welcome
        Route::get(Laravellocalization::transRoute('routes.welcome'), 'RegisterController@welcome')->name('welcome');
        Route::get(Laravellocalization::transRoute('routes.not_verified'), 'LoginController@notVerified')->name('notVerified');
        // Register Routes
        Route::get('/'. Laravellocalization::transRoute('routes.register'), 'RegisterController@create')->name('registerForm');
        Route::post('/store', 'RegisterController@store')->name('register');

        // Login Routes
        Route::get('/'. Laravellocalization::transRoute('routes.login'), 'LoginController@create')->name('loginForm');
        Route::post('/auth', 'LoginController@login')->name('login');

        // Reset Password
        Route::get(trans('routes.reset_pass'), 'LoginController@resetPasswordForm')->name('resetPasswordForm');
        Route::post('/send-mail', 'LoginController@SendResetMail')->name('SendResetMail');
        Route::get(trans('routes.new_pass') . '/{code}/{id}', 'LoginController@newPasswordForm')->name('newPasswordForm');
        Route::post('/save-password', 'LoginController@resetPassword')->name('resetPassword');

        // Verify account
        Route::get('/verify/{code}/{id}', 'ٌRegisterController@verify')->name('verifyEmail');


        Route::get('/logout', 'LoginController@logout')->name('logout');

    });
});


/**
 * Frontend Routes
 */
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
    'namespace' => 'Frontend'
], function() {
    Route::name('frontend.')->group(function() {
        Route::name('sessionIndex')->get('/sessions', 'MngSessionsController@create');

        Route::get('/ts', function () {
            $data = [
                'name' => '',
                'user_id' => '',
                'profile_type' => '',
                'code' => ''
            ];

            return view('emails.resetPassword', ['data' => $data]);
        });

        // Homepage Index Route
        Route::get('/', 'HomepageController@index')->name('index');

        /**
         * Dashboard Routes
         */
        // Profile
        Route::namespace("Profile")->middleware('auth')->name('profile.')->prefix(Laravellocalization::transRoute('routes.profile'))->group(function()
        {
            Route::get('/{id}', 'ProfileController@show')->name('show');
            Route::get('/edit/{id}', 'ProfileController@edit')->name('edit');

            Route::put('/update/{id}/{profileId}', 'ProfileController@update')->name('update');

            Route::get(Laravellocalization::transRoute('routes.edit_availability') . '/{id}', 'TeacherProfileController@editAvailability')->name('editAvailability');
            Route::put('/edit-availability/{id}', 'TeacherProfileController@updateAvailability')->name('updateAvailability');

            // sessions
            Route::name('sessions.')->prefix(trans('routes.sessions'))->group(function() {
                Route::get('/list', 'MngSessionsController@index')->name('index');

                Route::get('/create', 'MngSessionsController@create')->name('create');

                Route::get('/{id}', 'MngSessionsController@show')->name('show');
                Route::get('/{id}/etudiants', 'MngSessionsController@getEnrolledStudents')->name('enrolledStudents');

                Route::get('/{id}/termine', 'MngSessionsController@getCompletedSessions')->name('getCompletedSessions');
                Route::get('/{id}/séances-annulées', 'MngSessionsController@getCanceledSessions')->name('getCanceledSessions');

                Route::post('sessions/store', 'MngSessionsController@store')->name('store');
                Route::get('sessions/{id}/edit', 'MngSessionsController@edit')->name('edit');
                Route::put('sessions/update/{id}', 'MngSessionsController@update')->name('update');

                Route::post('sessions/mark-completed/{id}', 'MngSessionsController@markAsCompleted')->name('markAsCompleted');
                Route::post('sessions/mark-canceled/{id}', 'MngSessionsController@markAsCanceled')->name('markAsCanceled');

                Route::post('sessions/join-session/{id}', 'MngSessionsController@joinSession')->name('joinSession');
                Route::post('sessions/exit-session/{id}', 'MngSessionsController@exitFromSession')->name('exitFromSession');
            });

            /**
             * Error of 3emek Slimane le 22/02/2021 à Maubeuge
             */

        });

        // About Us
        Route::name('about.')->prefix(trans('routes.about'))->group(function() {
            Route::get('/', 'AboutUsController@index')->name('index');
        });

        // Contact Us
        Route::name('contact.')->prefix(trans('routes.contact'))->group(function() {
            Route::get('/', 'ContactController@index')->name('index');

            Route::post('/send', 'ContactController@store')->name('store');

        });

        // Sessions Guide Routes
        Route::name('sessions.')->prefix(trans('routes.sessions'))->group(function() {
            Route::get('/', 'SessionsController@index')->name('index');

            Route::get('/{slug}', 'SessionsController@show')->name('show');

            Route::get(trans('routes.by_module') . '/{slug}', 'SessionsController@getByModule')->name('getByModule');
            Route::get(trans('routes.by_year') . '/{slug}', 'SessionsController@getByYear')->name('getByYear');
        });

        // Teachers Guide routes
        Route::name('teachers.')->prefix(trans('routes.teachers'))->group(function() {
            Route::get('/', 'TeachersController@index')->name('index');

            Route::get('/{id}', 'TeachersController@show')->name('show');

            Route::get(trans('routes.by_module') . '/{slug}', 'TeachersController@getByModule')->name('getByModule');
            Route::get(trans('routes.by_year') . '/{slug}', 'TeachersController@getByYear')->name('getByYear');
        });

    });
});

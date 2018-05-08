<?php

// use TrainingTracker\Domains\Roles\Role;
// use TrainingTracker\Domains\Users\User;

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

// Route::get('/', function () {
// 	dd((Role::with('users')->whereType('admin')->first())->users->each->moodleuser);
//     // return view('layouts.app');
// });

// Route::get('/profile/{user}', function (User $user) {
// 	dd($user->isSupervisedBy());
//     // return view('layouts.app');
// });

// Route::get('/api/users', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@index');
// Route::post('/api/users', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@store');

Route::middleware(['role:administrator'])->group(function () {
	Route::prefix('roles')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Roles\Controllers\RolesController@index')->name('roles.index');
		Route::get('/api', '\TrainingTracker\Http\Roles\Controllers\Api\RolesController@index')->name('roles.index.api');

		Route::get('/create', '\TrainingTracker\Http\Roles\Controllers\RolesController@create')->name('roles.create');
		Route::post('/', '\TrainingTracker\Http\Roles\Controllers\RolesController@store');

		Route::get('/{role}/edit', '\TrainingTracker\Http\Roles\Controllers\RolesController@edit');
		Route::put('/{role}', '\TrainingTracker\Http\Roles\Controllers\RolesController@update');

		Route::delete('/{role}', '\TrainingTracker\Http\Roles\Controllers\RolesController@destroy');
	});
});

Route::middleware(['role:administrator'])->group(function () {
	Route::prefix('users')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Users\Controllers\UsersController@index')->name('users.index');
		Route::get('/api', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@index')->name('users.index.api');

		Route::get('/create', '\TrainingTracker\Http\Users\Controllers\UsersController@create')->name('users.create');
		Route::get('/api/create', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@create')->name('users.create.api');
		Route::post('/api', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@store')->name('users.store.api');

		Route::put('/{user}/role', '\TrainingTracker\Http\UsersRole\Controllers\UsersRoleController@update');
		Route::delete('/{user}', '\TrainingTracker\Http\Users\Controllers\UsersController@destroy');

		Route::put('/api/{user}/appointment', '\TrainingTracker\Http\UsersAppointment\Controllers\Api\UsersAppointmentController@update');

		Route::get('/{user}/reporting/{role}/edit', '\TrainingTracker\Http\UsersReporting\Controllers\UsersReportingController@index')->name('usersreporting.index');
		Route::get('/api/{user}/reporting/{role}/edit', '\TrainingTracker\Http\UsersReporting\Controllers\Api\UsersReportingController@index')->name('usersreporting.index.api');
		Route::post('/api/{user}/reporting/{role}', '\TrainingTracker\Http\UsersReporting\Controllers\Api\UsersReportingController@store')->name('usersreporting.store.api');

		Route::post('/{user}/activation', '\TrainingTracker\Http\UsersActivation\Controllers\UsersActivationController@store');
		Route::delete('/{user}/activation', '\TrainingTracker\Http\UsersActivation\Controllers\UsersActivationController@destroy');

		Route::get('/inactive', '\TrainingTracker\Http\InactiveUsers\Controllers\InactiveUsersController@index')->name('inactiveusers.index');
		Route::get('/api/inactive', '\TrainingTracker\Http\InactiveUsers\Controllers\Api\InactiveUsersController@index')->name('inactiveusers.index.api');
	});
});

Route::middleware(['role:administrator'])->group(function () {
	Route::prefix('topics')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Topics\Controllers\TopicsController@index')->name('topics.index');
		Route::get('/api', '\TrainingTracker\Http\Topics\Controllers\Api\TopicsController@index')->name('topics.index.api');

		Route::get('/create', '\TrainingTracker\Http\Topics\Controllers\TopicsController@create')->name('topics.create');
		Route::post('/', '\TrainingTracker\Http\Topics\Controllers\TopicsController@store');

		Route::get('/{topic}/edit', '\TrainingTracker\Http\Topics\Controllers\TopicsController@edit');
		Route::put('/{topic}', '\TrainingTracker\Http\Topics\Controllers\TopicsController@update');

		Route::delete('/{topic}', '\TrainingTracker\Http\Topics\Controllers\TopicsController@destroy');
	});
});

Route::middleware(['role:administrator'])->group(function () {
	Route::prefix('lessons')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@index')->name('lessons.index');
		Route::get('/api', '\TrainingTracker\Http\Lessons\Controllers\Api\LessonsController@index')->name('lessons.index.api');

		Route::get('/create', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@create')->name('lessons.create');
		Route::post('/', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@store');

		Route::get('/{lesson}/edit', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@edit');
		Route::put('/{lesson}', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@update');

		Route::delete('/{lesson}', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@destroy');
	});
});

Route::middleware(['role:administrator'])->group(function () {
	Route::prefix('objectives')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController@index')->name('objectives.index');
		Route::get('/api', '\TrainingTracker\Http\Objectives\Controllers\Api\ObjectivesController@index')->name('objectives.index.api');

		Route::get('/create', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController@create')->name('objectives.create');
		Route::post('/', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController@store');

		// Route::get('/{lesson}/edit', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@edit');
		// Route::put('/{lesson}', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@update');

		// Route::delete('/{lesson}', '\TrainingTracker\Http\Lessons\Controllers\LessonsController@destroy');
	});
});

Route::middleware(['profile'])->group(function () {
	Route::prefix('users/{user}')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Users\Controllers\UsersController@show')->name('users.show');
	});
});

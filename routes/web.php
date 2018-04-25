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
	});
});

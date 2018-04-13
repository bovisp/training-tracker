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
// use TrainingTracker\Domains\Users\User;

// Route::get("/users", function () {
// 	return User::find(1)->toArray();
// });

// Route::get('/test', function(){
//     dd(moodleauth()->user());
// });

// Route::get('/', function () {
//     return view('layouts.app');
// });

// Route::post('/test', '\TrainingTracker\Http\Test\Controllers\TestController@store');
// use TrainingTracker\Domains\Users\User;

Route::get('/', function () {
	return view('layouts.app');
	// $user = moodleauth()->user();

	// $user->updateRole('user');
});

// Route::group(['middleware' => 'role:admin'], function () {

// 	Route::group(['middleware' => 'role:admin,delete users'], function () {
// 		Route::get('/admin/users', function () {
// 			return "delete users";
// 		});
// 	});

// 	Route::get('/admin', function () {
// 		return "admin panel";
// 	});
// });

Route::group(['middleware' => 'can:delete users'], function () {

	// Route::group(['middleware' => 'role:admin,delete users'], function () {
	// 	Route::get('/admin/users', function () {
	// 		return "delete users";
	// 	});
	// });

	Route::get('/admintest', function () {
		return "admin panel";
	});
});
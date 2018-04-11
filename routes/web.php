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
use TrainingTracker\Domains\Users\User;

Route::get("/users", function () {
	return User::find(1)->toArray();
});

Route::get('/test', function(){
    dd(MoodleAuth::check());
});

Route::get('/', function () {
    return view('layouts.app');
});

Route::post('/test', '\TrainingTracker\Http\Test\Controllers\TestController@store');
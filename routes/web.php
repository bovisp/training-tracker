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
	return User::find(1);
});

Route::get('/', function () {
    return view('layouts.app');
});

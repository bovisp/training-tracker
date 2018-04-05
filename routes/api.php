<?php

use TrainingTracker\Domains\Users\User;

Route::get("/users", function () {
	return User::find(1);
});
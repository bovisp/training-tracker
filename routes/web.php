<?php
Route::get('/', function () {
	return 'home';
})->middleware('home-redirect');

/**
 * Download middleware routes for downloading logbook entry files.
 */
Route::middleware(['download'])->group(function () {
	Route::get(
		'/storage/entries/{user}/{file}',
		'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@download'
	);

	Route::delete(
		'/storage/entries/{user}/{logbookEntry}/{file}',
		'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@destroy'
	);

	Route::patch(
		'/storage/entries/{user}/{logbookEntry}/updatefiles',
		'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@update'
	);
});

Route::middleware(['role:administrator|supervisor|head_of_operations|manager'])->group(function () {

	Route::prefix('/users')->group(function () {
		Route::delete('/{user}/activation', '\TrainingTracker\Http\UsersActivation\Controllers\UsersActivationController@destroy');
	});
});

/**
 * All routes that can only be viewed by administrators.
 */
Route::middleware(['role:administrator'])->group(function () {

	/**
	 * Various API "role" routes.
	 */
	Route::get('/roles/api', '\TrainingTracker\Http\Roles\Controllers\Api\RolesController@index')
		->name('roles.index.api');

	/**
	 * Role HTTP resource routes.
	 */
	Route::resource('roles', '\TrainingTracker\Http\Roles\Controllers\RolesController', [
		'names' => [
			'index' => 'roles.index',
			'create' => 'roles.create'
		],
		'except' => [
			'show'
		]
	]);

	/**
	 * Various API "user" routes.
	 */
	Route::prefix('/users/api')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@index')
			->name('users.index.api');

		Route::get('/create', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@create')
			->name('users.create.api');

		Route::post('/', '\TrainingTracker\Http\Users\Controllers\Api\UsersController@store')
			->name('users.store.api');

		Route::put('/{user}/appointment', '\TrainingTracker\Http\UsersAppointment\Controllers\Api\UsersAppointmentController@update');

		Route::post('/{user}/activation', '\TrainingTracker\Http\UsersActivation\Controllers\Api\UsersActivationController@store');
		Route::patch('/{user}/activation', '\TrainingTracker\Http\UsersActivation\Controllers\Api\UsersActivationController@update');

		Route::get('/{user}/reporting/{role}/edit', '\TrainingTracker\Http\UsersReporting\Controllers\Api\UsersReportingController@index')
			->name('usersreporting.index.api');

		Route::post('/{user}/reporting/{role}', '\TrainingTracker\Http\UsersReporting\Controllers\Api\UsersReportingController@store')
			->name('usersreporting.store.api');

		Route::get('/inactive', '\TrainingTracker\Http\InactiveUsers\Controllers\Api\InactiveUsersController@index')
			->name('inactiveusers.index.api');
	});

	/**
	 * Various HTTP "user" routes.
	 */
	Route::prefix('/users')->group(function () {
		Route::put('/{user}/role', '\TrainingTracker\Http\UsersRole\Controllers\UsersRoleController@update');

		Route::get('/{user}/reporting/{role}/edit', '\TrainingTracker\Http\UsersReporting\Controllers\UsersReportingController@index')
			->name('usersreporting.index');

		Route::post('/{user}/activation', '\TrainingTracker\Http\UsersActivation\Controllers\UsersActivationController@store');

		Route::get('/inactive', '\TrainingTracker\Http\InactiveUsers\Controllers\InactiveUsersController@index')
			->name('inactiveusers.index');

		Route::get('/userlessons/unassigned', '\TrainingTracker\Http\UnassignedUserLessons\Controllers\Api\UnassignedUserLessonsController@index');
	});

	/**
	 * User HTTP resource routes.
	 */
	Route::resource('users', '\TrainingTracker\Http\Users\Controllers\UsersController', [
		'names' => [
			'index' => 'users.index',
			'create' => 'users.create'
		],
		'only' => [
			'index', 'create', 'destroy'
		]
	]);

	/**
	 * Various "userlessons" HTTP and API routes.
	 */
	Route::prefix('users/{user}/userlessons')->group(function () {
		Route::get('/unassigned', '\TrainingTracker\Http\UnassignedUserLessons\Controllers\Api\UnassignedUserLessonsController@index');
		Route::post('/unassigned', '\TrainingTracker\Http\UnassignedUserLessons\Controllers\Api\UnassignedUserLessonsController@store');

		Route::delete('/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\UserLessonsController@destroy');
	});

	/**
	 * Level HTTP resource routes.
	 */
	Route::resource('levels', '\TrainingTracker\Http\Levels\Controllers\LevelsController', [
		'names' => [
			'index' => 'levels.index',
			'create' => 'levels.create'
		],
		'except' => [
			'show'
		]
	]);

	/**
	 * Various API "level" routes.
	 */
	Route::prefix('levels')->group(function () {
		Route::get('/api', '\TrainingTracker\Http\Levels\Controllers\Api\LevelsController@index')
			->name('levels.index.api');
	});

	/**
	 * Lesson HTTP resource routes.
	 */
	Route::resource('lessons', '\TrainingTracker\Http\Lessons\Controllers\LessonsController', [
		'names' => [
			'index' => 'lessons.index',
			'create' => 'lessons.create'
		],
		'except' => [
			'show'
		]
	]);

	/**
	 * Various API "lesson" routes.
	 */
	Route::prefix('lessons')->group(function () {
		Route::get('/api', '\TrainingTracker\Http\Lessons\Controllers\Api\LessonsController@index')
			->name('lessons.index.api');
	});

	/**
	 * Lesson HTTP resource routes.
	 */
	Route::resource('objectives', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController', [
		'names' => [
			'index' => 'objectives.index',
			'create' => 'objectives.create'
		],
		'except' => [
			'show'
		]
	]);

	/**
	 * Various API "objective" routes.
	 */
	Route::prefix('objectives')->group(function () {
		Route::get('/api', '\TrainingTracker\Http\Objectives\Controllers\Api\ObjectivesController@index')
			->name('objectives.index.api');
	});
});

/**
 * All routes that can only be viewed by a particular user
 * and, possibly, employees in their reporting structure
 * higher than them.
 */
Route::middleware(['profile'])->group(function () {

	Route::get('api/userlessons/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonsController@show');
	Route::get('userlessons/{userlesson}/logbooks', '\TrainingTracker\Http\Logbooks\Controllers\Api\LogbooksController@index');
	Route::get('entries/{entry}', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@show');
	Route::patch('entries/{entry}', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@update');
	Route::delete('entries/{entry}', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@destroy');
	Route::post('logbooks/{logbook}/entries', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@store');

	/**
	 * Various HTTP "user" routes.
	 */
	Route::prefix('users/{user}')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Users\Controllers\UsersController@show')
			->name('users.show');

		Route::get('/deactivations', '\TrainingTracker\Http\UsersDeactivation\Controllers\Api\UsersDeactivationController@index');
		Route::put('/deactivations/{deactivation}', '\TrainingTracker\Http\UsersDeactivation\Controllers\Api\UsersDeactivationController@update');
	});

	/**
	 * Various HTTP "userlesson" routes.
	 */
	Route::prefix('users/{user}/userlessons')->group(function () {
		Route::get('/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\UserLessonsController@show')
			->name('userlessons.show');

		Route::put('/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\UserLessonsController@update');
	});

	/**
	 * Various API "userlesson" routes.
	 */
	Route::prefix('users/{user}/userlessons')->group(function () {
		Route::get('/', '\TrainingTracker\Http\UserLessons\Controllers\Api\UserLessonsController@index')
			->name('userlessons.index.api');

		Route::get('/{userlesson}/api', '\TrainingTracker\Http\UserLessons\Controllers\Api\UserLessonsController@show');
	});

	/**
	 * Userlesson comments API resource routes.
	 */
	Route::resource(
		'users/{user}/userlessons/{userlesson}/comments',
		'\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonCommentController',
		[
			'except' => [
				'show', 'edit', 'create'
			]
		]
	);

	/**
	 * Various API and HTTP "logbook" routes.
	 */
	Route::prefix('users/{user}/logbooks/{logbook}')->group(function () {
		Route::get('/entries', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@index');

		Route::get('/', '\TrainingTracker\Http\Logbooks\Controllers\LogbookController@show');

		// Route::post('/', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@store');

		Route::post('/files/meta', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@meta');

		Route::post('/files/upload', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@upload');

		Route::put('/entries/{logbookEntry}', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@update');

		Route::delete('/entries/{logbookEntry}', '\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@destroy');
	});

	/**
	 * Logbook comments API resource routes.
	 */
	Route::resource(
		'users/{user}/entries/{logbookEntry}/comments',
		'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesCommentsController',
		[
			'except' => [
				'show', 'edit', 'create'
			]
		]
	);

	/**
	 * Various API and HTTP user "notification" routes.
	 */
	Route::prefix('users/{user}/notifications')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Notifications\Controllers\NotificationsController@index')
			->name('notifications.index');

		Route::get('/api', '\TrainingTracker\Http\Notifications\Controllers\Api\NotificationsController@index');

		Route::put('/read', '\TrainingTracker\Http\Notifications\Controllers\Api\AllNotificationsController@read');

		Route::put('/unread', '\TrainingTracker\Http\Notifications\Controllers\Api\AllNotificationsController@unread');

		Route::delete('/read', '\TrainingTracker\Http\Notifications\Controllers\Api\AllNotificationsController@destroyRead');

		Route::delete('/unread', '\TrainingTracker\Http\Notifications\Controllers\Api\AllNotificationsController@destroyUnread');

		Route::delete('/{notificationId}', '\TrainingTracker\Http\Notifications\Controllers\Api\NotificationsController@destroy');

		Route::put('/{notificationId}/read', '\TrainingTracker\Http\Notifications\Controllers\Api\NotificationsController@read');

		Route::put('/{notificationId}/unread', '\TrainingTracker\Http\Notifications\Controllers\Api\NotificationsController@unread');
	});
});
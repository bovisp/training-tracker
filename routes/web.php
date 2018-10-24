<?php
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

		Route::get('/userlessons/unassigned', '\TrainingTracker\Http\UnassignedUserLessons\Controllers\Api\UnassignedUserLessonsController@index');
	});
});

Route::middleware(['role:administrator'])->group(function () {
	Route::prefix('users/{user}')->group(function () {
		Route::get('/userlessons/unassigned', '\TrainingTracker\Http\UnassignedUserLessons\Controllers\Api\UnassignedUserLessonsController@index');
		Route::post('/userlessons/unassigned', '\TrainingTracker\Http\UnassignedUserLessons\Controllers\Api\UnassignedUserLessonsController@store');

		Route::delete('/userlessons/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\UserLessonsController@destroy');
	});
});

Route::middleware(['profile'])->group(function () {
	Route::prefix('users/{user}')->group(function () {
		Route::get('/', '\TrainingTracker\Http\Users\Controllers\UsersController@show')->name('users.show');

		Route::get('/userlessons', '\TrainingTracker\Http\UserLessons\Controllers\Api\UserLessonsController@index')
			->name('userlessons.index.api');

		Route::get('/userlessons/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\UserLessonsController@show')
			->name('userlessons.show');

		Route::get('/userlessons/{userlesson}/api', '\TrainingTracker\Http\UserLessons\Controllers\Api\UserLessonsController@show');

		Route::put('/userlessons/{userlesson}', '\TrainingTracker\Http\UserLessons\Controllers\UserLessonsController@update');

		Route::get(
			'/userlessons/{userlesson}/comments',
			 '\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonCommentController@index'
		);

		Route::post(
			'/userlessons/{userlesson}/comments',
			 '\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonCommentController@store'
		);

		Route::put(
			'/userlessons/{userlesson}/comments/{comment}',
			 '\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonCommentController@update'
		);

		Route::delete(
			'/userlessons/{userlesson}/comments/{comment}',
			 '\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonCommentController@destroy'
		);

		Route::get(
			'/logbooks/{logbook}/entries',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@index'
		);

		Route::get(
			'/logbooks/{logbook}',
			'\TrainingTracker\Http\Logbooks\Controllers\LogbookController@show'
		);

		Route::post(
			'/logbooks/{logbook}',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@store'
		);

		Route::post(
			'/logbooks/{logbook}/files/meta',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@meta'
		);

		Route::post(
			'/logbooks/{logbook}/files/upload',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntryFilesController@upload'
		);

		Route::put(
			'/logbooks/{logbook}/entries/{logbookEntry}',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@update'
		);

		Route::delete(
			'/logbooks/{logbook}/entries/{logbookEntry}',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesController@destroy'
		);

		Route::get(
			'/entries/{logbookEntry}/comments',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesCommentsController@index'
		);

		Route::post(
			'/entries/{logbookEntry}/comments',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesCommentsController@store'
		);

		Route::put(
			'/entries/{logbookEntry}/comments/{comment}',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesCommentsController@update'
		);

		Route::delete(
			'/entries/{logbookEntry}/comments/{comment}',
			'\TrainingTracker\Http\LogbookEntries\Controllers\Api\LogbookEntriesCommentsController@destroy'
		);

		Route::get('/notifications', '\TrainingTracker\Http\Notifications\Controllers\NotificationsController@index');

		Route::get(
			'/notifications/{notificationId}', 
			'\TrainingTracker\Http\Notifications\Controllers\Api\NotificationsController@show'
		);
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

		Route::get('/{objective}/edit', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController@edit');
		Route::put('/{objective}', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController@update');

		Route::delete('/{objective}', '\TrainingTracker\Http\Objectives\Controllers\ObjectivesController@destroy');
	});
});

Route::middleware(['role:administrator|head_of_operations'])->group(function () {
	Route::prefix('users/{user}')->group(function () {
		Route::post('/userlessons/{userlesson}/comments', '\TrainingTracker\Http\UserLessons\Controllers\Api\UserlessonCommentController@store');
	});
});
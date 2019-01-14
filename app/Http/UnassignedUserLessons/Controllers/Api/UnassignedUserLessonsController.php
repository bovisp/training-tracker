<?php

namespace TrainingTracker\Http\UnassignedUserLessons\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UnassignedUserLessons\Requests\StoreUnassignedUserLessonRequest;

class UnassignedUserLessonsController extends Controller
{
	public function index(User $user)
	{
		return $user->getUnassignedUserLessons();
	}

	public function store(StoreUnassignedUserLessonRequest $request, User $user)
	{
		UserLesson::create([
			'user_id' => $user->id,
			'lesson_id' => request('userlesson')
		]);

		return response()->json([
            'flash' => trans('app.flash.unassigneduserlessonadded')
        ]);
	}
}

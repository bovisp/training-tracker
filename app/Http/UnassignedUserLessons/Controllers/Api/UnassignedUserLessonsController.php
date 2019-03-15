<?php

namespace TrainingTracker\Http\UnassignedUserLessons\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Objectives\Objective;
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
		$userlesson = UserLesson::create([
			'user_id' => $user->id,
			'lesson_id' => request('userlesson')
		]);

		$this->createLogbooks($userlesson->lesson, $userlesson);

		return response()->json([
      'flash' => trans('app.flash.unassigneduserlessonadded')
    ]);
	}

	protected function createLogbooks(Lesson $lesson, UserLesson $userlesson)
  {
    $lesson->objectives->each(function ($objective) use ($userlesson) {
      $this->createLogbook($objective, $userlesson);
    });
  }

  protected function createLogbook(Objective $objective, UserLesson $userlesson)
  {
    if ($objective->notebook_required === 1) {
      Logbook::create([
        'objective_id' => $objective->id,
        'userlesson_id' => $userlesson->id
      ]);
    }
  }
}

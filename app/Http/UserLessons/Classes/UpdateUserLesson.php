<?php

namespace TrainingTracker\Http\UserLessons\Classes;

use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UserLessons\Requests\UpdateStatusesRequest;
use TrainingTracker\Http\UserLessons\Requests\UpdateObjectivesRequest;
use TrainingTracker\Http\UserLessons\Requests\UpdateCompletedRequest;

class UpdateUserLesson {
	protected $user;

	protected $userlesson;

	protected $methods = [
		'administrator' => ['statuses', 'objectives', 'completed'],
		'manager' => ['completed'],
		'head_of_operations' => ['statuses', 'objectives', 'completed'],
		'supervisor' => ['statuses', 'objectives']
	];

	public function __construct(User $user, UserLesson $userlesson)
	{
		$this->user = $user;
		$this->userlesson = $userlesson;
	}

	public function update()
	{
		if (moodleauth()->user()->hasRole('apprentice')) {
			return [
				'errors' => [
					'denied' => trans('app.errors.general.denied')
				]
			];
		}

		return $this->persist(
			$this->methods[moodleauth()->user()->roles->first()->type], $this->userlesson
		);
	}

	protected function persist($actions, $userlesson)
	{
		$errors = [];

		foreach ($actions as $action) {
			$actionClass = 'TrainingTracker\Http\UserLessons\Requests\Update' . ucfirst($action) . 'Request';

			$classErrors = (new $actionClass(request($action), $userlesson))->validate();
	
			if (!empty($classErrors)) {
				foreach ($classErrors as $error) {
					$errors[key($error['errors'])] = current($error['errors']);
				}
			}
		}

		return $errors;
	}
}
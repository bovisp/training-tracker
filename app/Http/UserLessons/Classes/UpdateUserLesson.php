<?php

namespace TrainingTracker\Http\UserLessons\Classes;

use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UserLessons\Requests\UpdateStatusesRequest;

class UpdateUserLesson {
	protected $user;

	protected $userlesson;

	protected $methods = [
		'administrator' => ['statuses'],
		'manager' => ['statuses'],
		'head_of_operations' => ['statuses']
	];
	// protected $methods = [
	// 	'administrator' => ['statuses', 'objectives', 'comment', 'completed'],
	// 	'manager' => ['statuses', 'objectives', 'comment', 'completed'],
	// 	'head_of_operations' => ['statuses', 'objectives', 'comment']
	// ];

	public function __construct($user, $userlesson)
	{
		$this->user = $user;
		$this->userlesson = $userlesson;
	}

	public function update(User $user, UserLesson $userlesson)
	{
		if (moodleauth()->user()->hasRole('apprentice')) {
			return [
				'errors' => ['denied' => 'You do not have permission to do this']
			];
		}

		return $this->persist(
			$this->methods[moodleauth()->user()->roles->first()->type], $userlesson
		);
	}

	protected function persist($actions, $userlesson)
	{
		$errors = [];

		foreach ($actions as $action) {
			$actionClass = 'TrainingTracker\Http\UserLessons\Requests\Update' . ucfirst($action) . 'Request';

			$classErrors = (new $actionClass(request($action), $userlesson))->validate();
			
			if (count($classErrors)) {
				$errors = array_column($classErrors, 'errors')[0];
			}
		}

		return $errors;
	}
}
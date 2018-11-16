<?php

namespace TrainingTracker\Domains\UserLessons;

use TrainingTracker\Domains\UserLessons\UserLesson;

class UserLessonObserver
{
	public function deleting(UserLesson $userlesson)
	{
		// Delete all associated user lesson packages
		$userlesson->logbooks->each->entries->each->comments->each->delete();
		$userlesson->logbooks->each->entries->each->delete();
		$userlesson->logbooks->each->delete();

		// Delete all comments associated with a userlesson
		$userlesson->comments->each->delete();

		// Delete all completed objectives
		$userlesson->user->objectives()->detach();
	}
}
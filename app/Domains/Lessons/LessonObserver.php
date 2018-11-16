<?php

namespace TrainingTracker\Domains\Lessons;

use TrainingTracker\Domains\Lessons\Lesson;

class LessonObserver
{
	public function deleting(Lesson $lesson)
	{
		// Delete all associated objectives
		$lesson->objectives->each->delete();

		// Delete all associated lesson packages
		$lesson->userlessons->each->delete();
	}
}
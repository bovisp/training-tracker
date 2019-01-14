<?php

namespace TrainingTracker\Domains\Levels;

use TrainingTracker\Domains\Levels\Level;

class LevelObserver
{
	public function deleting(Level $level)
	{
		// Delete all associated lessons
		$level->lessons->each->delete();
	}
}
<?php

namespace TrainingTracker\App\Facades;

use Illuminate\Support\Facades\Facade;

class MoodleAuth extends Facade
{
	protected static function getFacadeAccessor() { return 'moodleauth'; }
}
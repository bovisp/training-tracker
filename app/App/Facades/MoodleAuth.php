<?php

namespace TrainingTracker\App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Creates the facade that allows TrainingTracker to query the authentication, 
 * authorization and profile of Moodle users.
 */
class MoodleAuth extends Facade
{
	protected static function getFacadeAccessor() { return 'moodleauth'; }
}
<?php

/**
 * A helper function wrapper for the MoodleAuth facade.
 * 
 * @return object \TrainingTracker\App\Classes\Auth
 */
function moodleauth()
{
    return new TrainingTracker\App\Classes\Auth;
}
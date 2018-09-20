<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\UserLessons\UserLesson;

trait HasUserLessonsTrait
{
	public function userlessons()
    {
        return $this->hasMany(UserLesson::class);
    }

    public function hasLessons()
    {
        return $this->userlessons()->count() > 0;
    }

    public function getUnassignedUserLessons()
    {
        $result = [];

        $unassignedNonDepricatedLessonIds = array_values(
            array_diff(
                Lesson::whereDepricated(0)
                    ->pluck('id')
                    ->toArray(), 
                UserLesson::whereUserId($this->id)
                    ->pluck('lesson_id')
                    ->toArray()
            )
        );

        $unassignedDepricatedLessonIds = array_values(
            array_diff(
                Lesson::whereDepricated(1)
                    ->pluck('id')
                    ->toArray(), 
                UserLesson::whereUserId($this->id)
                    ->pluck('lesson_id')
                    ->toArray()
            )
        );

        if (count($unassignedNonDepricatedLessonIds)) {
            $unassignedNonDepricatedLessons = 
                Lesson::whereIn('id', $unassignedNonDepricatedLessonIds)
                    ->with('topic')
                    ->get();

            $result['non_depricated'] = $unassignedNonDepricatedLessons;
        }

        if (count($unassignedDepricatedLessonIds)) {
            $unassignedDepricatedLessons = 
                Lesson::whereIn('id', $unassignedDepricatedLessonIds)
                    ->with('topic')
                    ->get();

            $result['depricated'] = $unassignedDepricatedLessons;
        }

        return $result;
    }

    public function hasUnassignedLessons()
    {
        if (!$this->hasLessons()) {
            return false;
        }

        return count($this->getUnassignedUserLessons()) > 0;
    }
}
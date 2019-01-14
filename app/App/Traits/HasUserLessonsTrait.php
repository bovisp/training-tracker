<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\UserLessons\UserLesson;

trait HasUserLessonsTrait
{
	public function userlessons()
    {
        return $this->hasMany(UserLesson::class);
    }

    public function logbooks()
    {
        return $this->hasManyThrough(
            Logbook::class,
            UserLesson::class,
            'user_id',
            'userlesson_id',
            'id',
            'id'
        )->with(['objective']);
    }

    public function hasLessons()
    {
        return $this->userlessons()->count() > 0;
    }

    public function getUnassignedUserLessons()
    {
        $result = [];

        $unassignedNonDepricatedLessonIds = $this->getUnassignedNonDepricatedLessonIds();

        $unassignedDepricatedLessonIds = $this->getUnassignedDepricatedLessonIds(); 

        if (count($unassignedNonDepricatedLessonIds)) {
            $result['non_depricated'] = $this->getUnassignedNonDepricatedLessons($unassignedNonDepricatedLessonIds);
        }

        if (count($unassignedDepricatedLessonIds)) {
            $result['depricated'] = $this->getUnassignedDepricatedLessons($unassignedDepricatedLessonIds);
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

    protected function getUnassignedNonDepricatedLessonIds()
    {
        return array_values(
            array_diff(
                Lesson::whereDepricated(0)
                    ->pluck('id')
                    ->toArray(), 
                UserLesson::whereUserId($this->id)
                    ->pluck('lesson_id')
                    ->toArray()
            )
        );
    }

    protected function getUnassignedDepricatedLessonIds()
    {
        return array_values(
            array_diff(
                Lesson::whereDepricated(1)
                    ->pluck('id')
                    ->toArray(), 
                UserLesson::whereUserId($this->id)
                    ->pluck('lesson_id')
                    ->toArray()
            )
        );
    }

    protected function getUnassignedNonDepricatedLessons($unassignedNonDepricatedLessonIds)
    {
        return Lesson::whereIn('id', $unassignedNonDepricatedLessonIds)
            ->with('level')
            ->get();
    }

    protected function getUnassignedDepricatedLessons()
    {
        return Lesson::whereIn('id', $unassignedDepricatedLessonIds)
            ->with('level')
            ->get();
    }
}
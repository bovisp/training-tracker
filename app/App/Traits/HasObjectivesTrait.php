<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\UserLessons\UserLesson;

trait HasObjectivesTrait
{
	public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'users_objectives');
    }

    public function completedObjectives()
    {
        return $this->objectives()
            ->pluck('objective_id')
            ->toArray();
    }

    public function updateObjectives(UserLesson $userlesson)
    {
        $allObjectivesForUserlesson = $userlesson->lesson->objectives->pluck('id');
        $this->objectives()->detach($allObjectivesForUserlesson);

        $this->objectives()->attach(request('objectives'));
    }
}
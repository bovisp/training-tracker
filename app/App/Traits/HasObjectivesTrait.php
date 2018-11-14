<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Objectives\Objective;

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

    public function updateObjectives($allObjectives, $newobjectives)
    {
        $this->objectives()->detach($allObjectives);

        $this->objectives()->attach($newobjectives);
    }
}
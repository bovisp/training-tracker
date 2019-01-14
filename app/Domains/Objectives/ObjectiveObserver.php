<?php

namespace TrainingTracker\Domains\Objectives;

use Illuminate\Support\Facades\DB;

class ObjectiveObserver
{
	public function deleting(Objective $objective)
	{
		DB::table('users_objectives')->whereObjectiveId($objective->id)->delete();
	}
}
<?php

namespace TrainingTracker\Http\Objectives\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\Objectives\Objective;

class ObjectivesController extends DatatablesController
{
	public function builder()
    {
        return Objective::query();
    }

    public function getDisplayableColumns()
    {
        return ['id', 'topic_id', 'number', 'name'];
    }

    public function index()
    {
        return response()->json([
            'data' => [
                'records' => $this->getRecords(),
                'displayable' => $this->getDisplayableColumns(),
            ]
        ]); 
    }

    protected function getRecords()
    {
        $objectives = [];

        foreach(Objective::with('lesson')->get() as $objective) {
            $objectives[] = [
                'id' => $objective->id,
                'topic' => $objective->lesson->number,
                'number' => $objective->number,
                'name' => $objective->name
            ];
        }

        return $objectives;
    }
}

<?php

namespace TrainingTracker\Http\UserLessons\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\UserLessons\UserLesson;


class UserLessonsController extends DatatablesController
{

	public function builder()
    {
        return Topic::query();
    }

    public function getDisplayableColumns()
    {
        return ['id', 'number', 'name'];
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
}

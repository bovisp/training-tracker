<?php

namespace TrainingTracker\Http\Topics\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\Topics\Topic;


class TopicsController extends DatatablesController
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

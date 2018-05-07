<?php

namespace TrainingTracker\Http\Lessons\Controllers\Api;

use TrainingTracker\App\Controllers\DatatablesController;
use TrainingTracker\Domains\Lessons\Lesson;


class LessonsController extends DatatablesController
{
	public function builder()
    {
        return Lesson::query();
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
        $lessons = [];

        foreach(Lesson::with('topic')->get() as $lesson) {
            $lessons[] = [
                'id' => $lesson->id,
                'topic' => $lesson->topic->number,
                'number' => $lesson->number,
                'name' => $lesson->name
            ];
        }

        return $lessons;
    }
}

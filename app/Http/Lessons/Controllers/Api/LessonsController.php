<?php

namespace TrainingTracker\Http\Lessons\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Http\Lessons\Resources\LessonResource;

class LessonsController extends Controller
{
    public function index()
    {
        return [
            'records' => LessonResource::collection(Lesson::all()),
            'meta' => [
                'displayable' => [
                    ['field' => 'lesson', 'label' => 'Lesson', 'sortable' => 'sortable'],
                    ['field' => 'name', 'label' => 'Name', 'sortable' => 'sortable'],
                    ['field' => 'depricated', 'label' => 'Depricated', 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'lesson', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/lessons/',
                    'endpointSuffix' => '/edit',
                    'text' => 'Edit'
                ]
            ]
        ];
    }
}

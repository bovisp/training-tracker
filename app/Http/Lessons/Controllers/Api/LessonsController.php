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
                    ['key' => 'lesson', 'title' => 'Lesson'],
                    ['key' => 'name', 'title' => 'Name'],
                    ['key' => 'depricated', 'title' => 'Depricated']
                ],
                'orderby' => [
                    ['key' => 'lesson', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => '/lessons/',
                    'endpointSuffix' => '/edit',
                    'text' => 'Edit'
                ]
            ]
        ];
    }
}

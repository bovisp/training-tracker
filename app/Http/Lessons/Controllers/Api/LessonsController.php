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
                    ['field' => 'level', 'label' => trans('app.datatable.label.level'), 'sortable' => 'sortable'],
                    ['field' => 'lesson', 'label' => trans('app.datatable.label.lesson'), 'sortable' => 'sortable'],
                    ['field' => 'name', 'label' => trans('app.datatable.label.name'), 'sortable' => 'sortable'],
                    ['field' => 'depricated', 'label' => trans('app.datatable.label.depricated'), 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'level', 'dir' => 'asc'],
                    ['key' => 'lesson', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/lessons/',
                    'endpointSuffix' => '/edit',
                    'text' => trans('app.datatable.buttons.edit')
                ]
            ]
        ];
    }
}

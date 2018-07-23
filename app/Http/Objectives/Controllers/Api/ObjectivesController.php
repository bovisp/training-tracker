<?php

namespace TrainingTracker\Http\Objectives\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Http\Objectives\Resources\ObjectiveResource;

class ObjectivesController extends Controller
{
	public function index()
    {
        return [
            'records' => ObjectiveResource::collection(Objective::all()),
            'meta' => [
                'displayable' => [
                    ['key' => 'lesson', 'title' => 'Lesson'],
                    ['key' => 'objective', 'title' => 'Objective'],
                    ['key' => 'description', 'title' => 'Description']
                ],
                'orderby' => [
                    ['key' => 'lesson', 'dir' => 'asc'],
                    ['key' => 'number', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => '/objectives/',
                    'endpointSuffix' => '/edit',
                    'text' => 'Edit'
                ]
            ]
        ];
    }
}

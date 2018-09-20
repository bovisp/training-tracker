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
                    ['field' => 'lesson', 'label' => 'Lesson', 'sortable' => 'sortable'],
                    ['field' => 'objective', 'label' => 'Objective', 'sortable' => 'sortable'],
                    ['field' => 'description', 'label' => 'Description', 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'lesson', 'dir' => 'asc'],
                    ['key' => 'objective', 'dir' => 'asc']
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

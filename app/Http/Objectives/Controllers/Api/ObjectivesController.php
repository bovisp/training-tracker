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
                    ['field' => 'lesson', 'label' => trans('app.datatable.label.lesson'), 'sortable' => 'sortable'],
                    ['field' => 'objective', 'label' => trans('app.datatable.label.objective'), 'sortable' => 'sortable'],
                    ['field' => 'description', 'label' => trans('app.datatable.label.description'), 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'lesson', 'dir' => 'asc'],
                    ['key' => 'objective', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/objectives/',
                    'endpointSuffix' => '/edit',
                    'text' => trans('app.datatable.buttons.edit')
                ]
            ]
        ];
    }
}

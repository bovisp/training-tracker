<?php

namespace TrainingTracker\Http\Levels\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Levels\Level;
use TrainingTracker\Http\Levels\Resources\LevelResource;

class LevelsController extends Controller
{
    public function index()
    {
        return [
            'records' => LevelResource::collection(Level::all()),
            'meta' => [
                'displayable' => [
                    ['field' => 'name', 'label' => trans('app.datatable.label.name'), 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'name', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/levels/',
                    'endpointSuffix' => '/edit',
                    'text' => trans('app.datatable.buttons.edit')
                ]
            ]
        ];
    }
}

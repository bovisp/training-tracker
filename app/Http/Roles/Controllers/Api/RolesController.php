<?php

namespace TrainingTracker\Http\Roles\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Http\Roles\Resources\RoleResource;


class RolesController extends Controller
{
    public function index()
    {
        return [
            'records' => RoleResource::collection(Role::all()),
            'meta' => [
                'displayable' => [
                    ['field' => 'name', 'label' => trans('app.datatable.label.name'), 'sortable' => 'sortable'],
                    ['field' => 'type', 'label' => trans('app.datatable.label.type'), 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'rank', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/roles/',
                    'endpointSuffix' => '/edit',
                    'text' => trans('app.datatable.buttons.edit')
                ]
            ]
        ];
    }
}

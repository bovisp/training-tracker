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
                    ['key' => 'type', 'title' => 'Type'],
                    ['key' => 'name', 'title' => 'Name']
                ],
                'orderby' => [
                    ['key' => 'rank', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => '/roles/',
                    'endpointSuffix' => '/edit',
                    'text' => 'Edit'
                ]
            ]
        ];
    }
}

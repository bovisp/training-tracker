<?php

namespace TrainingTracker\Http\Users\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Roles\Resources\RoleResource;
use TrainingTracker\Http\Users\Requests\StoreUsersSpreadsheet;
use TrainingTracker\Http\Users\Requests\UpdateAppointmentUserRequest;
use TrainingTracker\Http\Users\Resources\UserCreateResource;
use TrainingTracker\Http\Users\Resources\UserResource;

class UsersController extends Controller
{
	public function index()
    {
        return [
            'records' => UserResource::collection(User::whereActive(1)->get()),
            'meta' => [
                'displayable' => [
                    ['field' => 'firstname', 'label' => 'First name', 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => 'Last name', 'sortable' => 'sortable'],
                    ['field' => 'email', 'label' => 'E-mail', 'sortable' => 'sortable'],
                    ['field' => 'roleName', 'label' => 'Role', 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'lastname', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => '/users/',
                    'endpointSuffix' => '',
                    'text' => 'Profile'
                ]
            ]
        ];
    }

    public function create()
    {
        return [
            'records' => UserCreateResource::collection(User::notIn()),
            'roles' => RoleResource::collection(Role::all()),
            'meta' => [
                'displayable' => [
                    ['field' => 'firstname', 'label' => 'First name', 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => 'Last name', 'sortable' => 'sortable'],
                    ['field' => 'email', 'label' => 'E-mail', 'sortable' => 'sortable'],
                ],
                'orderby' => [
                    ['key' => 'lastname', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => false
                ]
            ]
        ];
    }

    public function store()
    {
        $validations = new StoreUsersSpreadsheet(request()->all());

        if (count($validations->validate())) {
            return response()->json([
                'errors' => $validations->validate()
            ], 422);
        } else {
            return response()->json([
                'flash' => 'users added successfully!'
            ]);
        }
    }
}

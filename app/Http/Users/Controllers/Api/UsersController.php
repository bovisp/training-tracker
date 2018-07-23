<?php

namespace TrainingTracker\Http\Users\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;
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
                    ['key' => 'firstname', 'title' => 'First name'],
                    ['key' => 'lastname', 'title' => 'Last name'],
                    ['key' => 'email', 'title' => 'E-mail'],
                    ['key' => 'role', 'title' => 'Role']
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
            'meta' => [
                'displayable' => [
                    ['key' => 'firstname', 'title' => 'First name'],
                    ['key' => 'lastname', 'title' => 'Last name'],
                    ['key' => 'email', 'title' => 'E-mail']
                ],
                'orderby' => [
                    ['key' => 'lastname', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => false
                ],
                'roles' => Role::all()
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

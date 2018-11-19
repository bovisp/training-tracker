<?php

namespace TrainingTracker\Http\Users\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Roles\Resources\RoleResource;
use TrainingTracker\Http\Users\Classes\CreateUser;
use TrainingTracker\Http\Users\Requests\StoreUsersRequest;
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
                    ['field' => 'firstname', 'label' => trans('app.datatable.label.firstname'), 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => trans('app.datatable.label.lastname'), 'sortable' => 'sortable'],
                    ['field' => 'email', 'label' => trans('app.datatable.label.email'), 'sortable' => 'sortable'],
                    ['field' => 'roleName', 'label' => trans('app.datatable.label.role'), 'sortable' => 'sortable']
                ],
                'orderby' => [
                    ['key' => 'lastname', 'dir' => 'asc']
                ],
                'actionButton' => [
                    'active' => true,
                    'endpoint' => env('APP_URL') . '/users/',
                    'endpointSuffix' => '',
                    'text' => trans('app.datatable.buttons.profile')
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
                    ['field' => 'firstname', 'label' => trans('app.datatable.label.firstname'), 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => trans('app.datatable.label.lastname'), 'sortable' => 'sortable'],
                    ['field' => 'email', 'label' => trans('app.datatable.label.email'), 'sortable' => 'sortable'],
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

    public function store(StoreUsersRequest $request)
    {
        (new CreateUser)->add();

        return response()->json([
            'flash' => trans('app.flash.usersadded')
        ], 200);
    }
}

<?php

namespace TrainingTracker\Http\UsersReporting\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UsersReporting\Classes\UpdateUserReporting;
use TrainingTracker\Http\UsersReporting\Requests\UpdateUsersReportingRequest;

class UsersReportingController extends Controller
{
    public function index(User $user, Role $role)
    {
        return [
            'linkUsers' => true,
            'records' => Role::with('users')
                ->find($role->id)
                ->users
                ->map(function($u) use ($user) {
                    return [
                        'id' => $u->id,
                        'firstname' => $u->firstname,
                        'lastname' => $u->lastname,
                        'checked' => !! $user->reportingStructure()->where('id', $u->id)->count() > 0
                    ];
                })
                ->toArray(),
            'meta' => [
                'displayable' => [
                    ['field' => 'firstname', 'label' => trans('app.datatable.label.firstname'), 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => trans('app.datatable.label.lastname'), 'sortable' => 'sortable'],
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

    public function store(UpdateUsersReportingRequest $request, User $user, Role $role)
    {
        (new UpdateUserReporting($user, $role))->update();
    }
}

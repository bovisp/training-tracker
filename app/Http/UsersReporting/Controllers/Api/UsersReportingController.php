<?php

namespace TrainingTracker\Http\UsersReporting\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UsersReporting\Requests\StoreUsersReportingSpreadsheet;
use TrainingTracker\Http\Users\Resources\UserResource;

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
                    ['field' => 'firstname', 'label' => 'First name', 'sortable' => 'sortable'],
                    ['field' => 'lastname', 'label' => 'Last name', 'sortable' => 'sortable'],
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

    public function store(User $user, Role $role)
    {
        $this->detachUsers($user, $role);

        $this->attachUsers($user, $role);

       //  $validations = new StoreUsersReportingSpreadsheet(request()->all(), $role, $user);

       // if (count($validations->validate())) {
       //      return response()->json([
       //          'errors' => $validations->validate()
       //      ], 422);
       //  } else {
       //      return response()->json([
       //          'flash' => 'users added successfully!'
       //      ]);
       //  }
    }

    protected function detachUsers(User $user, Role $role)
    {
        $isSupervisor = $user->roles->first()->rank < $role->rank;

        if ($isSupervisor) {

            $userIds = collect(request()->all())->pluck('id')->toArray();

            $user->supervisor->users()->detach($userIds);

            return;
        }

        $userIds = collect(request()->all())->pluck('id')->toArray();

        $supervisorIds = [];

        foreach($userIds as $userId) {
            $supervisorIds[] = Supervisor::whereUserId($userId)->first()->id;
        }

        $user->supervisors()->detach($supervisorIds);

        return;
    }

    protected function attachUsers(User $user, Role $role)
    {
        $isSupervisor = $user->roles->first()->rank < $role->rank;

        if ($isSupervisor) {

            $userIds = collect(request()->all())->pluck('id')->toArray();

            $user->supervisor->users()->attach($userIds);

            return;
        }

        $userIds = collect(request()->all())->pluck('id')->toArray();

        $supervisorIds = [];

        foreach($userIds as $userId) {
            $supervisorIds[] = Supervisor::whereUserId($userId)->first()->id;
        }

        $user->supervisors()->attach($supervisorIds);

        return;
    }
}

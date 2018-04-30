<?php

namespace TrainingTracker\Http\UsersReporting\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UsersReporting\Requests\StoreUsersReportingSpreadsheet;

class UsersReportingController extends Controller
{

	public function index(User $user, Role $role)
    {
        if (in_array($role->type, $user->supervisorRoles())) {
            $currentSupervisorsWithRole = $user->supervisorsWithRoleOf($role);
        } else {
            $currentEmployeesWithRole = $user->employeesWithRoleOf($role);
        }

        return response()->json([
            'data' => [
                'records' => $this->getRecords($role),
                'displayable' => ["id", "firstname", "lastname"],
                'checked' => $currentSupervisorsWithRole ?? $currentEmployeesWithRole
            ]
        ]); 
    }

    public function store(User $user, Role $role)
    {
        $validations = new StoreUsersReportingSpreadsheet(request()->all(), $role, $user);

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

    protected function getRecords(Role $role)
    {
        return Role::with('users')
            ->find($role->id)
            ->users
            ->map(function($u) {
                return [
                    'id' => $u->id,
                    'firstname' => $u->firstname,
                    'lastname' => $u->lastname
                ];
            })
            ->toArray();
    }
}

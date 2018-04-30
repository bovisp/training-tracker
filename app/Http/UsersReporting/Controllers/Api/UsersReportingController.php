<?php

namespace TrainingTracker\Http\UsersReporting\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;

class UsersReportingController extends Controller
{

	public function index(User $user, Role $role)
    {
        if (in_array($role->type, $user->supervisorRoles())) {
            $currentSupervisorsWithRole = $user->supervisors->map(function($s) use ($role) {
                if ($s->user()->first()->hasRole($role->type)) {
                    return $s->user_id;
                }
            });
        } else {
            $supervisor = Supervisor::whereUserId($user->id)->first();

            $currentEmployeesWithRole = $supervisor->users->map(function($u) use ($role) {
                if ($u->hasRole($role->type)) {
                    return $u->id;
                }
            });
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
        if (in_array($role->type, $user->supervisorRoles())) {
            $currentSupervisorsWithRole = $user->supervisors->map(function($s) use ($role) {
                if ($s->user()->first()->hasRole($role->type)) {
                    return $s->id;
                }
            });        

            $supervisorsFromRequest = array_map(function($u) {
                return Supervisor::whereUserId(array_values($u)[0])->first()->id;
            }, request()->all());

            $user->supervisors()->detach($currentSupervisorsWithRole);

            $user->supervisors()->attach($supervisorsFromRequest);
        } else if (in_array($role->type, $user->employeeRoles())) {
            $supervisor = Supervisor::whereUserId($user->id)->first();

            $currentEmployeesWithRole = $supervisor->users->map(function($u) use ($role) {
                if ($u->hasRole($role->type)) {
                    return $s->id;
                }
            });

            $employeesFromRequest = array_map(function($u) {
                return array_values($u)[0];
            }, request()->all());

            $supervisor->users()->detach($currentEmployeesWithRole);

            $supervisor->users()->attach($employeesFromRequest);
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

<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Supervisors\Supervisor;

trait HasSupervisorsTrait
{
    public $superviseesArray = [];

	public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'users_supervisors');
    }

    public function canSupervise()
    {
        return Role::whereRank($this->roles()->first()->rank + 1)->exists();
    }

    public function employeeRoles()
    {
        return Role::where('rank', '>', $this->roles()->first()->rank)
            ->get()
            ->pluck('type')
            ->toArray();
    }

    public function isSupervised()
    {
    	return Role::whereRank($this->roles()->first()->rank - 1)->exists();
    }

    public function supervisorRoles()
    {
        return Role::where('rank', '<', $this->roles()->first()->rank)
            ->get()
            ->pluck('type')
            ->toArray();
    }

    public function directlyManagesRole()
    {
        if (!Role::whereRank($this->roles()->first()->rank + 1)->exists()) {
            return '';
        }

        return Role::whereRank($this->roles()->first()->rank + 1)
            ->first()
            ->type;
    }

    public function usersSupervisors($user, $arr = [])
    {
        if ($user->supervisors->count()) {
            $supervisor = $user->supervisors->first()->user;

            $role = $user->supervisors->first()->user->roles()->first()->type;

            $arr[$role][] = [
             'name' => $user->supervisors->first()->user->moodleuser->firstname . ' ' . $user->supervisors->first()->user->moodleuser->lastname,
             'id' => $user->supervisors->first()->user->id
            ];

            if($supervisor->isSupervised()) {
                $arr =  $this->usersSupervisors($supervisor, $arr);
            }
        }

		return $arr;
    }

    public function usersSupervisees($user1, $arr = [])
    {
        if ($user1->canSupervise()) {
            $supervisor = Supervisor::where('user_id', $user1->id)->first();

    		foreach($supervisor->users as $user) {
    			$role = $user->roles()->first()->type;

    			$arr[$role][] = [
    				'name' => $user->moodleuser->firstname . ' ' . $user->moodleuser->lastname,
    				'id' => $user->id
    			];

                if($user->canSupervise()) {
                    $arr =  $this->usersSupervisees($user, $arr);
                }
    		}
        }

        return $arr;
    }

    public function isSupervisedBy()
    {
    	$supervisor = Supervisor::where('user_id', moodleauth()->user()->id)->first();

    	return $this->supervisors->contains($supervisor);
    }

    public function supervisorsWithRoleOf($role)
    {
        return $this->supervisors->map(function($s) use ($role) {
            if ($s->user()->first()->hasRole($role->type)) {
                return $s->user_id;
            }
        });
    }

    public function employeesWithRoleOf($role)
    {
        $supervisor = Supervisor::whereUserId($this->id)->first();

        return $supervisor->users->map(function($u) use ($role) {
            if ($u->hasRole($role->type)) {
                return $u->id;
            }
        });
    }

    public function hasThisSupervisorWithRoleOf($arr)
    {
        return count(
            array_filter($arr, function($role) {
                return in_array(
                    (string) moodleauth()->id(), array_column($this->usersSupervisors($this)[$role], 'id')
                );
            })
        );
    }
}
<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Supervisors\Supervisor;

trait HasSupervisorsTrait
{
	protected $roleOrder = [
		'manager', 'head_of_operations', 'supervisor', 'apprentice'
	];

	public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'users_supervisors');
    }

    public function canSupervise()
    {
    	return array_key_exists($this->roleKey() + 1, $this->roleOrder);
    }

    public function employeeRoles()
    {
        return array_slice($this->roleOrder, $this->roleKey() + 1);
    }

    public function isSupervised()
    {
    	return array_key_exists($this->roleKey() - 1, $this->roleOrder);
    }

    public function supervisorRoles()
    {
        return array_slice($this->roleOrder, 0, $this->roleKey());
    }

    public function usersSupervisors()
    {
    	if ($this->isSupervised()) {
    		$supervisorsArray = [];

    		foreach($this->supervisors as $supervisor) {
    			$role = $supervisor->user->roles->first()->type;
    			
    			$supervisorsArray[$role][] = [
    				'name' => $supervisor->user->moodleuser->firstname . ' ' . $supervisor->user->moodleuser->lastname,
    				'id' => $supervisor->user->id
    			];
    		}

    		return $supervisorsArray;
    	}
    }

    public function usersSupervisees()
    {
    	if ($this->canSupervise()) {
    		$superviseesArray = [];

    		$supervisor = Supervisor::where('user_id', $this->id)->first();

    		foreach($supervisor->users as $user) {
    			$role = $user->roles()->first()->type;

    			$superviseesArray[$role][] = [
    				'name' => $user->moodleuser->firstname . ' ' . $user->moodleuser->lastname,
    				'id' => $user->id
    			];
    		}

    		return $superviseesArray;
    	}
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

    protected function roleKey()
    {
    	return (int) array_search($this->roles()->first()->type, $this->roleOrder);
    }
}
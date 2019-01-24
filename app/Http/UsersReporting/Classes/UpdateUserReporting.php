<?php

namespace TrainingTracker\Http\UsersReporting\Classes;

use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;

class UpdateUserReporting
{
	protected $user;
	protected $role;

	public function __construct(User $user, Role $role)
	{
		$this->user = $user;
		$this->role = $role;
	}

	public function update()
	{
		$this->detachUsers();

        $this->attachUsers();
	}

	protected function detachUsers()
    {
        $isSupervisor = $this->user->roles->first()->rank < $this->role->rank;

        if ($isSupervisor) {
            $this->detachEmployees();

            return;
        }

        $this->detachSupervisors();

        return;
    }

    protected function attachUsers()
    {
        $isSupervisor = $this->user->roles->first()->rank < $this->role->rank;

        if ($isSupervisor) {
            $this->attachEmployees();

            return;
        }

        $this->attachSupervisors();

        return;
    }

    protected function detachEmployees()
    {
        if (optional($this->user->supervisor)->users !== null) {
            $idsToDetach = $this->user
                ->supervisor
                ->users
                ->filter(function ($u) {
                    return $u->roles->first()->rank === $this->role->rank;
                })
                ->pluck('id');

            $this->user->supervisor->users()->detach($idsToDetach);
        }
    }

    protected function detachSupervisors()
    {
        if (optional($this->user->supervisors) !== null) {
            $idsToDetach = $this->user
                ->supervisors
                ->filter(function ($sup) {
                    return $sup->role()->rank === $this->role->rank;
                })
                ->pluck('id');

            $this->user->supervisors()->detach($idsToDetach);
        }
    }

    protected function attachEmployees()
    {
        $idsToAttach = array_flatten(request()->all());

        $this->user->supervisor->users()->attach($idsToAttach);
    }

    protected function attachSupervisors()
    {
        $idsToAttach = Supervisor::whereIn('user_id', array_flatten(request()->all()))
            ->get()
            ->pluck('id')
            ->toArray();

        $this->user->supervisors()->attach($idsToAttach);
    }
}
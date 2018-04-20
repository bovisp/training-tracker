<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Supervisors\Supervisor;

trait HasSupervisorsTrait
{
	protected $roleOrder = [
		'admin', 'user'
	];

	public function supervisors()
    {
        return $this->belongsToMany(Supervisor::class, 'users_supervisors');
    }

    protected function canSupervise()
    {
    	return array_key_exists($this->roleKey() + 1, $this->roleOrder);
    }

    protected function isSupervised()
    {
    	return array_key_exists($this->roleKey() - 1, $this->roleOrder);
    }

    public function usersSupervisors()
    {
    	if ($this->isSupervised()) {
    		$supervisorsArray = [];

    		foreach($this->supervisors as $supervisor) {
    			$role = ($supervisor->user->first())->roles()->first()->type;
    			
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

    protected function roleKey()
    {
    	return (int) array_search($this->roles()->first()->type, $this->roleOrder);
    }
}
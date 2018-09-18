<?php

namespace TrainingTracker\Http\UsersReporting\Requests;

use Illuminate\Support\Facades\Validator;
use TrainingTracker\App\Interfaces\StoreSpreadsheet;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;

class StoreUsersReportingSpreadsheet implements StoreSpreadsheet
{
	protected $errors = [];

	protected $data;

	protected $role;

	protected $user;

	public function __construct($data, $role, $user)
	{
		$this->data = $data;
		$this->role = $role;
		$this->user = $user;
	}

	public function data()
	{
		return $this->data;
	}

	public function validate()
	{
		foreach ($this->data() as $row) {
			$this->validateRow($row);
		}

		return $this->errors;
	}

	public function validateRow($row)
	{
		$validator = Validator::make(
			$row, $this->validations(), $this->messages()
		);

		if (!$this->hasErrors($validator)) {
	        $this->persist($row);

	        return;	    	        
	    }

	    $this->errors[] = $this->getErrors($validator, $row);
	}

	public function persist($row)
	{
		$isSupervisor = $this->user->roles->first()->rank < $this->role->rank;

		if ($isSupervisor) {
			$usersToDetach = $this->user->supervisor->users->;
		}
		
		if (in_array($this->role->type, $this->user->supervisorRoles())) {
            $currentSupervisorsWithRole = $this->user->supervisorsWithRoleOf($this->role);        

            $supervisorsFromRequest = array_map(function($u) {
                return Supervisor::whereUserId(array_values($u)[0])->first()->id;
            }, $this->data);

            $this->user->supervisors()->detach($currentSupervisorsWithRole);

            $this->user->supervisors()->attach($supervisorsFromRequest);
        } else if (in_array($this->role->type, $this->user->employeeRoles())) {
            $currentEmployeesWithRole = $this->user->employeesWithRoleOf($this->role);

            $employeesFromRequest = array_map(function($u) {
                return array_values($u)[0];
            }, $this->data);

            $supervisor = Supervisor::whereUserId($this->user->id)->first();

            $supervisor->users()->detach($currentEmployeesWithRole);

            $supervisor->users()->attach($employeesFromRequest);
        }
	}

	public function messages ()
	{
		return [
			'id.required' => 'You have not checked the checkbox next to one or more of your selected users.',
			'id.exists' => 'The user with an id of :input does not exist in this application.'
		];
	}

	public function validations()
	{
		return [
            'id' => 'required|exists:users,id'
        ];
	}

	public function hasErrors($validator)
	{
		return count($validator->errors()->toArray());
	}

	public function getErrors($validator, $row)
	{
		return [
            "errors" => $validator->errors()->toArray(),
            "data" => $row
        ];
	}
}
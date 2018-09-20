<?php

namespace TrainingTracker\Http\Users\Requests;

use Illuminate\Support\Facades\Validator;
use TrainingTracker\App\Interfaces\StoreSpreadsheet;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class StoreUsersSpreadsheet implements StoreSpreadsheet
{
	protected $errors = [];

	protected $data;

	public function __construct($data)
	{
		$this->data = $data;
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
		$row = [
			'id' => (int) $row[0],
			'role' => $row[1]
		];

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
		$user = User::create([
            'moodle_id' => $row["id"]
        ])->assignRole($row["role"]);

        if ($user->hasRole(['manager', 'head_of_operations', 'supervisor'])) {
            Supervisor::create([ 
            	'user_id' => $user->id 
            ]);
        }

        if ($user->hasRole('apprentice')) {
            $this->createLessons($user);
        }
	}

	public function messages ()
	{
		return [
			'id.required' => 'You have not checked the checkbox next to one or more of your selected users.',
			'id.exists' => 'The user with an id of :input is not registered on Moodle. Please ask them to register.',
			'id.unique' => 'The user with an id of :input has already been added to this application.',
			'role.required' => 'You have not added a role for one or more selected users.',
			'role.exists' => 'The role :input does not exist'
		];
	}

	public function validations()
	{
		return [
            'id' => 'required|exists:mysql2.mdl_user,id|unique:users,moodle_id',
            'role' => 'required|exists:roles,type'
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

	protected function createLessons($user)
	{
		foreach (Lesson::whereDepricated(0)->get() as $lesson) {
            UserLesson::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id
            ]);
        }
	}
}
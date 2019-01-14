<?php

namespace TrainingTracker\Http\UserLessons\Requests;

use Illuminate\Support\Facades\Validator;
use TrainingTracker\App\Interfaces\StoreSpreadsheet;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class UpdateObjectivesRequest implements StoreSpreadsheet
{
	protected $errors = [];

	protected $data;

	protected $key;

	protected $userlesson;

	public function __construct($data, UserLesson $userlesson)
	{
		$this->data = $data;
		$this->userlesson = $userlesson;
	}

	public function data()
	{
		return $this->data;
	}

	public function validate()
	{
		$this->validateRow(request()->all());

		if (count($this->errors)) {
			$this->errors = [
				[
					'errors' => [
						'objectives' => [
							trans('app.errors.userlessons.objectives')
						]
					]
				]
			];

			return $this->errors;
		}
	}

	public function validateRow($data)
	{
		$validator = Validator::make(
			$data, $this->validations()
		);

		if (!$this->hasErrors($validator)) {
	        $this->persist($data);

	        return;	    	        
	    }

	    $this->errors[] = $this->getErrors($validator, $data);
	}

	public function persist($row)
	{
		$userlesson = Userlesson::find((int) explode('/', request()->path())[3]);
		
		$user = User::find((int) explode('/', request()->path())[1]);

		$objectives = Objective::where('lesson_id', $userlesson->lesson->id)
            ->pluck('id')
            ->toArray();

        $user->updateObjectives($objectives, request('objectives'));
	}

	public function messages ()
	{
		//
	}

	public function validations()
	{
		return [
            'objectives.*' => 'exists:objectives,id'
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
        ];
	}
}
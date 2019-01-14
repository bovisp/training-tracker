<?php

namespace TrainingTracker\Http\UserLessons\Requests;

use Illuminate\Support\Facades\Validator;
use TrainingTracker\App\Interfaces\StoreSpreadsheet;
use TrainingTracker\App\Rules\UserLessonCompleted;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;

class UpdateCompletedRequest implements StoreSpreadsheet
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

		return $this->errors;
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
		$this->userlesson->update([
			'completed' => request('completed')
		]);
	}

	public function messages ()
	{
		//
	}

	public function validations()
	{
		return [
            'completed' => [
            	'integer',
            	'min:0',
            	'max:1',
            	new UserLessonCompleted($this->userlesson->load([
            		'lesson.objectives', 'lesson', 'user', 'user.objectives'
            	]))
            ]
        ];
	}

	public function hasErrors($validator)
	{
		return !empty($validator->errors()->toArray());
	}

	public function getErrors($validator, $row)
	{
		return [
            "errors" => $validator->errors()->toArray(),
        ];
	}
}
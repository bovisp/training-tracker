<?php

namespace TrainingTracker\Http\UserLessons\Requests;

use Illuminate\Support\Facades\Validator;
use TrainingTracker\App\Interfaces\StoreSpreadsheet;
use TrainingTracker\App\Rules\StatusTypes;
use TrainingTracker\Domains\UserLessons\UserLesson;

class UpdateStatusesRequest implements StoreSpreadsheet
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
		foreach ($this->data() as $key => $row) {
			$this->key = $key;

			$this->validateRow($row);
		}

		return $this->errors;
	}

	public function validateRow($row)
	{
		$this->row = $row;

		$validator = Validator::make(
			[$this->key => $row], $this->validations()
		);

		if (!$this->hasErrors($validator)) {
	        $this->persist($row);

	        return;	    	        
	    }

	    $this->errors[] = $this->getErrors($validator, $row);
	}

	public function persist($row)
	{
		$this->userlesson->update([
            $this->key => $row
        ]);
	}

	public function messages ()
	{
		//
	}

	public function validations()
	{
		return [
            $this->key => [new StatusTypes($this->row)]
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
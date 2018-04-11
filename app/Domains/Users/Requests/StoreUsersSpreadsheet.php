<?php

namespace TrainingTracker\Domains\Users\Requests;

use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use TrainingTracker\App\Interfaces\StoreSpreadsheet;
use TrainingTracker\Domains\Users\User;

class StoreUsersSpreadsheet implements StoreSpreadsheet
{
	protected $filename;

	protected $errors = [];

	public function __construct($filename)
	{
		$this->filename = $filename;
	}

	public function data()
	{
		return Excel::load($this->filename, function($reader) {})->get();
	}

	public function validate()
	{
		foreach ($this->data() as $row) {
			$row = $row->toArray();

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
		User::create($row);
	}

	public function messages ()
	{
		return [
            'username.unique' => 'The username ":input" is already in use',
            'email.unique' => 'The email ":input" is already in use',
            'test.exists' => 'The topic ":input" does not exist'
        ];
	}

	public function validations()
	{
		return [
            // 'username' => 'unique:users,username,NULL,id,test,' . $result["test"]
            'username' => 'unique:users,username',
            'email' => 'unique:users,email|email',
            'test' => 'exists:topics,id'
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
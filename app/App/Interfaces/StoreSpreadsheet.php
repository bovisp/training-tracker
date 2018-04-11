<?php

namespace TrainingTracker\App\Interfaces;

interface StoreSpreadsheet
{
	public function data();

	public function validate();

	public function messages();

	public function validations();

	public function validateRow($row);

	public function persist($row);

	public function hasErrors ($validator);

	public function getErrors ($validator, $row);
}
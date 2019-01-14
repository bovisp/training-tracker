<?php

namespace TrainingTracker\App\Interfaces;

/**
 * To be implemented by all models whose data can be persisted via a
 * spreadsheet. This interface will ensure that every row of a spreadsheet is
 * individually validated. If validation passes, the row is persisted. If it 
 * fails, the errors are recorded and will be displayed to the user. 
 * Documentation for each method will be givien within the class that implements 
 * it.
 */
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
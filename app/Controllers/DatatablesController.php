<?php

namespace TrainingTracker\App\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use TrainingTracker\App\Controllers\Controller;

abstract class DatatablesController extends Controller
{
	protected $builder;

	public function __construct()
	{
		$builder = $this->builder();

		if (!$builder instanceof Builder) {
			throw new \Exception(
				"Entity builder not an instance of Illuminate\Database\Eloquent\Builder"
			);
		}

		$this->builder = $builder;
	}

    abstract public function builder();

    public function index()
    {
    	return response()->json([
	    	'data' => [
	    		'records' => $this->getRecords(),
	    		'displayable' => $this->getDisplayableColumns(),
	    	]
    	]);	
    }

    public function getDisplayableColumns()
    {
    	return array_values(
    		array_diff(
    			$this->getDatabaseColumnNames(), $this->builder->getModel()->getHidden()
    		)
    	);
    }

    protected function getDatabaseColumnNames()
    {
    	return Schema::getColumnListing($this->builder->getModel()->getTable());
    }

    protected function getRecords()
    {
    	return $this->builder->get($this->getDisplayableColumns());
    }
}

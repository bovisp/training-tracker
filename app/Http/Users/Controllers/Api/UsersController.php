<?php

namespace TrainingTracker\Http\Users\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;

class UsersController extends Controller
{

	public function __construct()
	{
		$this->middleware('role:admin');
	}

    public function index()
    {
    	return [
    		'employees' => User::notIn(),
    		'roles' => Role::all()
    	];
    }

    public function store()
    {
    	User::add(request()->all());
    }
}

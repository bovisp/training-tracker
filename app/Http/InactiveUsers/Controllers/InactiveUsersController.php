<?php

namespace TrainingTracker\Http\InactiveUsers\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Users\Requests\UpdateUserRequest;

class InactiveUsersController extends Controller
{
    public function index()
    {
        return view('inactiveusers.index');
    }
}

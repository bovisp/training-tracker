<?php

namespace TrainingTracker\Http\InactiveUsers\Controllers;

use TrainingTracker\App\Controllers\Controller;

class InactiveUsersController extends Controller
{
    public function index()
    {
        return view('inactiveusers.index');
    }
}

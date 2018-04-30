<?php

namespace TrainingTracker\Http\Users\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
    	return view('users.show', compact('user'));
    }
}

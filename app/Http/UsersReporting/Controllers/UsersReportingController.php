<?php

namespace TrainingTracker\Http\UsersReporting\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;

class UsersReportingController extends Controller
{
    public function index(User $user, Role $role)
    {
        $user = $user->load('moodleuser');

        return view('usersreporting.index', compact('user', 'role'));
    }
}

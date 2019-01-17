<?php

namespace TrainingTracker\Http\Users\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Roles\Role;
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
        $reporting = $user->reportingStructure()->unique();

        $roles = Role::where('rank', '!=', $user->roles->first()->rank)->get();

    	return view('users.show', compact('user', 'reporting', 'roles'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with([
                'flash' => [
                    'message' => trans('app.flash.userdeleted')
                ]
            ]);
    }
}

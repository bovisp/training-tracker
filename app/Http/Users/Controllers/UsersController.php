<?php

namespace TrainingTracker\Http\Users\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Users\Requests\UpdateUserRequest;

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

    public function updateRole(User $user, UpdateUserRequest $request)
    {
        $user->supervisors()->detach($user->supervisors);

        if ($user->hasRole('apprentice') === false) {
            $supervisor = Supervisor::whereUserId($user->id)->first();

            $supervisor->users()->detach($supervisor->users);
        }

        $user->updateRole($request->role);

        return redirect()
            ->route('users.show', [ 'user' => $user->id ])
            ->with([
                'flash' => [
                    'message' => "Role update successfully."
                ]
            ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with([
                'flash' => [
                    'message' => "User deleted successfully."
                ]
            ]);
    }
}

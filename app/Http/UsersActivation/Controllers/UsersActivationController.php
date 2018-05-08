<?php

namespace TrainingTracker\Http\UsersActivation\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;

class UsersActivationController extends Controller
{
    public function store(User $user)
    {
        $user->update([
            'active' => 1
        ]);

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with([
                'flash' => [
                    'message' => "User successfully activated."
                ]
            ]);
    }

    public function destroy(User $user)
    {
        $user->supervisors()->detach($user->supervisors);

        if ($user->hasRole('apprentice') === false) {
            $supervisor = Supervisor::whereUserId($user->id)->first();

            $supervisor->users()->detach($supervisor->users);
        }

    	$user->update([
            'active' => 0
        ]);

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with([
                'flash' => [
                    'message' => "User successfully deactivated."
                ]
            ]);
    }
}
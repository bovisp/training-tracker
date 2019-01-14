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
                    'message' => trans('app.flash.useractivated')
                ]
            ]);
    }

    public function destroy(User $user)
    {
        if (optional($user->supervisor) === null) {
            $user->supervisor->users()->detach();
        }
        
        $user->supervisors()->detach();

    	$user->update([
            'active' => 0
        ]);

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with([
                'flash' => [
                    'message' => trans('app.flash.userdeactivated')
                ]
            ]);
    }
}

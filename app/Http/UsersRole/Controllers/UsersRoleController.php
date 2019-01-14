<?php

namespace TrainingTracker\Http\UsersRole\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Supervisors\Supervisor;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UsersRole\Requests\UpdateUserRoleRequest;

class UsersRoleController extends Controller
{
    public function update(User $user, UpdateUserRoleRequest $request)
    {
        if (optional($user->supervisor) === null) {
            $user->supervisor->users()->detach();
        }
        
        $user->supervisors()->detach();

        $user->updateRole($request->role);

        return redirect()
            ->route('users.show', [ 'user' => $user->id ])
            ->with([
                'flash' => [
                    'message' => trans('app.flash.usersroleupdated')
                ]
            ]);
    }
}

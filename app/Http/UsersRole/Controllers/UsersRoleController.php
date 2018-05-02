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
}

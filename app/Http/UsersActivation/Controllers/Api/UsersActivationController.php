<?php

namespace TrainingTracker\Http\UsersActivation\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Deactivations\Deactivation;
use TrainingTracker\Domains\Users\User;

class UsersActivationController extends Controller
{
    public function store(User $user)
    {
        request()->validate([
            'deactivated_at' => 'required|date',
            'deactivation_rationale' => 'required|min:3'
        ]);

        $user->update([
            'active' => 0
        ]);

        $deactivation = Deactivation::make(request([
            'deactivated_at', 'deactivation_rationale'
        ]));

        $user->deactivations()->save($deactivation);

        return response()->json([
            'flash' => 'User successfully deactivated'
        ], 200);
    }

    public function update(User $user)
    {
        request()->validate([
            'reactivated_at' => 'required|date'
        ]);

        $user->update([
            'active' => 1
        ]);

        $deactivation = Deactivation::where('user_id', $user->id)->latest()->first();

        $deactivation->update([
            'reactivated_at' => request('reactivated_at')
        ]);

        return response()->json([
            'flash' => 'User successfully reactivated'
        ], 200);
    }
}
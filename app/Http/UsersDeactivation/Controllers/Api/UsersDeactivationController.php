<?php

namespace TrainingTracker\Http\UsersDeactivation\Controllers\Api;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\UsersDeactivation\Resources\DeactivationResource;

class UsersDeactivationController extends Controller
{
    public function index(User $user)
    {
        return DeactivationResource::collection(
            $user->deactivations
        );
    }

    public function update(User $user)
    {
        request()->validate([
            'deactivated_at' => 'date',
            'reactivated_at' => 'date',
            'deactivation_rationale' => 'min:3'
        ]);

        $user->deactivations()->update(request()->only([
    		'deactivated_at', 'reactivated_at', 'deactivation_rationale'
    	]));

        return response()->json([
            'flash' => 'edited!'
        ]);
    }
}

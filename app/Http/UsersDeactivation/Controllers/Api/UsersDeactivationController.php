<?php

namespace TrainingTracker\Http\UsersDeactivation\Controllers\Api;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Deactivation\Deactivation;
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

    public function update(User $user, Deactivation $deactivation)
    {
        request()->validate([
            'deactivated_at' => 'required|date',
            'reactivated_at' => 'nullable|date',
            'deactivation_rationale' => 'required|min:3'
        ]);

        if ($this->isCurrentDeactivation($user, $deactivation) && request('reactivated_at') !== null && $user->active === 0) {
            $user->update([
                'active' => 1
            ]);
        }

        $deactivation->update(request()->only([
    		'deactivated_at', 'reactivated_at', 'deactivation_rationale'
    	]));

        return response()->json([
            'flash' => 'Deactivation updated',
            'active' => (int) $user->active
        ]);
    }

    public function isCurrentDeactivation(User $user, Deactivation $deactivation)
    {
        $latestDeactivation = $user->deactivations
            ->sortByDesc('created_at')
            ->first();

        if ($latestDeactivation->id === $deactivation->id) {
            return true;
        }

        return false;
    }
}

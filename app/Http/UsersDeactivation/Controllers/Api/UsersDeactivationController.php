<?php

namespace TrainingTracker\Http\UsersDeactivation\Controllers\Api;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;

class UsersDeactivationController extends Controller
{
    public function update(User $user)
    {
    	$user->update(request()->only([
    		'deactivated_at', 'reactivated_at', 'deactivation_rationale'
    	]));

        return response()->json([
            'flash' => trans('app.flash.deactivationupdated'),
            'data' => [
            	'deactivated_at' => $user->deactivated_at,
            	'reactivated_at' => $user->reactivated_at,
            	'deactivation_rationale' => $user->deactivation_rationale
            ]
        ]);
    }
}

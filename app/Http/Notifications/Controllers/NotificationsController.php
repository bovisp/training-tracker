<?php

namespace TrainingTracker\Http\Notifications\Controllers;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;

class NotificationsController extends Controller
{
    public function index(User $user)
    {
    	$user->load(['notifications']);
    	
        return view('notifications.index', compact('user'));
    }
}

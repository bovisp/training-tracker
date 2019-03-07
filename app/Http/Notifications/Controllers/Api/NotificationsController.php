<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use TrainingTracker\Domains\Users\User;

class NotificationsController
{
	public function index(User $user)
	{
		return $user->notifications;
	}
}
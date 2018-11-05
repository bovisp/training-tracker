<?php

namespace TrainingTracker\Http\Notifications\Classes;

class UserNotifications
{
	function __construct(User $user)
	{
		$this->user = $user;
	}

	public function collect()
	{
		
	}
}
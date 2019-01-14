<?php

namespace TrainingTracker\Domains\Users;

use TrainingTracker\Domains\Users\User;

class UserObserver
{
	public function deleting(User $user)
	{
		// Delete all associated user lesson packages
		$user->userlessons->each->delete();

		// Delete comments of any kind
		$user->comments->each->delete();

		// If the user is a supervisor, detach all associations to 
		// other employees.
		if (!$user->hasRole('apprentice')) {
            $user->supervisor->users()->detach();
        }
        
        // If the user is supervised, detach all associations to them.
        $user->supervisors()->detach();

		// Delete the user from the supervisors table.
		if (!$user->hasRole('apprentice')) {
			$user->supervisor->delete();
		}

		// Delete the users role associatons.
		$user->roles()->detach();
	}
}
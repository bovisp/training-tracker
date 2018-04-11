<?php

namespace TrainingTracker\Domains\MoodleUsers;

use Illuminate\Database\Eloquent\Model;

class MoodleUser extends Model
{
	protected $connection = 'mysql2';

    protected $table = 'mdl_user';

    public function profile($moodleId)
    {
    	return $this->select('firstname', 'lastname', 'id', 'email')
    		->whereId($moodleId)
    		->get()
    		->first();
    }
}
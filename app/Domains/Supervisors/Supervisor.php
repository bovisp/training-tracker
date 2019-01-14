<?php

namespace TrainingTracker\Domains\Supervisors;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Roles\Role;
use TrainingTracker\Domains\Users\User;

class Supervisor extends Model
{
    protected $fillable = [
    	'user_id'
    ];

    public function user()
    {
    	return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_supervisors');
    }

    public function role()
    {
        return $this->user->roles->first();
    }
}

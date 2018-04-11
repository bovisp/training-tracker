<?php

namespace TrainingTracker\Domains\Roles;

use Illuminate\Database\Eloquent\Model;

/**
 * Add the ability to create roles which can then be assigned (primarily) to
 * Users.
 */
class Role extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'type', 'name'
    ];
}

<?php

namespace TrainingTracker\Domains\Permissions;

use Illuminate\Database\Eloquent\Model;

/**
 * Add the ability to create permissions which can then be assigned (primarily)
 * to Users and Permissions.
 */
class Permission extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'type', 'name', 'description'
    ];
}

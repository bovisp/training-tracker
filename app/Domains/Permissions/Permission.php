<?php

namespace TrainingTracker\Domains\Permissions;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Roles\Role;

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
    	'type'
    ];

    /**
     * A permission can belong to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
    	return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}

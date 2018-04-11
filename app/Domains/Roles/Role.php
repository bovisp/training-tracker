<?php

namespace TrainingTracker\Domains\Roles;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Permissions\Permission;

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

    /**
     * A role can belong to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
    	return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
}

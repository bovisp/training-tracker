<?php

namespace TrainingTracker\App\Traits;

use TrainingTracker\Domains\Permissions\Permission;
use TrainingTracker\Domains\Roles\Role;

/**
 * Allows a Model to inherit the ability to have permissions.
 */
trait HasPermissionsTrait
{
	/**
     * A model can belong to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function roles()
	{
		return $this->belongsToMany(Role::class, 'users_roles');
	}

	/**
     * A model can belong to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'users_permissions');
	}

	public function hasRole(...$roles)
	{
		foreach ($roles as $role) {
			if ($this->roles->contains('type', $role)) {
				return true;
			}
		}

		return false;
	}

	public function hasPermissionTo($permission)
	{
		return $this->hasPermission($permission);
	}

	protected function hasPermission($permission)
	{
		return (bool) $this->permissions
			->where('type', $permission->type)
			->count();
	}
}
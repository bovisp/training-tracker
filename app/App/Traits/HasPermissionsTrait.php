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

	/**
	 * Check if a model instance has a particular role(s).
	 * 
	 * @param  array  $roles  One or more roles to check.
	 * 
	 * @return boolean        If true, the model has that role.
	 */
	public function hasRole(...$roles)
	{
		foreach ($roles as $role) {
			if ($this->roles->contains('type', $role)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a model instance directly has a permission or indirectly through
	 * a role.
	 * 
	 * @param  model  $permission Instance of \TrainingTracker\Domains\Permissions\Permission
	 * 
	 * @return boolean            If true, the model instance directly has a
	 * permission or indirectly through a role.
	 */
	public function hasPermissionTo($permission)
	{
		return $this->hasPermission($permission) ||
			   $this->hasPermissionThroughRole($permission);
	}

	/**
	 * Check if a model instance directly has a permission.
	 * 
	 * @param  model  $permission Instance of \TrainingTracker\Domains\Permissions\Permission
	 * 
	 * @return boolean            If true, the model instance directly has a
	 * permission.
	 */
	protected function hasPermission($permission)
	{
		return (bool) $this->permissions
			->where('type', $permission->type)
			->count();
	}

	/**
	 * Check if a model instance has a permission indirectly through a role.
	 * 
	 * @param  model  $permission Instance of \TrainingTracker\Domains\Permissions\Permission
	 * 
	 * @return boolean            If true, the model instance has a permission
	 * indirectly through a role.
	 */
	protected function hasPermissionThroughRole($permission)
	{
		foreach ($permission->roles as $role) {
			if ($this->roles->contains($role)) {
				return true;
			}
		}

		return false;
	}
}
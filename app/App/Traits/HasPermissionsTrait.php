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

	/**
	 * Assign permissions to a model instance
	 * 
	 * @param  array $permissions A list of permissions.
	 * 
	 * @return model              The model instance to facilitate method
	 * chaining.
	 */
	public function givePermissionTo(...$permissions)
	{
		$permissions = $this->getPermissions(
			array_flatten($permissions)
		);

		if ($permissions === null) {
			return $this;
		}

		$this->permissions()->saveMany($permissions);

		return $this;
	}

	/**
	 * Remove permissions from a model instance.
	 * 
	 * @param  array $permissions A list of permissions.
	 * 
	 * @return model              The model instance to facilitate method
	 * chaining.
	 */
	public function withdrawPermissionTo(...$permissions)
	{
		$permissions = $this->getPermissions(
			array_flatten($permissions)
		);

		$this->permissions()->detach($permissions);

		return $this;
	}

	/**
	 * Update (or refresh) permissions on a model instance.
	 * 
	 * @param  array $permissions A list of permissions.
	 * @return model              The model instance to facilitate method
	 * chaining.
	 */
	public function updatePermissions(...$permissions)
	{
		$this->permissions()->detach();

		return $this->givePermissionTo($permissions);
	}

	/**
	 * Assign a role to a model instance.
	 * 
	 * @param  string $role The role to be assigned.
	 * 
	 * @return model The model instance to facilitate method
	 * chaining.
	 */
	public function assignRole($role)
	{
		$role = $this->getRole($role);

		if ($role === null) {
			return $this;
		}

		$this->roles()->save($role);

		return $this;
	}

	/**
	 * Remove a role from a model instance.
	 * 
	 * @param  string $role The role to be removed.
	 * 
	 * @return model The model instance to facilitate method
	 * chaining.
	 */
	public function removeRole($role)
	{
		$role = $this->getRole($role);

		$this->roles()->detach($role);

		return $this;
	}

	/**
	 * Update (or refresh) a role on a model instance.
	 * 
	 * @param  string $role The role to be updated.
	 * 
	 * @return model The model instance to facilitate method
	 * chaining.
	 */
	public function updateRole($role)
	{
		$this->roles()->detach();

		return $this->assignRole($role);
	}

	/**
	 * Get a collection of Permissions.
	 * 
	 * @param  array $permissions An an array of permission strings.
	 * 
	 * @return collection \TrainingTracker\Domains\Permissions\Permission
	 */
	protected function getPermissions($permissions)
	{
		return Permission::whereIn('type', $permissions)->get();
	}

	/**
	 * Get a Role model instance.
	 * 
	 * @param  string $role The role type string to be queried.
	 * 
	 * @return model \TrainingTracker\Domains\Roles\Role
	 */
	protected function getRole($role)
	{
		return Role::where('type', $role)->get()->first();
	}
}
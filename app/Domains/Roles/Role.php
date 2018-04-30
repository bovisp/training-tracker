<?php

namespace TrainingTracker\Domains\Roles;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use TrainingTracker\Domains\Permissions\Permission;
use TrainingTracker\Domains\Users\User;

/**
 * Add the ability to create roles which can then be assigned (primarily) to
 * Users.
 */
class Role extends Model
{
    use HasTranslations;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'type', 'name', 'rank'
    ];

    public $translatable = [
        'name'
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

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }

    public function toArray()
    {
        $attributes = parent::toArray();
        
        foreach ($this->getTranslatableAttributes() as $name) {
            $attributes[$name] = $this->getTranslation($name, app()->getLocale());
        }
        
        return $attributes;
    }
}

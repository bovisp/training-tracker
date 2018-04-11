<?php

namespace TrainingTracker\App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use TrainingTracker\Domains\Permissions\Permission;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $user = moodleauth()->user();

        Permission::get()->map(function ($permission) {
            Gate::define($permission->type, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace TrainingTracker\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Comments\Policies\CommentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

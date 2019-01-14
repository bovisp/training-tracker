<?php

namespace TrainingTracker\App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use TrainingTracker\App\Classes\Auth;

/**
 * Registers the MoodleAuth facade to Laravel's container.
 */
class MoodleAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the moodleauth service by binding it to Laravel's container.
     *
     * @return void
     */
    public function register()
    {
        App::bind('moodleauth', function() {
            return new Auth;
        });
    }
}

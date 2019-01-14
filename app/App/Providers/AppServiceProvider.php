<?php

namespace TrainingTracker\App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Comments\CommentObserver;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Lessons\LessonObserver;
use TrainingTracker\Domains\Levels\Level;
use TrainingTracker\Domains\Levels\LevelObserver;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\LogbookEntry\LogbookEntryObserver;
use TrainingTracker\Domains\Logbook\LogbookObserver;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Objectives\Objective;
use TrainingTracker\Domains\Objectives\ObjectiveObserver;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\UserLessons\UserLessonObserver;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Domains\Users\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Observers
        Level::observe(LevelObserver::class);
        Lesson::observe(LessonObserver::class);
        User::observe(UserObserver::class);
        UserLesson::observe(UserLessonObserver::class);
        LogbookEntry::observe(LogbookEntryObserver::class);
        Logbook::observe(LogbookObserver::class);
        Objective::observe(ObjectiveObserver::class);
        Comment::observe(CommentObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

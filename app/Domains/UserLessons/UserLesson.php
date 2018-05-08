<?php

namespace TrainingTracker\Domains\UserLessons;

use Illuminate\Database\Eloquent\Model;

class UserLesson extends Model
{
    protected $fillable = [
        'lesson_id', 'user_id'
    ];
}

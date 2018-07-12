<?php

namespace TrainingTracker\Domains\UserLessons;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Users\User;

class UserLesson extends Model
{
    protected $fillable = [
        'lesson_id', 'user_id', 'p9', 'p18', 'p30', 'p42'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function lesson()
    {
    	return $this->belongsTo(Lesson::class);
    }
}

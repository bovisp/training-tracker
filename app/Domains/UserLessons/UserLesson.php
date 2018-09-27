<?php

namespace TrainingTracker\Domains\UserLessons;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Users\User;

class UserLesson extends Model
{
    protected $fillable = [
        'lesson_id', 'user_id', 'p9', 'p18', 'p30', 'p42', 'completed'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function lesson()
    {
    	return $this->belongsTo(Lesson::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->whereNull('parent_id')
            ->orderBy('created_at', 'asc');
    }
}

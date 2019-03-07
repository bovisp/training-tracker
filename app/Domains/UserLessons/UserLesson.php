<?php

namespace TrainingTracker\Domains\UserLessons;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Lessons\Lesson;
use TrainingTracker\Domains\Logbooks\Logbook;
use TrainingTracker\Domains\Users\User;

class UserLesson extends Model
{
    protected $fillable = [
        'lesson_id', 'user_id', 'p9', 'p18', 'p30', 'p42', 'completed'
    ];

    protected $statusArr = [
        'p9' => null,
        'p18' => null,
        'p30' => null,
        'p42' => null
    ];

    protected $statusTypes = [
        'c' => 'Completed',
        'd' => 'Deferred',
        'e' => 'Exempt',
        'i' => 'In progress'
    ];

    public function evaluateStatus()
    {
        $this->populateStatusArr();

        foreach (array_reverse($this->statusArr) as $status) {
            if ($status !== null) {
                return $this->statusTypes[$status];
            }
        }

        return $this->statusTypes['i'];
    }

    protected function populateStatusArr()
    {
        $this->statusArr['p9'] = $this->p9;
        $this->statusArr['p18'] = $this->p18;
        $this->statusArr['p30'] = $this->p30;
        $this->statusArr['p42'] = $this->p42;
    }

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

    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'userlesson_id', 'id');
    }
}

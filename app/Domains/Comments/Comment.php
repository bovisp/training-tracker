<?php

namespace TrainingTracker\Domains\Comments;

use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Users\User;

class Comment extends Model
{
    protected $fillable = [
    	'body', 'has_children'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function commentable()
    {
    	return $this->morphTo();
    }
}

<?php

namespace TrainingTracker\Domains\Comments;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\Users\User;

class Comment extends Model
{
	protected $fillable = [
    	'body'
    ];

    protected $dates = [
        'edited_at'
    ];

    protected $with = [
        'user'
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($comment) {
            $comment->edited_at = Carbon::now();
        });

        static::deleting(function ($comment) {
            if (!$comment->parent_id) {
                $comment->children->each->delete();
            }
        });
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function children()
    {
    	return $this->hasmany(Comment::class, 'parent_id', 'id')
            ->orderBy('created_at', 'asc');
    }

    public function commentable()
    {
    	return $this->morphTo();
    }
}
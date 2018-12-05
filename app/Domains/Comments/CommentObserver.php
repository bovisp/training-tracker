<?php

namespace TrainingTracker\Domains\Comments;

use Illuminate\Support\Facades\DB;
use TrainingTracker\Domains\Comments\Comment;

class CommentObserver
{
	public function deleting(Comment $comment)
	{
		// Delete all associated notifications associated with this comment
		$test = DB::table('notifications')
			->where('data','LIKE','%"CommentId":' . $comment->id . '%')
			->delete();
	}
}
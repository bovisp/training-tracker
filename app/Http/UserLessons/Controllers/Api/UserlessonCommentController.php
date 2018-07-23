<?php

namespace TrainingTracker\Http\UserLessons\Controllers\Api;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Comments\Resources\CommentResource;

class UserlessonCommentController extends Controller
{
    public function index(User $user, UserLesson $userlesson)
    {
    	return CommentResource::collection($userlesson->comments()
    		->with(['user'])
    		->paginate(5));
    }

    public function store(User $user, UserLesson $userlesson, Request $request)
    {
        if (!$user->hasThisSupervisorWithRoleOf(['head_of_operations'])) {
            abort(403, 'You are not authorized to add comments');
        }

    	request()->validate([
    		'body' => 'required|max:5000'
    	]);

    	$comment = $userlesson->comments()->make([
    		'body' => request('body')
    	]);

    	$user = User::find(moodleauth()->id());

    	$user->comments()->save($comment);

    	return new CommentResource($comment);
    }
}

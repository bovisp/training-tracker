<?php

namespace TrainingTracker\Http\UserLessons\Controllers\Api;

use Illuminate\Http\Request;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\UserLessons\UserLesson;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Comments\Resources\CommentResource;

class UserlessonCommentController extends Controller
{
	public function index(User $user, UserLesson $userlesson)
	{
		return CommentResource::collection(
    		$userlesson->comments()->with(['children', 'user', 'user.moodleuser'])->get()
    	);
	}

	public function store(User $user, UserLesson $userlesson)
	{
		$allowedRoles = ['administrator', 'supervisor', 'head_of_operations'];
		// $allowedRoles = [];

		if ($this->canModify($allowedRoles, $user) === false) {
			return response()->json([
				'errors' => [
					'errors' => [
						'denied' => 'You are not authorized to do that.'
					]
				]
			], 403);
		}

		request()->validate([
    		'body' => 'required|max:5000'
    	]);

    	$comment = $userlesson->comments()->make([
    		'body' => request('body')
    	]);

    	moodleauth()->user()->comments()->save($comment);

    	return new CommentResource($comment);
	}

	public function update(User $user, UserLesson $userlesson, Comment $comment)
	{
		$allowedRoles = ['administrator', 'supervisor', 'head_of_operations'];
		// $allowedRoles = [];

		if ($this->canModify($allowedRoles, $user) === false) {
			return response()->json([
				'errors' => [
					'errors' => [
						'denied' => 'You are not authorized to do that.'
					]
				]
			], 403);
		}

		request()->validate([
    		'body' => 'required|max:5000'
    	]);

    	$comment->update([
    		'body' => request('body')
    	]);

    	return new CommentResource($comment);
	}

	public function destroy(User $user, UserLesson $userlesson, Comment $comment)
	{
		$allowedRoles = ['administrator', 'supervisor', 'head_of_operations'];

		// $allowedRoles = [];

		if ($this->canModify($allowedRoles, $user) === false) {
			return response()->json([
				'errors' => [
					'errors' => [
						'denied' => 'You are not authorized to do that.'
					]
				]
			], 403);
		}

    	$comment->delete();

    	return new CommentResource($comment);
	}

	protected function canModify(array $roles, User $user)
	{
		return $this->inReportingStructure($user) && $this->hasRole($roles);
	}

	protected function hasRole(array $roles)
	{
		return moodleauth()->user()->hasRole($roles);
	}

	protected function inReportingStructure(User $user)
	{
		if (moodleauth()->user()->hasRole('administrator')) {
			return true;
		}
		
		return $user->reportingStructure()
			->where('id', moodleauth()->id())
			->count() > 0;
	}
}
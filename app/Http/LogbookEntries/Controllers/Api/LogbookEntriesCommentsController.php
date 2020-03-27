<?php

namespace TrainingTracker\Http\LogbookEntries\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\App\Notifications\LogbookCommentEntryNotification;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Comments\Resources\CommentResource;

class LogbookEntriesCommentsController extends Controller
{
    public function index(User $user, LogbookEntry $logbookEntry)
    {
        return CommentResource::collection(
            $logbookEntry->comments()
                ->with(['children', 'user', 'commentable'])
                ->get()
        );
    }

    public function store(User $user, LogbookEntry $logbookEntry)
    {
        if ($logbookEntry->logbook->userlesson->completed === 1) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => 'You cannot do this as the lesson package has been marked as complete.'
                    ]
                ]
            ], 403);
        }

        if (
            moodleauth()->user()->roles->first()->type === 'head_of_operations' || 
            moodleauth()->user()->roles->first()->type === 'manager'
        ) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => trans('app.errors.general.denied')
                    ]
                ]
            ], 403);
        }

        request()->validate([
            'body' => 'required|max:5000'
        ]);

        $comment = $logbookEntry->addComment($user);

        return new CommentResource($comment);
    }

    public function update(User $user, LogbookEntry $logbookEntry, Comment $comment)
    {
        if ($logbookEntry->logbook->userlesson->completed === 1) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => 'You cannot do this as the lesson package has been marked as complete.'
                    ]
                ]
            ], 403);
        }

        if ($this->validateRoles($comment) === false) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => trans('app.errors.general.denied')
                    ]
                ]
            ], 403);
        }

        request()->validate([
            'body' => 'required|max:5000'
        ]);

        $comment = $logbookEntry->updateComment($comment, $user);

        return new CommentResource($comment);
    }

    public function destroy(User $user, LogbookEntry $logbookEntry, Comment $comment)
    {
        if ($logbookEntry->logbook->userlesson->completed === 1) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => 'You cannot do this as the lesson package has been marked as complete.'
                    ]
                ]
            ], 403);
        }

        if ($this->validateRoles($comment) === false) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => trans('app.errors.general.denied')
                    ]
                ]
            ], 403);
        }

        $comment->delete();

        return new CommentResource($comment);
    }

    protected function validateRoles(Comment $comment)
    {
        if (moodleauth()->user()->hasRole('administrator')) {
            return true;
        }

        if (moodleauth()->id() == $comment->user->id) {
            return true;
        }

        if (
            moodleauth()->user()->roles->first()->type === 'head_of_operations' || 
            moodleauth()->user()->roles->first()->type === 'manager'
        ) {
            return false;
        }

        if (moodleauth()->user()->roles->first()->rank > $comment->user->roles->first()->rank) {
            return false;
        }
    }
}

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
        $this->validateRoles([
            'administrator', 'supervisor', 'head_of_operations', 'apprentice'
        ]);

        request()->validate([
            'body' => 'required|max:5000'
        ]);

        $comment = $logbookEntry->addComment($user);

        return new CommentResource($comment);
    }

    public function update(User $user, LogbookEntry $logbookEntry, Comment $comment)
    {
        $this->validateRoles([
            'administrator', 'supervisor', 'head_of_operations', 'apprentice'
        ]);

        request()->validate([
            'body' => 'required|max:5000'
        ]);

        $comment = $logbookEntry->updateComment($comment, $user);

        return new CommentResource($comment);
    }

    public function destroy(User $user, LogbookEntry $logbookEntry, Comment $comment)
    {
        $this->validateRoles([
            'administrator', 'supervisor', 'head_of_operations', 'apprentice'
        ]);

        $comment->delete();

        return new CommentResource($comment);
    }

    protected function validateRoles($roles)
    {
        if (moodleauth()->user()->hasRole($roles) === false) {
            return response()->json([
                'errors' => [
                    'errors' => [
                        'denied' => trans('errors.general.denied')
                    ]
                ]
            ], 403);
        }
    }
}

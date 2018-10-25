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
                ->with(['children', 'user'])
                ->get()
        );
    }

    public function store(User $user, LogbookEntry $logbookEntry)
    {
        $allowedRoles = ['administrator', 'supervisor', 'head_of_operations', 'apprentice'];

        if (moodleauth()->user()->hasRole($allowedRoles) === false) {
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

        $comment = $logbookEntry->comments()->make([
            'body' => request('body')
        ]);

        moodleauth()->user()->comments()->save($comment);

        $users = $this->getSupervisorsAndHeadOfOperationsRoles($user);

        Notification::send($users, new LogbookCommentEntryNotification(
            $comment, $user->id, 'logbook_entry_comment_added', moodleauth()->user()
        ));

        return new CommentResource($comment);
    }

    public function update(User $user, LogbookEntry $logbookEntry, Comment $comment)
    {
        $allowedRoles = ['administrator', 'supervisor', 'head_of_operations'];
        // $allowedRoles = [];

        if (moodleauth()->user()->hasRole($allowedRoles) === false) {
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

        $users = $this->getSupervisorsAndHeadOfOperationsRoles($user);

        Notification::send($users, new LogbookCommentEntryNotification(
            $comment, $user->id, 'logbook_entry_comment_updated', moodleauth()->user()
        ));

        return new CommentResource($comment);
    }

    public function destroy(User $user, LogbookEntry $logbookEntry, Comment $comment)
    {
        $allowedRoles = ['administrator', 'supervisor', 'head_of_operations'];

        if (moodleauth()->user()->hasRole($allowedRoles) === false) {
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

    protected function getSupervisorsAndHeadOfOperationsRoles(User $user) {
        return User::find(
            $user->reportingStructure()
                ->map(function ($u) {
                    if ($u['role'] === 'supervisor' || $u['role'] === 'head_of_operations') {
                        return $u['id'];
                    }
                })
                ->toArray()
        );
    }
}

<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntriesResource;
use TrainingTracker\Http\UserLessons\Resources\UserLessonResource;
use TrainingTracker\Http\Users\Resources\UserResource;

class NotificationsController extends Controller
{
    public function index(User $user)
    {
        $notifications = [];

        foreach ($user->notifications as $notification) {
            switch ($notification->data['noteType']) {
                case 'logbook_entry_added':
                case 'logbook_entry_updated':
                case 'logbook_entry_deleted':
                    $notifications[] = $this->logbookEntry($notification);
                    break;
                case 'logbook_entry_comment_added':
                case 'logbook_entry_comment_updated':
                    $notifications[] = $this->logbookCommentEntry($notification);
                    break;
            }
        }

        return [
            'user' => $user,
            'notifications' => $notifications
        ];
    }

    public function read(User $user, $notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->update([
                'read_at' => now()
            ]);

        return response()->json([
            'flash' => 'Notification marked as read.'
        ], 200);
    }

    public function unread(User $user, $notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->update([
                'read_at' => null
            ]);

        return response()->json([
            'flash' => 'Notification marked as unread.'
        ], 200);
    }

    public function destroy(User $user, $notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->delete();

        return response()->json([
            'flash' => 'Notification successfully deleted.'
        ], 200);
    }

    protected function logbookEntry($notification) {
        $logbookEntry = LogbookEntry::find($notification->data['logbookEntryId']);

    	return [
            'data' => $notification,
            'meta' => [
                'logbookEntryId' => $logbookEntry->id,
                'logbookId' => $logbookEntry->logbook->id,
                'logbookEntryCreator' => $logbookEntry->creator,
                'logbookEntryCommentEditor' => $logbookEntry->editor,
                'lessonPackage' => new UserLessonResource($logbookEntry->logbook->userlesson),
                'lessonPackageApprentice' => $logbookEntry->logbook->userlesson->user,
                'objective' => $logbookEntry->logbook->objective->number
            ]
    	];
    }

    protected function logbookCommentEntry($notification) {
        $logbookCommentEntry = Comment::find($notification->data['commentId']);
        $authUser = User::find($notification->data['authId']);
        $logbookEntry = LogBookEntry::find($logbookCommentEntry->commentable_id);

        return [
            'data' => $notification,
            'meta' => [
                'logbookCommentEntryId' => $logbookCommentEntry->id,
                'logbookId' => $logbookEntry->logbook->id,
                'logbookEntryId' => $logbookEntry->id,
                'logbookCommentEntryCreator' => $logbookCommentEntry->user,
                'logbookCommentEntryEditor' => new UserResource($authUser),
                'lessonPackage' => new UserLessonResource($logbookEntry->logbook->userlesson),
                'lessonPackageApprentice' => $logbookEntry->logbook->userlesson->user,
                'objective' => $logbookEntry->logbook->objective->number
            ]
        ];
    }
}

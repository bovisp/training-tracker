<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use Illuminate\Support\Facades\DB;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Notifications\Classes\LogbookCommentEntryUserNotification;
use TrainingTracker\Http\Notifications\Classes\LogbookEntryUserNotification;

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
                    $notifications[] = (new LogbookEntryUserNotification($notification))->collect();
                    break;
                case 'logbook_entry_comment_added':
                case 'logbook_entry_comment_updated':
                    $notifications[] = (new LogbookCommentEntryUserNotification($notification))->collect();
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
}

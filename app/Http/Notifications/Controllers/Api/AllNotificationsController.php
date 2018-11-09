<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\Users\User;

class AllNotificationsController extends Controller
{
    public function read(User $user)
    {
        $user->unreadNotifications->markAsRead();

        return response()->json([
            'flash' => 'All notifications marked as read.'
        ], 200);
    }

    public function destroyRead(User $user)
    {
        foreach ($user->notifications as $notification) {
           if ($notification->read_at !== null) {
               $notification->delete();
           }
        }

        return response()->json([
            'flash' => 'All read notifications deleted.'
        ], 200);
    }

    public function unread(User $user)
    {
        foreach ($user->notifications as $notification) {
            $notification->update([
                'read_at' => null
            ]);
        }

        return response()->json([
            'flash' => 'All notifications marked as read.'
        ], 200);
    }

    public function destroyUnread(User $user)
    {
        $user->unreadNotifications()->delete();

        return response()->json([
            'flash' => 'All notifications marked as read.'
        ], 200);
    }
}

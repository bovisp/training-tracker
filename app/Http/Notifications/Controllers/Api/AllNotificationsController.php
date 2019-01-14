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
            'flash' => trans('app.flash.allnotificationsread')
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
            'flash' => trans('app.flash.allreadnotificationsdeleted')
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
            'flash' => trans('app.flash.allnotificationsunread')
        ], 200);
    }

    public function destroyUnread(User $user)
    {
        $user->unreadNotifications()->delete();

        return response()->json([
            'flash' => trans('app.flash.allunreadnotificationsdeleted')
        ], 200);
    }
}

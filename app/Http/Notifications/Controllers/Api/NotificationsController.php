<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use Illuminate\Support\Facades\DB;
use TrainingTracker\Domains\Users\User;

class NotificationsController
{
	public function index(User $user)
	{
		return [
            'user' => [
            	'id' => $user->id,
            	'firstname' => $user->firstname,
            	'lastname' => $user->lastname
            ],
            'notifications' => $user->notifications
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
            'flash' => trans('app.flash.notificationread')
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
            'flash' => trans('app.flash.notificationunread')
        ], 200);
    }

    public function destroy(User $user, $notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->delete();

        return response()->json([
            'flash' => trans('app.flash.notificationdeleted')
        ], 200);
    }
}
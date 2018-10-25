<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntriesResource;
use TrainingTracker\Http\UserLessons\Resources\UserLessonResource;

class NotificationsController extends Controller
{
    public function index(User $user)
    {
        $notifications = [];

        foreach ($user->notifications as $notification) {
            switch ($notification->data['noteType']) {
                case 'logbook_entry_added':
                    $notifications[] = $this->logbookEntryAdded($notification);
            }
        }

        return [
            'user' => $user,
            'notifications' => $notifications
        ];
    }

    public function update(User $user, $notificationId)
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

    public function destroy(User $user, $notificationId)
    {
        DB::table('notifications')
            ->where('id', $notificationId)
            ->delete();

        return response()->json([
            'flash' => 'Notification successfully deleted.'
        ], 200);
    }

    protected function logbookEntryAdded($notification) {
        $logbookEntry = LogbookEntry::find($notification->data['logbookEntryId']);

    	return [
            'data' => $notification,
            'meta' => [
                'logbookEntryId' => $logbookEntry->id,
                'logbookId' => $logbookEntry->logbook->id,
                'logbookEntryCreator' => $logbookEntry->creator,
                'logbookEntryEditor' => $logbookEntry->editor,
                'lessonPackage' => new UserLessonResource($logbookEntry->logbook->userlesson),
                'lessonPackageApprentice' => $logbookEntry->logbook->userlesson->user,
                'objective' => $logbookEntry->logbook->objective->number
            ]
    	];
    }
}

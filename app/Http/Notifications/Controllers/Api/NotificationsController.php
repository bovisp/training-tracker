<?php

namespace TrainingTracker\Http\Notifications\Controllers\Api;

use Illuminate\Support\Facades\Notification;
use TrainingTracker\App\Controllers\Controller;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\LogbookEntries\Resources\LogbookEntriesResource;
use TrainingTracker\Http\UserLessons\Resources\UserLessonResource;

class NotificationsController extends Controller
{
    public function show(User $user, $notificationId)
    {
    	$notification = $user->notifications
    		->where('id', $notificationId)
    		->first();

    	switch ($notification->data['noteType']) {
    		case 'logbook_entry_added':
    			return $this->logbookEntryAdded($notification);
    	}
    }

    protected function logbookEntryAdded($notification) {
    	$logbookEntry = LogbookEntry::find($notification->data['logbookEntryId']);

    	return [
    		'logbookEntryId' => $logbookEntry->id,
    		'logbookId' => $logbookEntry->logbook->id,
    		'logbookEntryCreator' => $logbookEntry->creator,
    		'lessonPackage' => new UserLessonResource($logbookEntry->logbook->userlesson),
    		'lessonPackageApprentice' => $logbookEntry->logbook->userlesson->user,
    		'objective' => $logbookEntry->logbook->objective->number
    	];
    }
}

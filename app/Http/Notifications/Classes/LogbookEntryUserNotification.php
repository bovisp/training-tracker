<?php

namespace TrainingTracker\Http\Notifications\Classes;

use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Http\Notifications\Classes\UserNotificationsInterface;
use TrainingTracker\Http\UserLessons\Resources\UserLessonResource;

class LogbookEntryUserNotification implements UserNotificationsInterface
{
	function __construct($notification)
	{
		$this->notification = $notification;

		$this->logbookEntry = $this->init();
	}

	public function collect()
	{
		return [
			'data' => $this->notification,
            'meta' => [
                'logbookEntryId' => $this->logbookEntry->id,
                'logbookId' => $this->logbookEntry->logbook->id,
                'logbookEntryCreator' => $this->logbookEntry->creator,
                'logbookEntryCommentEditor' => $this->logbookEntry->editor,
                'lessonPackage' => new UserLessonResource($this->logbookEntry->logbook->userlesson),
                'lessonPackageApprentice' => $this->logbookEntry->logbook->userlesson->user,
                'objective' => $this->logbookEntry->logbook->objective->number
            ]
		];
	}

	protected function init()
	{
		return LogbookEntry::find($this->notification->data['logbookEntryId']);
	}
}
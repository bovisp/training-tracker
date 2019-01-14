<?php

namespace TrainingTracker\Http\Notifications\Classes;

use TrainingTracker\Domains\Comments\Comment;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;
use TrainingTracker\Domains\Users\User;
use TrainingTracker\Http\Notifications\Classes\UserNotificationsInterface;
use TrainingTracker\Http\UserLessons\Resources\UserLessonResource;
use TrainingTracker\Http\Users\Resources\UserResource;

class LogbookCommentEntryUserNotification implements UserNotificationsInterface
{
	function __construct($notification)
	{
		$this->notification = $notification;

		$this->meta = $this->init();
	}

	public function collect()
	{
		return [
			'data' => $this->notification,
            'meta' => [
                'logbookCommentEntryId' => $this->meta['logbookCommentEntry']->id,
                'logbookId' => $this->meta['logbookEntry']->logbook->id,
                'logbookEntryId' => $this->meta['logbookEntry']->id,
                'logbookCommentEntryCreator' => $this->meta['logbookCommentEntry']->user,
                'logbookCommentEntryEditor' => new UserResource($this->meta['authUser']),
                'lessonPackage' => new UserLessonResource($this->meta['logbookEntry']->logbook->userlesson),
                'lessonPackageApprentice' => $this->meta['logbookEntry']->logbook->userlesson->user,
                'objective' => $this->meta['logbookEntry']->logbook->objective->number
            ]
		];
	}

	protected function init()
	{
		return [
			'logbookCommentEntry' => $logbookCommentEntry = Comment::find($this->notification->data['commentId']),
	        'authUser' => User::find($this->notification->data['authId']),
	        'logbookEntry' => LogbookEntry::find($logbookCommentEntry->commentable_id)
		];
	}
}
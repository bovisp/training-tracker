<?php

namespace TrainingTracker\App\Notifications;

use Illuminate\Notifications\Notification;
use TrainingTracker\Domains\Comments\Comment;

class LogbookEntryCommentNotification extends Notification
{
    public function __construct(Comment $comment, $type)
    {
        $this->comment = $comment;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'noteType' => $this->type,
            'logbookEntryId' => $this->comment->commentable->id,
            'userlessonId' => $this->comment->commentable->logbook->userlesson->id,
            'userlessonName' => number_format($this->comment->commentable->logbook->userlesson->lesson->number, 2) . " - {$this->comment->commentable->logbook->userlesson->lesson->name}",
            'userlessonUserId' => $this->comment->commentable->logbook->userlesson->user->id,
            'userlessonUserName' => "{$this->comment->commentable->logbook->userlesson->user->moodleuser->firstname} {$this->comment->commentable->logbook->userlesson->user->moodleuser->lastname}",
            'userId' => $this->comment->user->id,
            'userName' => "{$this->comment->user->moodleuser->firstname} {$this->comment->user->moodleuser->lastname}",
            'objectiveName' => "{$this->comment->commentable->logbook->objective->number} - {$this->comment->commentable->logbook->objective->name}"
        ];
    }
}

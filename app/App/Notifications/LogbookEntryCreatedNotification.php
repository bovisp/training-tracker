<?php

namespace TrainingTracker\App\Notifications;

use Illuminate\Notifications\Notification;
use TrainingTracker\Domains\LogbookEntries\LogbookEntry;

class LogbookEntryCreatedNotification extends Notification
{
    public function __construct(LogbookEntry $logbookEntry, $type)
    {
        $this->logbookEntry = $logbookEntry;
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
            'logbookEntryId' => $this->logbookEntry->id,
            'userlessonId' => $this->logbookEntry->logbook->userlesson->id,
            'userlessonName' => number_format($this->logbookEntry->logbook->userlesson->lesson->number, 2) . " - {$this->logbookEntry->logbook->userlesson->lesson->name}",
            'userlessonUserId' => $this->logbookEntry->logbook->userlesson->user->id,
            'userlessonUserName' => "{$this->logbookEntry->logbook->userlesson->user->moodleuser->firstname} {$this->logbookEntry->logbook->userlesson->user->moodleuser->lastname}",
            'creatorId' => $this->logbookEntry->creator->id,
            'creatorName' => "{$this->logbookEntry->creator->moodleuser->firstname} {$this->logbookEntry->creator->moodleuser->lastname}",
            'objectiveName' => "{$this->logbookEntry->logbook->objective->number} - {$this->logbookEntry->logbook->objective->name}"
        ];
    }
}

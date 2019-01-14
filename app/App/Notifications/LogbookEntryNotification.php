<?php

namespace TrainingTracker\App\Notifications;

use Illuminate\Notifications\Notification;

class LogbookEntryNotification extends Notification
{
    public function __construct($logbookEntry, $apprenticeId, $type)
    {
        $this->logbookEntry = $logbookEntry;
        $this->apprenticeId = $apprenticeId;
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
            'logbookEntryId' => $this->logbookEntry->id
        ];
    }
}

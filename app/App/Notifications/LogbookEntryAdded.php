<?php

namespace TrainingTracker\App\Notifications;

use Illuminate\Notifications\Notification;

class LogbookEntryAdded extends Notification
{
    public function __construct($logbookEntry, $apprenticeId)
    {
        $this->logbookEntry = $logbookEntry;
        $this->apprenticeId = $apprenticeId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'noteType' => 'logbook_entry_added',
            'logbookEntryId' => $this->logbookEntry->id
        ];
    }
}

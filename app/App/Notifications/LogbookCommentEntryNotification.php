<?php

namespace TrainingTracker\App\Notifications;

use Illuminate\Notifications\Notification;

class LogbookCommentEntryNotification extends Notification
{
    public function __construct($comment, $apprenticeId, $type, $authUser)
    {
        $this->comment = $comment;
        $this->apprenticeId = $apprenticeId;
        $this->type = $type;
        $this->authUser = $authUser;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'noteType' => $this->type,
            'commentId' => $this->comment->id,
            'authId' => $this->authUser->id
        ];
    }
}

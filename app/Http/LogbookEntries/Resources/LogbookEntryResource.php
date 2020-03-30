<?php

namespace TrainingTracker\Http\LogbookEntries\Resources;

use TrainingTracker\Domains\Users\User;
use Illuminate\Http\Resources\Json\JsonResource;
use TrainingTracker\Http\Users\Resources\UserResource;

class LogbookEntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at->format('m/d/Y'),
            'edited_at' => optional($this->edited_at)->format('m/d/Y'),
            'edited_by' => new UserResource(User::find($this->edited_by)),
            'created_by' => new UserResource(User::find($this->user_id)),
            'files' => unserialize($this->files),
            'logbook' => $this->logbook->id,
            'objective_id' => $this->logbook->objective->id
        ];
    }
}

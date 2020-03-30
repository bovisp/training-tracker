<?php

namespace TrainingTracker\Http\Users\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCommentResource extends JsonResource
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
            'profile' => $this->moodleuser()->get(),
            'role' => $this->roles->first()->type
        ];
    }
}

<?php

namespace TrainingTracker\Http\Users\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserCommentResource extends Resource
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

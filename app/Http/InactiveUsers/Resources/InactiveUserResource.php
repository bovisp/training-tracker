<?php

namespace TrainingTracker\Http\InactiveUsers\Resources;

use Illuminate\Http\Resources\Json\Resource;

class InactiveUserResource extends Resource
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
            'firstname' => $this->moodleuser->firstname,
            'lastname' => $this->moodleuser->lastname,
            'email' => $this->moodleuser->email
        ];
    }
}

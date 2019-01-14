<?php

namespace TrainingTracker\Http\Users\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'email' => $this->moodleuser->email,
            'role' => $this->roles->first()->type,
            'roleName' => $this->roles->first()->name,
            'roleRank' => $this->roles->first()->rank ? $this->roles->first()->rank : 0
        ];
    }
}

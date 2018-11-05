<?php

namespace TrainingTracker\Http\Objectives\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ObjectiveResource extends Resource
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
            'lesson' => $this->lesson->number,
            'objective' => $this->number,
            'description' => $this->name
        ];
    }
}

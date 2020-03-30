<?php

namespace TrainingTracker\Http\Objectives\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObjectiveResource extends JsonResource
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
            'lesson' => number_format($this->lesson->number, 2),
            'objective' => $this->number,
            'description' => $this->name
        ];
    }
}

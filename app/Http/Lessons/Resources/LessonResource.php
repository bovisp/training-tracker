<?php

namespace TrainingTracker\Http\Lessons\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LessonResource extends Resource
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
            'lesson' => $this->topic->number . '.' . sprintf('%02d', $this->number),
            'name' => $this->name,
            'depricated' => $this->depricated ? 'Yes' : 'No'
        ];
    }
}

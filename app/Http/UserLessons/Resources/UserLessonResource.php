<?php

namespace TrainingTracker\Http\UserLessons\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserLessonResource extends Resource
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
            'level' => $this->lesson->level->name,
            'package' => number_format($this->lesson->number, 2) . ' - ' . $this->lesson->name,
            'completed' => $this->completed === 1 ? 'Yes' : 'No'
        ];
    }
}

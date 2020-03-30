<?php

namespace TrainingTracker\Http\UserLessons\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLessonResource extends JsonResource
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
            'status' => $this->evaluateStatus()
        ];
    }
}

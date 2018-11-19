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
            'level' => $this->level->name, 
            'lesson' => number_format($this->number, 2),
            'name' => $this->name,
            'depricated' => $this->depricated ? trans('app.general.yes') : trans('app.general.no')
        ];
    }
}

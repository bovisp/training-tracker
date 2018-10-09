<?php

namespace TrainingTracker\Http\LogbookEntries\Resources;

use Illuminate\Http\Resources\Json\Resource;

class LogbookEntryFileResource extends Resource
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
            // 'codedFilename' => optional($this->codedFilename),
            // 'actualFilename' => optional($this->actualFilename)
        ];
    }
}

<?php

namespace TrainingTracker\Http\Comments\Resources;

use Illuminate\Http\Resources\Json\Resource;
use TrainingTracker\Http\Users\Resources\UserCommentResource;

class CommentResource extends Resource
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
            'body' => $this->body,
            'user' => new UserCommentResource($this->user),
            'created_at' => $this->created_at->format('d/m/Y')
        ];
    }
}

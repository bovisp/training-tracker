<?php

namespace TrainingTracker\Http\Comments\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use TrainingTracker\Http\Users\Resources\UserResource;

class CommentResource extends JsonResource
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
            'child' => !is_null($this->parent_id),
            'parent_id' => $this->parent_id,
            'children' => CommentResource::collection(
                $this->whenLoaded('children')
            ),
            'owner' => 
            	moodleauth()->user()->id === $this->user_id
            	|| 
            	moodleauth()->user()->roles->first()->type === 'administrator',
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at->format('m/d/Y'),
            'edited' => optional($this->edited_at)->format('m/d/Y'),
            'commentable' => $this->commentable
        ];
    }
}

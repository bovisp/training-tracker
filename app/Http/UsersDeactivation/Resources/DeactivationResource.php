<?php

namespace TrainingTracker\Http\UsersDeactivation\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeactivationResource extends JsonResource
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
            'deactivated_at' => $this->deactivated_at,
            'deactivation_rationale' => $this->deactivation_rationale,
            'reactivated_at' => $this->reactivated_at
        ];
    }
}

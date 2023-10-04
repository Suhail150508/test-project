<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "event" => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'user_type' => $this->user_type,
                'cover_image' => $this->coverImage ? $this->coverImage->source : null,
                'type' => $this->type,
                'name' => $this->name,
                'start_date_time' => date('d-m-Y h:i A',strtotime($this->start_date_time)),
                'end_date_time' => date('d-m-Y h:i A',strtotime($this->end_date_time)),
                'description' => $this->description,
                'speakers' => json_decode($this->speakers),
                'eventSpeakers' => $this->eventSpeakers ? $this->eventSpeakers : '',
                'created_at' => $this->created_at->diffForHumans(),
                'updated_at' => $this->updated_at->diffForHumans(),
                'event_members' => $this->eventMembers,
                'interestedCount' => $this->interestedCount,
                'goingCount' => $this->goingCount,
            ],
            "message" => trans($request->update ? 'event.updated' : 'event.created'),
        ];
    }
}

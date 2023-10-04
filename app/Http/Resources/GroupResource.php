<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "group" => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'user_type' => $this->user_type,
                'name' => $this->name,
                'description' => $this->description,
                'rules' => $this->rules,
                'invite_by_member' => $this->invite_by_member,
                'review_by_admin' => $this->review_by_admin,
                'profile_image' => $this->profileImage ? $this->profileImage->source : null,
                'background_image' => $this->backgroundImage ? $this->backgroundImage->source : null,
                'created_at' => $this->created_at->diffForHumans(),
                'updated_at' => $this->updated_at->diffForHumans(),
                'total_member' => $this->totalMember,
                'group_member' => $this->groupMembers,
            ],
            "message" => trans($request->update ? 'group.updated' : 'group.created'),
        ];
    }
}

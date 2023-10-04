<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GroupCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($group) {
                return [
                    'id' => $group->id,
                    'user_id' => $group->user_id,
                    'user_type' => $group->user_type,
                    'name' => $group->name,
                    'description' => $group->description,
                    'rules' => $group->rules,
                    'invite_by_member' => $group->invite_by_member,
                    'review_by_admin' => $group->review_by_admin,
                    'profile_image' => $group->profileImage ? $group->profileImage->source : null,
                    'background_image' => $group->backgroundImage ? $group->backgroundImage->source : null,
                    'created_at' => $group->created_at,
                    'updated_at' => $group->updated_at,
                    // 'alumni' => $group->alumni,
                    'total_member' => $group->totalMember,
                    'group_member' => $group->groupMembers,
                ];
            })
        ];
    }
}

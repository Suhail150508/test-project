<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "chapter" => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'user_type' => $this->user_type,
                'name' => $this->name,
                'description' => $this->description,
                'rules' => $this->rules,
                'profile_image' => $this->profileImage ? $this->profileImage->source : null,
                'background_image' => $this->backgroundImage ? $this->backgroundImage->source : null,
                'created_at' => $this->created_at->diffForHumans(),
                'updated_at' => $this->updated_at->diffForHumans(),
                'members' => $this->chapterMembers ? $this->chapterMembers : '',
                'totalMember' => $this->totalMember,
            ],
            "message" => trans($request->update ? 'chapter.updated' : 'chapter.created'),
        ];
    }
}

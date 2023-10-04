<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AchievementResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "achievement"=>parent::toArray($request),
            "message"=>trans($request->update ? 'achievement.updated': 'achievement.created')
        ];
    }
}

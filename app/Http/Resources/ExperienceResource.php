<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "experience"=>parent::toArray($request),
            "message"=>trans($request->update ? 'experience.experience_updated': 'experience.experience_created')
        ];
    }
}

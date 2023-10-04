<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "education"=>parent::toArray($request),
            "message"=>trans($request->update ? 'education.education_updated': 'education.education_created')
        ];
    }
}

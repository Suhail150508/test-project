<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSeekerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            "jobSeeker"=>parent::toArray($request),
            "success"=>trans($request->update ? 'jobSeeker.updated': 'jobSeeker.created')
        ];
    }
}

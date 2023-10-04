<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "skill"=>parent::toArray($request),
            "success"=>trans($request->update ? 'workshop.updated': 'workshop.created')
        ];
    }
}

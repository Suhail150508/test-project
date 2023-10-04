<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "designation"=>parent::toArray($request),
            "message"=>trans($this->update ? 'designation.updated': 'designation.created')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceCccResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "resource"=>parent::toArray($request),
            "success"=>trans($request->update ? 'resource.updated': 'resource.created')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WhoWeAreResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "whoWeAre"=>parent::toArray($request),
            "success"=>trans($request->update ? 'whoWeAre.updated': 'whoWeAre.created')
        ];
    }
}

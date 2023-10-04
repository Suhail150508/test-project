<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubMediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "clubMedia"=>parent::toArray($request),
            "success"=>trans($request->update ? 'clubMedia.updated': 'clubMedia.created')
        ];
    }
}

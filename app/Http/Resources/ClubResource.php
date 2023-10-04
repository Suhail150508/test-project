<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "club"=>parent::toArray($request),
            "success"=>trans($request->update ? 'club.updated': 'club.created')
        ];
    }
}

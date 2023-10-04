<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "partner"=>parent::toArray($request),
            "success"=>trans($request->update ? 'partner.updated': 'partner.created')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "district"=>parent::toArray($request),
            "message"=>trans($this->update ? 'district.updated': 'district.created')
        ];
    }
}

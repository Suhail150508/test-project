<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "country"=>parent::toArray($request),
            "message"=>trans($this->update ? 'country.updated': 'country.created')
        ];
    }
}

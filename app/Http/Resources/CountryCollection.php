<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($country) {
                return [
                    
                    'id' => $country->id,
                    'name' => $country->name,
                    'bn_name' => $country->bn_name,
                    'code' => $country->code,
                    'status' => $country->status,
                ];
            })
        ];
    }
}

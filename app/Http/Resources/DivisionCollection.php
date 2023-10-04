<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DivisionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($division) {
                return [
                    'id' => $division->id,
                    'name' => $division->name,
                    'bn_name' => $division->bn_name,
                    'status' => $division->status,
                ];
            })
        ];
    }
}

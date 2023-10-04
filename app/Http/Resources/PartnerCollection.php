<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PartnerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($partners) {
                return [
                    'id' => $partners->id,
                    'company_name' => $partners->company_name,
                    'slug' => $partners->slug,
                    'description' => $partners->description,
                    'image' => $partners->partner->source,
                    'order_place' => $partners->order_place,
                    'status' => $partners->status,
                ];
            })
        ];
    }
}

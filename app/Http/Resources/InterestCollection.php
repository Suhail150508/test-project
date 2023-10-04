<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InterestCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($interests) {
                return [
                    'id' => $interests->id,
                    'title' => $interests->title,
                    'slug' => $interests->slug,
                    'description' => $interests->description,
                    'status' => $interests->status,
                ];
            })
        ];
    }
}

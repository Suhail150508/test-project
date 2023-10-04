<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MarqueeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($marquees) {
                return [
                    'id' => $marquees->id,
                    'title' => $marquees->title,
                    'url' => $marquees->url,
                    'status' => $marquees->status,
                ];
            })
        ];
    }
}

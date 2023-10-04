<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WhoWeAreCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($whoWeAre) {
                return [
                    'id' => $whoWeAre->id,
                    'title' => $whoWeAre->title,
                    'description' => $whoWeAre->description,
                    'video' => $whoWeAre->whoWeAre ? $whoWeAre->whoWeAre->source : "",
                    'status' => $whoWeAre->status,
                ];
            })
        ];
    }
}

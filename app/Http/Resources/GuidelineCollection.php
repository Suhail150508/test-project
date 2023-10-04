<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GuidelineCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($guidelines) {
                return [
                    'id' => $guidelines->id,
                    'title' => $guidelines->title,
                    'slug' => $guidelines->slug,
                    'description' => $guidelines->description,
                    'type' => $guidelines->type,
                    'status' => $guidelines->status,
                ];
            })
        ];
    }
}

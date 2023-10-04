<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MajorMinorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($mejorminor) {
                return [
                    'id' => $mejorminor->id,
                    'title' => $mejorminor->title,
                    'description' => $mejorminor->description,
                    'status' => $mejorminor->status,
                    'image' => $mejorminor->image ?: null,
                ];
            })
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CccUpdatesCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($cccUpdates) {
                return [
                    'id' => $cccUpdates->id,
                    'types' => $cccUpdates->types,
                    'semester_and_year' => $cccUpdates->semester_and_year ? $cccUpdates->semester_and_year : null,
                    'title' => $cccUpdates->title,
                    'slug' => $cccUpdates->slug,
                    'image' => $cccUpdates->ccc_updates ? $cccUpdates->ccc_updates->source : "",
                    'description' => $cccUpdates->description,
                    'published' => $cccUpdates->published,
                ];
            })
        ];
    }
}

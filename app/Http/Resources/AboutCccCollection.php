<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AboutCccCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($aboutCcc) {
                return [
                    'id' => $aboutCcc->id,
                    /*'title' => $aboutCcc->title,
                    'slug' => $aboutCcc->slug,*/
                    'prelude' => $aboutCcc->prelude,
                    'objectives' => $aboutCcc->objectives,
                    'mission' => $aboutCcc->mission,
                    'conclusion' => $aboutCcc->conclusion,
                    'status' => $aboutCcc->status
                ];
            })
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AudioVideoCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($audiovideo) {
                return [
                    'id' => $audiovideo->id,
                    'title' => $audiovideo->title,
                    'description' => $audiovideo->description,
                    'file' => $audiovideo->ccc_audiovideo->source,
                ];
            })
        ];
    }
}

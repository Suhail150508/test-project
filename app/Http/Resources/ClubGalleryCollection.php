<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClubGalleryCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($clubGallery) {
                return [
                    'id' => $clubGallery->id,
                    'club' => $clubGallery->club,
                    'title' => $clubGallery->title,
                    'club_gallery_image' => $clubGallery->clubGallery ? $clubGallery->clubGallery->source : "",
                    'status' => $clubGallery->status,
                ];
            })
        ];
    }
}

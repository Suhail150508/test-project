<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClubSliderCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($club_slider) {
                return [
                    'id' => $club_slider->id,
                    'club_id' => $club_slider->club_id,
                    'title' => $club_slider->title,
                    'sub_title' => $club_slider->sub_title,
                    'description' => $club_slider->description,
                    'url' => $club_slider->url,
                    'status' => $club_slider->status,
                    'image' => $club_slider->clubSliderImage ? $club_slider->clubSliderImage->source : "",
                ];
            })
        ];
    }
}

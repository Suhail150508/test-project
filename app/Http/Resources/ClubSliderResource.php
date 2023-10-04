<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubSliderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "club_slider" => [
                'id' => $this->id,
                'club_id' => $this->club_id,
                'title' => $this->title,
                'sub_title' => $this->sub_title,
                'description' => $this->description,
                'url' => $this->url,
                'status' => $this->status,
                'image' => $this->clubSliderImage ? $this->clubSliderImage->source : "",
            ],
            "message" => $request->update ? 'Club slider successfully updated' : 'Club slider successfully created',
        ];
    }
}

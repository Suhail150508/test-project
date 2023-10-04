<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutCccResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'prelude' => $this->prelude,
            'objectives' => $this->objectives,
            'mission' => $this->mission,
            'conclusion' => $this->conclusion,
            'status' => $this->status
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CareerTipsResource extends JsonResource
{
    public function toArray($request)
    {
        // dd($request->all());
        return [
            "careerTips" => [
                'id' => $this->id,
                'title' => $this->title,
                'slug' => $this->slug,
                'body' => $this->body,
                'image' => $this->careerTips->source,
                // 'published' => (bool)$this->published,
                // 'is_used' => (bool)$this->is_used
            ],
            "message" => trans($request->update ? 'careerTips.updated' : 'careerTips.created')
        ];
    }
}

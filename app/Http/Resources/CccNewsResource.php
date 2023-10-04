<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CccNewsResource extends JsonResource
{
    public function toArray($request)
    {
        // dd($request->all());
        return [
            "cccNews" => [
                'id' => $this->id,
                'categories' => $this->categories,
                'title' => $this->title,
                'slug' => $this->slug,
                'body' => $this->body,
                'image' => $this->ccc_news->source,
                // 'published' => (bool)$this->published,
                // 'is_used' => (bool)$this->is_used
            ],
            "message" => trans($request->update ? 'cccnews.updated' : 'cccnews.created')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OffensiveWordResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "offensiveWords" => [
                'id' => $this->id,
                'keyword' => $this->keyword,
                'status' => $this->status,
                'created_at' => $this->created_at->diffForHumans(),
                'updated_at' => $this->updated_at->diffForHumans(),
            ],
            "message" => trans($request->update ? 'offenssive_words.updated' : 'offenssive_words.created'),
        ];
    }
}

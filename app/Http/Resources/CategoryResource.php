<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "category" => [
                'id' => $this->id,
                'name' => $this->name,
                'slug' => $this->slug,
                'status' => $this->status,
            ],
            "message" => trans($request->update ? 'category.updated' : 'category.created')
        ];
    }
}

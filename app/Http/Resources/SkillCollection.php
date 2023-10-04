<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SkillCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($skills) {
                return [
                    'id' => $skills->id,
                    'title' => $skills->title,
                    'description' => $skills->description,
                    'categories' => $skills->categories,
                    'subCategories' => $skills->subCategories,
                    'status' => $skills->status,
                ];
            })
        ];
    }
}

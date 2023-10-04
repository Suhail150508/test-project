<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CccNewsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($cccnews) {
                return [
                    'id' => $cccnews->id,
                    'categories' => $cccnews->subCategories,
                    'title' => $cccnews->title,
                    'slug' => $cccnews->slug,
                    'body' => $cccnews->body,
                    'image' => $cccnews->ccc_news->source,
                    'published' => (bool)$cccnews->published,
                    'is_used' => (bool)$cccnews->is_used
                ];
            })
        ];
    }
}

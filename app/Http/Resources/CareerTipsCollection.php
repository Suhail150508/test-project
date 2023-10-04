<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CareerTipsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($careerTips) {
                return [
                    'id' => $careerTips->id,
                    'categories' => $careerTips->categories,
                    'title' => $careerTips->title,
                    'slug' => $careerTips->slug,
                    'body' => $careerTips->body,
                    'image' => @$careerTips->careerTips->source,
                    'published' => (bool)$careerTips->published,
                ];
            })
        ];
    }
}

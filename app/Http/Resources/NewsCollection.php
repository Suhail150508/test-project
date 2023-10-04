<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($news) {
                return [
                    'id' => $news->id,
                    'categories' => $news->categories,
                    'semester_year' => $news->semester_and_year,
                    'place' => $news->place,
                    'title' => $news->title,
                    'slug' => $news->slug,
                    'description' => $news->description,
                    'semester_and_year' => $news->semester_and_year,
                    'types' => $news->types,
                    'images' => $news->news ? $news->news : null,
                    'status' => $news->status,
                    'publish_date' => $news->created_at->format('F d, Y'),
                ];
            })
        ];
    }
}

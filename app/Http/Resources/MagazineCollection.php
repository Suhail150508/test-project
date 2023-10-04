<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MagazineCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($magazines) {
                return [
                    'id' => $magazines->id,
                    'name' => $magazines->name,
                    'title' => $magazines->title,
                    'sort_description' => $magazines->sort_description,
                    'description' => $magazines->description,
                    'about' => $magazines->about,
                    'publish_date' => $magazines->publish_date,
                ];
            })
        ];
    }
}

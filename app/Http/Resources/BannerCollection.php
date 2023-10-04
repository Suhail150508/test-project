<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BannerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($banner) {
                return [
                    'id' => $banner->id,
                    'name' => $banner->name,
                    'title' => $banner->title,
                    'description' => $banner->description,
                    'status' => $banner->status,
                ];
            })
        ];
    }
}

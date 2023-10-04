<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SeoCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($seo) {
                return [
                    'id' => $seo->id,
                    'site' => $seo->site,
                    'module' => $seo->module,
                    'page' => $seo->page,
                    'page_url' => $seo->page_url,
                    'title' => $seo->title,
                    'keywords' => $seo->keywords,
                    'description' => $seo->description
                ];
            })
        ];
    }
}

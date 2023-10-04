<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "seo" => [
                'id' => $this->id,
                'site' => $this->site,
                'module' => $this->module,
                'page' => $this->page,
                'page_url' => $this->page_url,
                'title' => $this->title,
                'keywords' => $this->keywords,
                'description' => $this->description
            ],
            "message" => trans($request->update ? 'seo.updated' : 'seo.created')
        ];
    }
}

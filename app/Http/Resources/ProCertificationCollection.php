<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProCertificationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($ProCertifications) {
                return [
                    'id' => $ProCertifications->id,
                    'title' => $ProCertifications->title,
                    'slug' => $ProCertifications->slug,
                    'description' => $ProCertifications->description,
                    'organization' => $ProCertifications->organization,
                    'duration' => $ProCertifications->duration,
                    'status' => $ProCertifications->status,
                ];
            })
        ];
    }
}

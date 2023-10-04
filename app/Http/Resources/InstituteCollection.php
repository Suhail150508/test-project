<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InstituteCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($institute) {
                return [
                    'id' => $institute->id,
                    'name' => $institute->name,
                    'type' => $institute->type,
                    'status' => $institute->status,
                ];
            })
        ];
    }
}

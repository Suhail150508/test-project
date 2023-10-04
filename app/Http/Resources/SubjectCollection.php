<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubjectCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($subjects) {
                return [
                    'id' => $subjects->id,
                    'name' => $subjects->name,
                    'type' => $subjects->type,
                    'status' => $subjects->status,
                ];
            })
        ];
    }
}

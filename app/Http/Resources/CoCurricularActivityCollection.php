<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CoCurricularActivityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($co_curricular) {
                return [
                    'id' => $co_curricular->id,
                    'title' => $co_curricular->title,
                    'description' => $co_curricular->description,
                    'status' => $co_curricular->status,
                ];
            })
        ];
    }
}

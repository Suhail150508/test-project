<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CreateMailListCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($createMailList) {
                return [
                    'id' => $createMailList->id,
                    'title' => $createMailList->title,
                    'status' => $createMailList->status,
                ];
            })
        ];
    }
}

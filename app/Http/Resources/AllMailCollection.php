<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllMailCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($allMailList) {
                return [
                    'id' => $allMailList->id,
                    'email' => $allMailList->email,
                    'status' => $allMailList->status,
                ];
            })
        ];
    }
}

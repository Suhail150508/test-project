<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CccUpdatesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "cccUpdates"=>parent::toArray($request),
            "success"=>trans($request->update ? 'cccUpdates.updated': 'cccUpdates.created')
        ];
    }
}

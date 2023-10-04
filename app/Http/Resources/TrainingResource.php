<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrainingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "skill"=>parent::toArray($request),
            "success"=>trans($request->update ? 'training.updated': 'training.created')
        ];
    }
}

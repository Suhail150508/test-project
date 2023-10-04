<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MajorMinorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            "status" => $this->status,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "message" => trans($request->update ? "majorminor.updated": "majorminor.created"),
        ];
    }
}

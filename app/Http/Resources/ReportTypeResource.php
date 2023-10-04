<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "data" => [
                'id' => $this->id,
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'status' => $this->status,
            ],
            "message" => trans($request->update ? 'report_type.updated' : 'report_type.created'),
        ];
    }
}

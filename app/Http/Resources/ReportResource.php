<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "data" => [
                'id' => $this->id,
                'sender_id' => $this->sender_id,
                'recipient_id' => $this->recipient_id,
                'attribute' => $this->attribute,
                'attribute_id' => $this->attribute_id,
                'report_type_id' => $this->report_type_id,
                'description' => $this->description,
            ],
            "message" => trans($request->update ? 'report.updated' : 'report.created'),
        ];
    }
}

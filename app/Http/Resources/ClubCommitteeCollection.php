<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClubCommitteeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($clubCommittee) {
                return [
                    'id' => $clubCommittee->id,
                    'type' => $clubCommittee->type,
                    'name' => $clubCommittee->name,
                    'department' => $clubCommittee->department,
                    'designation' => $clubCommittee->designation,
                    'department_id' => $clubCommittee->department_id,
                    'designation_id' => $clubCommittee->designation_id,
                    'date_from' => $clubCommittee->date_from,
                    'committee_image' => $clubCommittee->clubCommitteePhoto ? $clubCommittee->clubCommitteePhoto->source : "",
                    'date_to' => $clubCommittee->date_to,
                    'status' => $clubCommittee->status,
                ];
            })
        ];
    }
}

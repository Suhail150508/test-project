<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;

class WorkshopApplicationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($workshopApplications) {
                return [
                    'id' => $workshopApplications->id,
                    'workshop_id' => $workshopApplications->workshop_id,
                    'user_id' => $workshopApplications->user_id,
                    'workshop' => $workshopApplications->workshop,
                    'user' => $workshopApplications->user,
                    'status' => $workshopApplications->status,
                    'applyed_date' => $workshopApplications->created_at->format('Y-m-d'),
                    
                ];
            })
        ];
    }
}

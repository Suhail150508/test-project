<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClubModeratorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($clubModerator) {
                return [
                    'id' => $clubModerator->id,
                    'type' => $clubModerator->type,
                    'name' => $clubModerator->name,
                    'department' => $clubModerator->department,
                    'designation' => $clubModerator->designation,
                    'department_id' => $clubModerator->department_id,
                    'designation_id' => $clubModerator->designation_id,
                    'year_from' => $clubModerator->year_from,
                    'moderator_image' => $clubModerator->clubModeratorPhoto ? $clubModerator->clubModeratorPhoto->source : "",
                    'year_to' => $clubModerator->year_to,
                    'status' => $clubModerator->status,
                ];
            })
        ];
    }
}

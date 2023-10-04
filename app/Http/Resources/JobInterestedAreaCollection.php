<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Department;

class JobInterestedAreaCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($jobinterestedarea) {
                return [
                    'id' => $jobinterestedarea->id,
                    'department' => $jobinterestedarea->department,
                    'department_id' => $jobinterestedarea->department_id,
                    'title' => $jobinterestedarea->title,
                    'description' => $jobinterestedarea->description,
                    'status' => $jobinterestedarea->status,
                ];
            }),
            'departments' => Department::query()->get(),
        ];
    }
}


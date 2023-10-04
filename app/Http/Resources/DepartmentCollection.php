<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($department) {
                return [
                    'id' => $department->id,
                    'department_code' => $department->department_code,
                    'title' => $department->title,
                    'description' => $department->description,
                    'status' => $department->status,
                ];
            })
        ];
    }
}

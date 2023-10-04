<?php

namespace App\Http\Resources;

use App\Models\Designation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentWelfareCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($studentWelfares) {
                return [
                    'id' => $studentWelfares->id,
                    'name' => $studentWelfares->name,
                    'designation_id' => $studentWelfares->designation_id,
                    'designation' => $studentWelfares->designation,
                    'contact_hours_from' => date("H:i A",strtotime($studentWelfares->contact_hours_from)),
                    'contact_hours_to' => date("H:i A",strtotime($studentWelfares->contact_hours_to)),
                    'contact_no' => $studentWelfares->contact_no,
                    'image' => $studentWelfares->student_welfare->source,
                    'status' => $studentWelfares->status,
                ];
            }),
            'designations' => Designation::query()->get(),
        ];
    }
}

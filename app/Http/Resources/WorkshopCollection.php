<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;


class WorkshopCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($workshops) {
                return [
                    'id' => $workshops->id,
                    'title' => $workshops->title,
                    'slug' => $workshops->slug,
                    'description' => $workshops->description,
                    'start_date' => $workshops->start_date,
                    'current_date' => Carbon::now()->format('Y-m-d'),
                    'end_date' => $workshops->end_date,
                    'status' => $workshops->status,
                    'workshop_applications' => $workshops->workshop_applications?$workshops->workshop_applications->count():"",
                    'user' => $workshops->user,
                ];
            })
        ];
    }
}
